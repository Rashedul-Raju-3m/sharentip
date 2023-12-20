<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CartHelper;
use App\Models\Event;
use App\Models\OrderBilling;
use App\Models\OrderHead;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;
use App\Models\User;
use App\Models\Review;
use App\Models\Ticket;
use App\Models\Coupon;
use App\Models\Tax;
use App\Models\OrderTax;
use App\Models\AppUser;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Order;
use App\Models\Setting;
use App\Models\PaymentSetting;
use App\Models\NotificationTemplate;
use App\Models\EventReport;
use App\Models\OrderChild;
use App\Models\Notification;
use Auth;
use App;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use OneSignal;
use Stripe;
use Rave;
use QrCode;
use Redirect;
use Carbon\Carbon;
use App\Mail\ResetPassword;
use App\Mail\TicketBook;
use App\Mail\TicketBookOrg;
use App\Models\Language;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;


class CartController extends Controller
{
    public function home(){
        if(env('DB_DATABASE')==null){
            return view('admin.frontpage');
        }
        else{
            $setting = Setting::first(['app_name','logo']);

            SEOMeta::setTitle($setting->app_name.' - Home' ?? env('APP_NAME'))
            ->setDescription('This is home page')
            ->setCanonical(url()->current())
            ->addKeyword(['home page', $setting->app_name , $setting->app_name.' Home']);

            OpenGraph::setTitle($setting->app_name.' - Home' ?? env('APP_NAME'))
            ->setDescription('This is home page')
            ->setUrl(url()->current());

            JsonLdMulti::setTitle($setting->app_name.' - Home' ?? env('APP_NAME'));
            JsonLdMulti::setDescription('This is home page');
            JsonLdMulti::addImage($setting->imagePath . $setting->logo);

            SEOTools::setTitle($setting->app_name.' - Home' ?? env('APP_NAME'));
            SEOTools::setDescription('This is home page');
            SEOTools::opengraph()->setUrl(url()->current());
            SEOTools::setCanonical(url()->current());
            SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);

            $timezone = Setting::find(1)->timezone;
            $date = Carbon::now($timezone);
            $events  = Event::with(['category:id,name'])
            ->where([['status',1],['is_deleted',0],['event_status','Pending'],['end_time', '>',$date->format('Y-m-d H:i:s')]])
            ->orderBy('start_time','ASC')->get();
            $organizer = User::role('organization')->orderBy('id','DESC')->get();
            $category = Category::where('status',1)->orderBy('id','DESC')->get();
            $blog = Blog::with(['category:id,name'])->where('status',1)->orderBy('id','DESC')->get();
            foreach ($events as $value) {
                $value->total_ticket = Ticket::where([['event_id',$value->id],['is_deleted',0],['status',1]])->sum('quantity');
                $value->sold_ticket = Order::where('event_id',$value->id)->sum('quantity');
                $value->available_ticket = $value->total_ticket - $value->sold_ticket;
            }
            $serviceCategorys = ServiceCategory::where([['is_active',1],['is_delete',0]])
                ->orderBy('id','ASC')->get();
            return view('frontend.home',compact('events','organizer','category','blog','serviceCategorys'));
        }

    }

    public function itemAddedIntoCart(){

        $itemName = $_GET['itemName'];
        $itemDescription = $_GET['itemDescription'];
        $unitPrice = $_GET['unitPrice'];
        $itemQuantity = $_GET['itemQuantity'];
        $itemID = $_GET['itemID'];
        $serviceCategory = $_GET['serviceCategory'];
        $serviceId = $_GET['serviceId'];
        $image = $_GET['image'];
        $company_name = $_GET['company_name'];
        $order_quantity = $_GET['order_quantity'];
        $ticket = isset($_GET['ticket'])?$_GET['ticket']:null;
        $orderItemId = isset($_GET['order_item_id'])?$_GET['order_item_id']:null;

        $added_items = [];
        $cart = [];
        if(isset($itemID)){

            $serviceItem = ServiceItem::where('id',$itemID)->first();

            if(!empty($serviceItem))
            {
                $item['item_id'] = $itemID;
                $item['item_name'] = $itemName;
                $item['item_description'] = $itemDescription;
                $item['unit_price'] = $unitPrice;
                $item['item_quantity'] = $itemQuantity;
                $item['service_category_id'] = $serviceCategory;
                $item['service_id'] = $serviceId;
                $item['image'] = $image;
                $item['company_name'] = $company_name;
                $item['order_quantity'] = $order_quantity;
                $item['order_item_id'] = $orderItemId;
                if (isset($ticket) && !empty($ticket)){
                    $item['ticket'] = $ticket;
                }

                $cart = CartHelper::addItem($item);
            }

            $response = [];

            if(count($cart) > 0)
            {

//                $cart_body = \Illuminate\Support\Facades\View::make('frontend.cart._cart');
//                $contents = $cart_body->render();

                $response['result'] = 'success';
                $response['message'] = 'Item successfully added to cart.';
                $response['total_item'] = count($cart);
//                $response['cart_total'] = $cart_total;
                $response['item'] = $item;
//                $response['cart_body'] = $contents;

            }else{
                $response['result'] = 'error';
                $response['message'] = 'Product not added to cart.';
            }

            return $response;

        }
    }

    public function itemUpdateIntoCart(){
        $itemId = $_GET['itemId'];
        $orderQuantity = $_GET['orderQuantity'];

        $items['item_id'] = $itemId;
        $items['order_quantity'] = $orderQuantity;
        $carts = CartHelper::update($items);

        $response['order_quantity'] = $orderQuantity;
        $totalAmount = 0;
        $totalOrderQty = 0;
        foreach ($carts as $cart ){
            $totalOrderQty =$totalOrderQty+ $cart['order_quantity'];
            $totalAmount =$totalAmount+ $cart['subtotal'];
            if ($itemId == $cart['item_id']){
                $response['subtotal'] =number_format($cart['subtotal'],2);
            }
        }
        $referDiscount = 0;
        if ($totalOrderQty>1){
            $referDiscount = ($totalOrderQty-1)*200;
        }
        $response['total_order_qty'] = $totalOrderQty;
        $response['refer_discount'] = number_format($referDiscount,2);
        $response['total_amount'] = number_format($totalAmount,2);
        $response['total_amount_without_refer'] = number_format($totalAmount-$referDiscount,2);
//        dd($response);
        return $response;
    }

    public function cartDetails(){
        $cart_items = [];
        if(Session::has('cart')){
            $cart_items = Session::get('cart');
        }

        $cart_total = [];
        if(Session::has('cart_total')){
            $cart_total = Session::get('cart_total');
        }
        return view('frontend.cart.cart_details',compact('cart_items','cart_total'));
    }

    public function cartItemRemove($id){
        $cart = CartHelper::remove_item($id);
        return redirect()->route('cart_details');
    }

    public function orderPlaceNext(Request $request){
        $data = $request->all();
        $data['message'] = 'next';
        $cartItems = Session::get('cart');
        $subTotal = 0;
        $totalAmount = 0;
        $totalQuantity = 0;
        $referDiscount = 0;
        foreach ($cartItems as $item){
            $subTotal = $subTotal+$item['subtotal'];
            $totalAmount = $subTotal;
            $totalQuantity = $totalQuantity+$item['order_quantity'];
        }
        if ($totalQuantity>1){
            $referDiscount = ($totalQuantity-1)*200;
            $totalAmount = $totalAmount-$referDiscount;
            $totalAmount = $totalAmount-(($totalQuantity-1)*200);
        }
        $data['totalQuantity'] = $totalQuantity;
        $data['referDiscount'] = $referDiscount;
        $data['subTotal'] = number_format($subTotal,2);
        $data['totalAmount'] = number_format($totalAmount,2);
        $data['payment_type'] = 'LOCAL';
        return view('frontend.cart.tour_cart_details_billing',compact('data','cartItems'));
    }

    public function onlinePayment(){
        return view('frontend.cart.online_payment');
    }

    public function orderPlace(Request $request){
        $input = $request->all();
        if ($input['payment_type'] === 'PAYPAL'){
            return redirect()->route('online_payment');
        }
        $cartItems = [];
        if(Session::has('cart')){
            $cartItems = Session::get('cart');
        }
        $user = Auth::guard('appuser')->user();
//        dd($input,$cartItems,$user);

        $latestOrder = OrderHead::latest()->first();

        if ($latestOrder){
            $code = substr($latestOrder->order_id, -5);
            $num = $code+1;
        }else{
            $num = 1;
        }
        $orderInput['order_id'] = 'ICS-'.date('d').date('m').date('y').'-'.$this->getSequence($num);
        if ($input['payment_type'] === 'LOCAL'){
            $orderInput['payment_type'] = 'cod';
        }else{
            $orderInput['payment_type'] = 'bank';
        }
        $orderInput['user_id'] = $user?$user->id:null;
        $orderInput['total_item'] = count($cartItems);
        $orderInput['tour_date'] = $input['tour_date'];
        $orderInput['pick_up_point'] = $input['pick_up_point'];
        $orderInput['referer_number'] = $input['referer_number'];
        $orderInput['transaction_number'] = $input['transaction_number'];
        $orderInput['order_quantity'] = $input['totalQuantity'];
        $orderInput['sub_total'] = str_replace( ',', '', $input['subTotal'] );
        $orderInput['refer_discount'] = str_replace( ',', '', $input['referDiscount'] );
        $orderInput['total_price'] = str_replace( ',', '', $input['totalAmount'] );
        $orderInput['status'] = 'Pending';

//        dd($cartItems);

        DB::beginTransaction();
        try {
            $orderHead = OrderHead::create($orderInput);
//            dd($orderHead);
            if ($orderHead){
                foreach ($cartItems as $item){
                    /*"item_id" => 94
                    "serviceName" => "Cox's Bazar"
                    "item_name" => "Child"
                    "unit_price" => 1699.0
                    "item_quantity" => "1"
                    "image" => "64232ed22cb1e.jpg"
                    "service_id" => "1"
                    "order_quantity" => "2"
                    "subtotal" => 3398.0*/
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $orderHead->id;
                    $orderItem->item_id = $item['item_id'];
                    $orderItem->item_name = $item['item_name'];
                    $orderItem->item_description = isset($item['item_description'])?$item['item_description']:null;
                    $orderItem->item_price = $item['subtotal'];
                    $orderItem->order_quantity = $item['order_quantity'];
                    $orderItem->bundle_quantity = null;
                    $orderItem->service_category_id = isset($item['service_category_id'])?$item['service_category_id']:null;
                    $orderItem->service_id = $item['service_id'];
                    $orderItem->order_item_id = isset($item['order_item_id']) && $item['order_item_id'] ? $item['order_item_id']:null;

                    /*if (isset($item['order_item_id']) && $item['order_item_id'] != null){
                        $mainOrderItem = OrderItem::find($item['order_item_id']);
                        $getOrder = OrderHead::find($mainOrderItem->order_id);
                        $getEvent = Event::find($getOrder->event_id);
                        $totalSold = $getEvent->sold+$item['order_quantity'];
                        $soldTicket = OrderItem::where('order_item_id',$item['order_item_id'])->sum('order_quantity');
                        $mainOrderItem->update([
                            'sold' => $soldTicket+$item['order_quantity']
                        ]);
                        $getEvent->update([
                            'sold' => $totalSold
                        ]);
                    }*/
                    $orderHead->OrderItem()->save($orderItem);
                    CartHelper::remove_item($item['item_id']);
                }

                $orderBilling = new OrderBilling();
                $orderBilling->order_id = $orderHead->id;
                $orderBilling->name = $input['name'];
                $orderBilling->last_name =$input['last_name'];
                $orderBilling->email = $input['email'];
                $orderBilling->mobile = $input['phone'];
                $orderBilling->address = $input['address']?$input['address']:null;
//                $orderBilling->address2 = $input['address2']?$input['address2']:null;
//                $orderBilling->country = $input['country']?$input['country']:null;
//                $orderBilling->division = $input['division']?$input['division']:null;
//                $orderBilling->district = $input['district']?$input['district']:null;
//                $orderBilling->upazila = $input['upazila']?$input['upazila']:null;
                $orderHead->orderBilling()->save($orderBilling);

//                $msg = "Order place successfully";
//                $msg = wordwrap($msg,70);
//                mail($input['email'],"Order Place",$msg);
            }

            DB::commit();
//            return redirect()->route('cart_details')->withStatus($orderHead);
            return view('frontend.cart.tour_cart_details_billing',compact('orderHead'));

        } catch (\Exception $e) {
            DB::rollback();
            print($e->getMessage());
            exit();
            Session::flash('danger', $e->getMessage());
        }
    }
    function getSequence($num) {
        return sprintf("%'.05d", $num);
    }

    public function userOrderBillingInfoUpdate(Request $request,$id){
        $data = $request->all();
        $orderBilling =  OrderBilling::where('order_id',$id)->first();
        $orderBilling->update([
            'email' => $data['email'],
            'mobile' => $data['phone'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'address' => $data['address1']?$data['address1']:$data['address2'],
            'country' => $data['country'],
            'division' => $data['division'],
            'district' => $data['district'],
            'upazila' => $data['upazila']

        ]);
        return redirect()->route('cart_details')->withStatus(OrderHead::find($id));
    }

    public function tourCartDetails($id,$slug){
        $services = DB::table('service_category')
                                ->select([
                                    'service_category.name as service_name',
                                    'service_category.image as image',
                                    'service_item.id as item_id',
                                    'service_item.item_name as item_name',
                                    'service_item.item_quantity as item_quantity',
                                    'service_item.item_price as item_price',
                                ])
                                ->join('service_item','service_item.service_category_id','=','service_category.id')
                                ->where('service_category.is_active',1)
                                ->where('service_category.id',$id)
                                ->get();

        if (sizeof($services)>0){
            Session::flush();
            foreach ($services as $service){
                $item['item_id'] = $service->item_id;
                $item['serviceName'] = $service->service_name;
                $item['item_name'] = $service->item_name;
                $item['unit_price'] = $service->item_price;
                $item['item_quantity'] = $service->item_quantity;
                $item['image'] = $service->image;
                $item['service_id'] = $id;
                $item['order_quantity'] = 0;
//                $item['refer_discount'] = 0;
                CartHelper::addItem($item);
            }
        }
        $serviceName = $services[0]->service_name;

        $cart_items = [];
        if(Session::has('cart')){
            $cart_items = Session::get('cart');
        }
        $cart_total = [];
        if(Session::has('cart_total')){
            $cart_total = Session::get('cart_total');
        }

        return view('frontend.cart.tour_cart_details',compact('cart_items','serviceName','cart_total'));
    }

}
