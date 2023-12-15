<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Location;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\SalesType;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Validator;
use function Illuminate\Process\forever;


class SalesOrderController extends Controller {

    public function salesOrderCreate(){
        $data['customers'] = Customer::get()->toArray();
        $data['locations'] = Location::getLocationDropdown();
        $data['paymentMethods'] = PaymentMethod::getPaymentMethodDropdown();
        $data['salesTypes'] = SalesType::getSalesTypeDropdown();
        $referenceFormat = Setting::where('name','sales_order_reference_prefix')->select(['value'])->first();
        $lastInvoice = Invoice::orderBy('id','desc')->where('type','sales-order')->first();

        if ($lastInvoice && $lastInvoice->invoice_number) {
            $code = substr($lastInvoice->invoice_number, -5);
            $num = $code + 1;
        } else {
            $num = 1;
        }
        $data['invoiceNumber'] = $referenceFormat->value.substr( date("y"),-2).date('m').$this->getSequence($num);
        $data['sales_order'] = Invoice::create(['status'=>0]);
        return view('backend.user.sales_order.sales_order_create', compact('data'));
    }
    function getSequence($num) {
        return sprintf("%'.05d", $num);
    }

    public function getProductDropdown(){
        $response = [];
        $query = $_GET['query'];
        $response['products'] = Product::select('id','name','sku')->where('name', 'like', '%' . $query . '%')->orWhere('sku', 'like', '%' . $query . '%')->orderBy('name','asc')->get();
        $response['count'] = count($response['products']);
        return $response;
    }

    public function getCustomerCreditLimitBalanceBranch(){
        $response = [];
        $customerID = $_GET['customerID'];
        $customer = Customer::find($customerID);
        $response['customerBalanceLimit'] = ($customer->balance?$customer->balance:0)+($customer->credit_limit?$customer->credit_limit:0);
        $response['customerBranch'] = CustomerBranch::getCustomerBranchDropdown($customerID);
        return $response;
    }

    public function getProductForSales(){
        $response = [];
        $productID = $_GET['productID'];
        $salesTypeID = $_GET['salesTypeID'];
        $salesOrderID = $_GET['salesOrderID'];
        $product = Product::where('products.id',$productID)->where('sale_prices.sales_type_id',$salesTypeID)
                            ->select([
                                'products.sku',
                                'products.name',
                                'products.image',
                                'products.descriptions',
                                'products.vat',
                                'products.discount',
                                'products.stock',
                                'sale_prices.price'
                            ])
                            ->join('sale_prices','sale_prices.product_id','=','products.id')
                            ->first();
        InvoiceItem::create([
            'invoice_id' => $salesOrderID,
            'product_id' => $productID,
            'quantity' => 1,
            'product_name' => $product->name.' ('.$product->sku.')',
            'description' => $product->descriptions,
            'unit_cost' => $product->price,
            'vat' => $product->vat,
            'discount' => $product->discount
        ]);
        $items = InvoiceItem::where('invoice_id',$salesOrderID)->get();
        $response['content'] = '';
        if ($product){
            $view = \Illuminate\Support\Facades\View::make('backend.user.sales_order.sales_order_body',compact('items'));
            $contents = $view->render();
            $response['content'] = $contents;
        }
        return $response;
    }

    public function getQuantityWiseProductBody(){
        $itemID = $_GET['itemID'];
        $quantity = $_GET['quantity'];
        $invoiceItem = InvoiceItem::find($itemID);
        $invoiceItem->update([
            'quantity' => $quantity
        ]);
        $items = InvoiceItem::where('invoice_id',$invoiceItem->invoice_id)->get();
        $response['content'] = '';
        if ($items){
            $view = \Illuminate\Support\Facades\View::make('backend.user.sales_order.sales_order_body',compact('items'));
            $contents = $view->render();
            $response['content'] = $contents;
        }
        return $response;
    }

    public function removeItemWiseProductBody(){
        $itemID = $_GET['itemID'];
        $invoiceItem = InvoiceItem::find($itemID);
        $invoiceID = $invoiceItem->invoice_id;
        $invoiceItem->delete();
        $items = InvoiceItem::where('invoice_id',$invoiceID)->get();
        $response['content'] = '';
        if ($items){
            $view = \Illuminate\Support\Facades\View::make('backend.user.sales_order.sales_order_body',compact('items'));
            $contents = $view->render();
            $response['content'] = $contents;
        }
        return $response;
    }

