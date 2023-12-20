<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CartHelper;
use App\Models\Event;
use App\Models\Category;
use App\Models\EventService;
use App\Models\OrderBilling;
use App\Models\OrderHead;
use App\Models\OrderItem;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Order;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\AppUser;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(Auth::user()->hasRole('admin')){
            $events = Event::with(['category','organization'])->where('is_deleted',0)->orderBy('id','DESC')->get();
        }
        elseif(Auth::user()->hasRole('organization')){
            $events = Event::with(['category','organization'])->where([['user_id',Auth::user()->id],['is_deleted',0]])->orderBy('id','DESC')->get();
            foreach ($events as $value) {
                $value->scanner = User::find($value->scanner_id);
            }
        }

        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category = Category::where('status',1)->orderBy('id','DESC')->get();
        $users = User::role('organization')->orderBy('id','DESC')->get();
        if(Auth::user()->hasRole('admin')){
            $scanner = User::role('scanner')->orderBy('id','DESC')->get();
        }
        else if(Auth::user()->hasRole('organization')){
            $scanner = User::role('scanner')->where('org_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        $setting = Setting::find(1);
        $serviceCategory = ServiceCategory::GetAllServiceCategoryDropdownData();

        return view('admin.event.create', compact('category','users','scanner','setting','serviceCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'image' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required_if:type,offline',
            'lat' => 'bail|required_if:type,offline',
            'lang' => 'bail|required_if:type,offline',
            'status' => 'bail|required',
            'description' => 'bail|required',
            'scanner_id' => 'bail|required',
            'people' => 'bail|required',
            'price' => 'bail|required',
            'instruction' => 'bail|required',
        ]);
        $data = $request->all();
        $cart_items = [];
        if(Session::has('cart')){
            $cart_items = Session::get('cart');
        }
        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        if(!Auth::user()->hasRole('admin')){
            $data['user_id'] = Auth::user()->id;
        }
        $event = Event::create($data);

        if ($event){
            if ($data['event_service_type'] == 'system_provide_service'){
//                $user = Auth::guard('appuser')->user();
                $latestOrder = OrderHead::latest()->first();

                if ($latestOrder){
                    $code = substr($latestOrder->order_id, -5);
                    $num = $code+1;
                }else{
                    $num = 1;
                }
                $orderInput['order_id'] = 'ICS-'.date('d').date('m').date('y').'-'.$this->getSequence($num);
//                if ($input['payment_type'] === 'LOCAL'){
                    $orderInput['payment_type'] = 'cod';
                /*}else{
                    $orderInput['payment_type'] = 'bank';
                }*/
                $orderInput['organization_id'] = $data['user_id'];
                $orderInput['event_id'] = $event->id;
                $orderInput['total_item'] = count($cart_items);
                $totalQuantity = 0 ;
                $totalPrice = 0 ;
                foreach ($cart_items as $item){
                    $totalQuantity = $totalQuantity+$item['order_quantity'];
                    $totalPrice = $totalPrice+$item['subtotal'];
                }
                $orderInput['order_quantity'] = $totalQuantity;
                $orderInput['total_price'] = $totalPrice;
                $orderInput['status'] = 'Pending';

                DB::beginTransaction();
                try {
                    $orderHead = OrderHead::create($orderInput);
                    if ($orderHead){
                        foreach ($cart_items as $item){
                            $orderItem = new OrderItem();
                            $orderItem->order_id = $orderHead->id;
                            $orderItem->item_id = $item['item_id'];
                            $orderItem->item_name = $item['item_name'];
                            $orderItem->item_description = $item['item_description'];
                            $orderItem->item_price = $item['subtotal'];
                            $orderItem->order_quantity = $item['order_quantity'];
                            $orderItem->bundle_quantity = $item['item_quantity'];
                            $orderItem->service_category_id = $item['service_category_id'];
                            $orderItem->service_id = $item['service_id'];
                            $orderItem->ticket = isset($item['ticket']) && $item['ticket']?$item['ticket']:0;
                            $orderItem->sold = 0;
                            $orderHead->OrderItem()->save($orderItem);
                            CartHelper::remove_item($item['item_id']);
                        }

                        /*$orderBilling = new OrderBilling();
                        $orderBilling->order_id = $orderHead->id;
                        $orderBilling->name = $input['name'];
                        $orderBilling->last_name =$input['last_name'];
                        $orderBilling->email = $input['email'];
                        $orderBilling->mobile = $input['phone'];
                        $orderBilling->address1 = $input['address1']?$input['address1']:null;
                        $orderBilling->address2 = $input['address2']?$input['address2']:null;
                        $orderBilling->country = $input['country']?$input['country']:null;
                        $orderBilling->division = $input['division']?$input['division']:null;
                        $orderBilling->district = $input['district']?$input['district']:null;
                        $orderBilling->upazila = $input['upazila']?$input['upazila']:null;
                        $orderHead->orderBilling()->save($orderBilling);*/

//                $msg = "Order place successfully";
//                $msg = wordwrap($msg,70);
//                mail($input['email'],"Order Place",$msg);
                    }

                    DB::commit();
//                    return redirect()->route('cart_details')->withStatus($orderHead);

                } catch (\Exception $e) {
                    DB::rollback();
                    print($e->getMessage());
                    exit();
                    Session::flash('danger', $e->getMessage());
                }
            }
        }
        /*if ($event){
            if (count($data['service_id'])>0){
                foreach ($data['service_id'] as $service){
                    $newService['service_id'] = $service;
                    $newService['event_id'] = $event->id;
                    $newService['service_category_id'] = $data['service_category_id'];
                    EventService::create($newService);
                }
            }
        }*/

        return redirect()->route('events.index')->withStatus(__('Event is added successfully.'));
    }

    function getSequence($num) {
        return sprintf("%'.05d", $num);
    }

    public function show(Event $event)
    {
        $event = Event::with(['category','organization'])->find($event->id);
        $event->ticket = Ticket::where([['event_id',$event->id],['is_deleted',0]])->orderBy('id','DESC')->get();
        $event->sales = Order::with(['customer:id,name','ticket:id,name'])->where('event_id',$event->id)->orderBy('id','DESC')->get();
        foreach ($event->ticket as $value) {
            $value->used_ticket = Order::where('ticket_id',$value->id)->sum('quantity');
        }
        return view('admin.event.view', compact( 'event'));
    }

    public function eventOrderCart($id){
        $event = Event::with(['category','organization'])->find($id);

        $orderItems = OrderHead::with('orderItem')->where('event_id',$id)->first();
        return view('admin.event.order_cart',compact('orderItems','event'));
    }

    public function orderPlaceNextEvent(Request $request){
        $formData = $request->all();
        $data['message'] = 'next';
        $data['total_price'] = $formData['total_price'];
        $data['payment_type'] = $formData['payment_type'];
//        ->with(['formData'=>$formData])
        Session::put('formData',$formData);
        //        dd($formData);
        return redirect()->route('events_order_cart',$formData['event_id'])->withStatus($data);
    }

    public function orderPlaceNextEventEdit(Request $request){
        $itemData = Session::get('formData');
        $input = $request->all();
        $orderHead = OrderHead::where('event_id',$itemData['event_id'])->first();
        $orderQuantity = 0;
        foreach ($itemData['quantity'] as $key => $val){
            $orderQuantity = $orderQuantity+$val;
            $orderItem = OrderItem::where('id',$itemData['order_item_id'][$key])->first();
            $orderItem->update([
                'item_price' => ($orderItem->item_price/$orderItem->order_quantity)*$val,
                'order_quantity' => $val
            ]);
        }

        $orderHead->update([
            'total_item' => count($itemData['quantity']),
            'total_price' => $itemData['total_price'],
            'order_quantity' => $orderQuantity
        ]);
        $orderBilling = OrderBilling::where('order_id',$orderHead->id)->first();
        if(!$orderBilling){
            $orderBilling = new OrderBilling();
        }
        $orderBilling->order_id = $orderHead->id;
        $orderBilling->name = $input['name'];
        $orderBilling->last_name =$input['last_name'];
        $orderBilling->email = $input['email'];
        $orderBilling->mobile = $input['phone'];
        $orderBilling->address1 = $input['address1']?$input['address1']:null;
        $orderBilling->address2 = $input['address2']?$input['address2']:null;
        $orderBilling->country = $input['country']?$input['country']:null;
        $orderBilling->division = $input['division']?$input['division']:null;
        $orderBilling->district = $input['district']?$input['district']:null;
        $orderBilling->upazila = $input['upazila']?$input['upazila']:null;
        $orderHead->orderBilling()->save($orderBilling);
        Session::forget('formData');

        return redirect()->route('events_order_cart',$itemData['event_id']);

    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category =  Category::where('status',1)->orderBy('id','DESC')->get();
        $users = User::role('organization')->orderBy('id','DESC')->get();
        if(Auth::user()->hasRole('admin')){
            $scanner = User::role('scanner')->orderBy('id','DESC')->get();
        }
        else if(Auth::user()->hasRole('organization')){
            $scanner = User::role('scanner')->where('org_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        $setting = Setting::find(1);
        return view('admin.event.edit', compact( 'event','category','users','scanner','setting'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required',
            'category_id' => 'bail|required',
            'type' => 'bail|required',
            'address' => 'bail|required_if:type,offline',
            'lat' => 'bail|required_if:type,offline',
            'lang' => 'bail|required_if:type,offline',
            'status' => 'bail|required',
            'description' => 'bail|required',
            'scanner_id' => 'bail|required',
            'people' => 'bail|required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image'))
        {
            (new AppHelper)->deleteFile($event->image);
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        $event = Event::find($event->id)->update($data);
        return redirect()->route('events.index')->withStatus(__('Event is updated successfully.'));
    }

    public function destroy(Event $event)
    {
        try{
            Event::find($event->id)->update(['is_deleted'=>1,'event_status'=>'Deleted']);
            $ticket = Ticket::where('event_id',$event->id)->update(['is_deleted'=>1]);
            return true;
        }catch(Throwable $th){
            return response('Data is Connected with other Data', 400);
        }
    }

    public function getMonthEvent(Request $request){
        $day = Carbon::parse($request->year.'-'.$request->month.'-01')->daysInMonth;
        if(Auth::user()->hasRole('organization')){
            $data = Event::whereBetween('start_time', [ $request->year."-".$request->month."-01 12:00",  $request->year."-".$request->month."-".$day."  23:59"])
            ->where([['status',1],['is_deleted',0],['user_id',Auth::user()->id]])
            ->orderBy('id','DESC')
            ->get();
        }
        if(Auth::user()->hasRole('admin'))
        {
            $data = Event::whereBetween('start_time', [ $request->year."-".$request->month."-01 12:00",  $request->year."-".$request->month."-".$day." 23:59"])
            ->where([['status',1],['is_deleted',0]])->orderBy('id','DESC')->get();
        }
        foreach ($data as $value) {
            $value->tickets = Ticket::where([['event_id',$value->id],['is_deleted',0]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id',$value->id)->sum('quantity');
            $value->day = $value->start_time->format('D');
            $value->date = $value->start_time->format('d');
            $value->average = $value->tickets==0? 0: $value->sold_ticket*100/$value->tickets;
        }
        return response()->json([ 'data' => $data,'success'=>true], 200);
    }

    public function eventGallery($id){
        $data  = Event::find($id);
        return view('admin.event.gallery',compact( 'data'));
    }

    public function addEventGallery(Request $request){
        $event = array_filter(explode(',',Event::find($request->id)->gallery));
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            array_push($event,$name);
            Event::find($request->id)->update(['gallery'=>implode(',',$event)]);
        }
        return true;
    }

    public function removeEventImage($image,$id){

        $gallery = array_filter(explode(',',Event::find($id)->gallery));
        if(count(array_keys($gallery,$image))>0){
            if (($key = array_search($image, $gallery)) !== false) {
                unset($gallery[$key]);
            }
        }
        $aa =implode(',',$gallery);
        $data= Event::find($id);
        $data->gallery =$aa;
        $data->update();
        return redirect()->back();
    }
}