    public function storeSalesOrder(Request $request){
        $input = $request->all();
        $invoice = Invoice::find($input['sales_order_id']);

        $invoiceItems = InvoiceItem::where('invoice_id',$input['sales_order_id'])->get();

        $Itemstotal = 0;
        foreach($invoiceItems as $item){
            $subTotal = $item->quantity*$item->unit_cost;
            $vatAmount = ($subTotal*$item->vat)/100;
            $discountAmount = ($subTotal*$item->discount)/100;
            $total = $subTotal+$vatAmount-$discountAmount;
            $Itemstotal = $Itemstotal + $total;
            InvoiceItem::find($item->id)->update([
                'sub_total' => $subTotal,
                'vat_amount' => $vatAmount,
                'discount_amount' => $discountAmount,
                'total' => $total,
            ]);
        }
        $invoice->update([
            'customer_id'=>$input['customer_id'],
            'branch_id'=>$input['branch_id'],
            'location_id'=>$input['location_id'],
            'invoice_date'=>$input['invoice_date'],
            'payment_method_id'=>$input['payment_method_id'],
            'sales_type_id'=>$input['sales_type_id'],
            'invoice_number'=>$input['reference'],
            'customer_reference'=>$input['customer_reference'],
            'note'=>$input['notes'],
            'discount'=>$input['discount'],
            'discount_type'=>$input['discount']==$input['discount_amount']?1:0,
            'discount_value'=>$input['discount_amount'],
            'sub_total'=>$Itemstotal,
            'grand_total'=>$Itemstotal-$input['discount_amount'],
            'status'=>1
        ]);
        return redirect()->route('sales_order_index');
    }

    public function storeSalesIndex(){
        $assets   = ['datatable'];
        /*Delete script*/
        $deleteInvoice = Invoice::where('status',0)->where('type','sales-order')->first();
        if (isset($deleteInvoice) && isset($deleteInvoice->id)){
            $deleteInvoiceItems = InvoiceItem::where('invoice_id',$deleteInvoice->id)->get();
            foreach ($deleteInvoiceItems as $item){
                InvoiceItem::find($item->id)->delete();
            }
            $deleteInvoice->delete();
        }
        /*Delete script*/
        $salesOrders = Invoice::where('invoices.status',1)->where('invoices.type','sales-order')
                                ->select([
                                    'invoices.id','invoices.invoice_number','invoices.grand_total','invoices.invoice_date','customers.name'
                                ])
                                ->join('customers','customers.id','=','invoices.customer_id')
                                ->orderBy('id','desc')
                                ->get();
        return view('backend.user.sales_order.list', compact('salesOrders', 'assets'));
    }

    public function storeSalesEdit($id){
        $data['customers'] = Customer::get()->toArray();
        $data['locations'] = Location::getLocationDropdown();
        $data['paymentMethods'] = PaymentMethod::getPaymentMethodDropdown();
        $data['salesTypes'] = SalesType::getSalesTypeDropdown();
        $salesOrder = Invoice::find($id);
        $data['customerBranch'] = CustomerBranch::getCustomerBranchDropdown($salesOrder->customer_id);
        $customer = Customer::find($salesOrder->customer_id);
        $data['customerBalanceLimit'] = ($customer->balance?$customer->balance:0)+($customer->credit_limit?$customer->credit_limit:0);
        $items = InvoiceItem::where('invoice_id',$id)->get();
        $invoices = Invoice::where('parent_id',$id)->get();
        return view('backend.user.sales_order.sales_order_edit', compact('data','salesOrder','items','invoices'));
    }

    public function salesOrderDelete($id){
        $deleteInvoice = Invoice::find($id);
        if (isset($deleteInvoice) && isset($deleteInvoice->id)){
            $deleteInvoiceItems = InvoiceItem::where('invoice_id',$id)->get();
            foreach ($deleteInvoiceItems as $item){
                InvoiceItem::find($item->id)->delete();
            }
        }
        $deleteInvoice->delete();
        return redirect()->route('sales_order_index');
    }

    public function storeSalesView($id){
        $salesOrder = Invoice::where('invoices.id',$id)
            ->select([
                'invoices.id','invoices.invoice_number','invoices.grand_total','invoices.invoice_date','invoices.type',
                'customers.name', 'customer_branch.br_name','customers.company_name','customers.email','customers.address','customers.city','customers.zip','customers.country','customers.mobile','customer_branch.shipping_street','customer_branch.shipping_city','customer_branch.shipping_state','customer_branch.shipping_country_id','customer_branch.shipping_zip_code',
                'location.loc_code','location.location_name','location.delivery_address',
                'payment_terms.name as payment_method_name',
                'sales_types.sales_type','invoices.customer_reference','invoices.sub_total','invoices.discount','invoices.discount_type',
                'invoices.discount_value','invoices.note','invoices.created_at',
            ])
            ->with(
                array(
                    'items' => function($query){
                        $query->select([
                            'invoice_items.id',
                            'invoice_items.invoice_id',
                            'invoice_items.product_id',
                            'invoice_items.quantity',
                            'invoice_items.unit_cost',
                            'invoice_items.vat_amount',
                            'invoice_items.discount_amount',
                            'invoice_items.sub_total',
                            'invoice_items.total',
                            'products.sku','products.name','products.image','products.descriptions','products.vat','products.discount','products.stock',
                        ])->join('products','products.id','=','invoice_items.product_id');
                    }
                )
            )
            ->join('customers','customers.id','=','invoices.customer_id')
            ->join('customer_branch','customer_branch.id','=','invoices.branch_id')
            ->join('location','location.id','=','invoices.location_id')
            ->join('payment_terms','payment_terms.id','=','invoices.payment_method_id')
            ->join('sales_types','sales_types.id','=','invoices.sales_type_id')
            ->orderBy('id','desc')
            ->first()->toArray();
//        dd($salesOrder);
        return view('backend.user.sales_order.sales_order_view', compact('salesOrder'));
    }

    public function invoiceCreateAgainstSO($id){
        $data['customers'] = Customer::get()->toArray();
        $data['locations'] = Location::getLocationDropdown();
        $data['paymentMethods'] = PaymentMethod::getPaymentMethodDropdown();
        $data['salesTypes'] = SalesType::getSalesTypeDropdown();
        $referenceFormat = Setting::where('name','invoice_reference_prefix')->select(['value'])->first();
        $lastInvoice = Invoice::orderBy('id','desc')->where('type','invoice')->first();

        if ($lastInvoice && $lastInvoice->invoice_number) {
            $code = substr($lastInvoice->invoice_number, -5);
            $num = $code + 1;
        } else {
            $num = 1;
        }
        $data['invoiceNumber'] = $referenceFormat->value.substr( date("y"),-2).date('m').$this->getSequence($num);
        $invoice = Invoice::find($id);
        $data['customerBranch'] = CustomerBranch::getCustomerBranchDropdown($invoice->customer_id);
        $invoiceItems = InvoiceItem::where('invoice_id',$id)->get();

        if ($invoice && $invoiceItems){
            $newInvoice = new Invoice();
            $newInvoice = $newInvoice->create([
                'parent_id'=>$id,
                'type'=>'invoice',
                'customer_id'=>$invoice->customer_id,
                'branch_id'=>$invoice->branch_id,
                'location_id'=>$invoice->location_id,
                'payment_method_id'=>$invoice->payment_method_id,
                'sales_type_id'=>$invoice->sales_type_id,
                'customer_reference'=>$invoice->customer_reference,
                'invoice_number'=>$data['invoiceNumber'],
                'invoice_date'=>date('Y-m-d'),
                'sub_total'=>$invoice->sub_total,
                'grand_total'=>$invoice->grand_total,
                'discount'=>$invoice->discount,
                'discount_type'=>$invoice->discount_type,
                'discount_value'=>$invoice->discount_value,
                'status'=>$invoice->status,
                'note'=>$invoice->note,
            ]);
            foreach ($invoiceItems as $item){
                InvoiceItem::create([
                    'invoice_id' => $newInvoice->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_cost' => $item->unit_cost,
                    'vat' => $item->vat,
                    'vat_amount' => $item->vat_amount,
                    'discount' => $item->discount,
                    'discount_amount' => $item->discount_amount,
                    'sub_total' => $item->sub_total,
                    'total' => $item->total,
                ]);
            }
        }
        return redirect()->route('invoice_edit_agst_so',$newInvoice->id);
    }

    public function invoiceEditAgstSO($id){
        $data['customers'] = Customer::get()->toArray();
        $data['locations'] = Location::getLocationDropdown();
        $data['paymentMethods'] = PaymentMethod::getPaymentMethodDropdown();
        $data['salesTypes'] = SalesType::getSalesTypeDropdown();
        $salesOrder = Invoice::find($id);
        $data['customerBranch'] = CustomerBranch::getCustomerBranchDropdown($salesOrder->customer_id);
        $customer = Customer::find($salesOrder->customer_id);
        $data['customerBalanceLimit'] = ($customer->balance?$customer->balance:0)+($customer->credit_limit?$customer->credit_limit:0);
        $items = InvoiceItem::where('invoice_id',$id)->get();
        return view('backend.user.sales_order.invoice_create', compact('data','salesOrder','items'));
    }

    public function invoiceIndexAgstSO(){
        $assets   = ['datatable'];
        /*Delete script*/
        $deleteInvoice = Invoice::where('status',0)->where('type','invoice')->first();
        if (isset($deleteInvoice) && isset($deleteInvoice->id)){
            $deleteInvoiceItems = InvoiceItem::where('invoice_id',$deleteInvoice->id)->get();
            foreach ($deleteInvoiceItems as $item){
                InvoiceItem::find($item->id)->delete();
            }
            $deleteInvoice->delete();
        }
        /*Delete script*/
        $salesOrders = Invoice::where('invoices.status',1)->where('invoices.type','invoice')
            ->select([
                'invoices.id','invoices.invoice_number','invoices.grand_total','invoices.invoice_date','customers.name'
            ])
            ->join('customers','customers.id','=','invoices.customer_id')
            ->orderBy('id','desc')
            ->get();
        return view('backend.user.sales_order.invoice_list', compact('salesOrders', 'assets'));
    }

}
