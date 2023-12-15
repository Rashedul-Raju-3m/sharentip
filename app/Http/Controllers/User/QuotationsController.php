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
use App\Models\Quotation;
use App\Models\InvQuotationItems;
use App\Models\InvQuotation;
use App\Models\SalesType;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Illuminate\Http\Request;
use Validator;
use function Illuminate\Process\forever;


class QuotationsController extends Controller {

    public function quotationCreate(){
        $data['customers'] = Customer::get()->toArray();
        $data['locations'] = Location::getLocationDropdown();
        $data['paymentMethods'] = PaymentMethod::getPaymentMethodDropdown();
        $data['salesTypes'] = SalesType::getSalesTypeDropdown();
        $referenceFormat = Setting::where('name','sales_order_reference_prefix')->select(['value'])->first();
        $lastQuotation = InvQuotation::orderBy('id','desc')->first();

        if ($lastQuotation && $lastQuotation->invoice_number) {
            $code = substr($lastQuotation->invoice_number, -5);
            $num = $code + 1;
        } else {
            $num = 1;
        }
        $data['invoiceNumber'] = $referenceFormat->value.substr( date("y"),-2).date('m').$this->getSequence($num);
        $data['quotation'] = InvQuotation::create(['status'=>0]);
        return view('backend.user.inv_quotation.quotation_create', compact('data'));
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

    public function getProductForQuotation(){
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
        InvQuotationItems::create([
            'quotation_id' => $salesOrderID,
            'product_id' => $productID,
            'quantity' => 1,
            'product_name' => $product->name.' ('.$product->sku.')',
            'description' => $product->descriptions,
            'unit_cost' => $product->price,
            'vat' => $product->vat,
            'discount' => $product->discount
        ]);
        $items = InvQuotationItems::where('quotation_id',$salesOrderID)->get();
        $response['content'] = '';
        if ($product){
            $view = \Illuminate\Support\Facades\View::make('backend.user.inv_quotation.quotation_body',compact('items'));
            $contents = $view->render();
            $response['content'] = $contents;
        }
        return $response;
    }

    public function getQuantityWiseProductBodyQuotation(){
        $itemID = $_GET['itemID'];
        $quantity = $_GET['quantity'];
        $unit_cost = $_GET['unit_cost'];
        dd($itemID,$quantity,$unit_cost);
        $invoiceItem = InvQuotationItems::find($itemID);
        $invoiceItem->update([
            'quantity' => $quantity,
            'unit_cost' => $unit_cost
        ]);
        $items = InvQuotationItems::where('quotation_id',$invoiceItem->quotation_id)->get();
//        dd($items);
        $response['content'] = '';
        if ($items){
            $view = \Illuminate\Support\Facades\View::make('backend.user.inv_quotation.quotation_body',compact('items'));
            $contents = $view->render();
            $response['content'] = $contents;
        }
//        dd($response);
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
            $view = \Illuminate\Support\Facades\View::make('backend.user.inv_quotation.quotation_body',compact('items'));
            $contents = $view->render();
            $response['content'] = $contents;
        }
        return $response;
    }

    public function storeQuotation(Request $request){
        $input = $request->all();
        $invoice = InvQuotation::find($input['quotation_id']);
        $invoiceItems = InvQuotationItems::where('quotation_id',$input['quotation_id'])->get();

        $Itemstotal = 0;
        foreach($invoiceItems as $item){
            $subTotal = $item->quantity*$item->unit_cost;
            $vatAmount = ($subTotal*$item->vat)/100;
            $discountAmount = ($subTotal*$item->discount)/100;
            $total = $subTotal+$vatAmount-$discountAmount;
            $Itemstotal = $Itemstotal + $total;
            InvQuotationItems::find($item->id)->update([
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
        return redirect()->route('quotation_index');
    }

    public function quotationIndex(){
        $assets   = ['datatable'];
        /*Delete script*/
        $deleteQuotation = InvQuotation::where('status',0)->first();
        if (isset($deleteQuotation) && isset($deleteQuotation->id)){
            $deleteQuotationItems = InvQuotationItems::where('quotation_id',$deleteQuotation->id)->get();
            foreach ($deleteQuotationItems as $item){
                InvQuotationItems::find($item->id)->delete();
            }
            $deleteQuotation->delete();
        }
        /*Delete script*/
        $invQuotation = InvQuotation::where('inv_quotation.status',1)
                                ->select([
                                    'inv_quotation.id','inv_quotation.invoice_number','inv_quotation.grand_total','inv_quotation.invoice_date','inv_quotation.parent_quotation_id','customers.name'
                                ])
                                ->join('customers','customers.id','=','inv_quotation.customer_id')
//                                ->leftjoin('inv_quotation as parent_inv_quo','inv_quotation.id','=','parent_inv_quo.parent_quotation_id')
                                ->orderBy('inv_quotation.id','desc')
                                ->get();
        return view('backend.user.inv_quotation.list', compact('invQuotation', 'assets'));
    }

    public function quotationEdit($id){
        $lastQuotation = InvQuotation::orderBy('id','desc')->first();
        $referenceFormat = Setting::where('name','sales_order_reference_prefix')->select(['value'])->first();
        if ($lastQuotation && $lastQuotation->invoice_number) {
            $code = substr($lastQuotation->invoice_number, -5);
            $num = $code + 1;
        } else {
            $num = 1;
        }
        $data['invoiceNumber'] = $referenceFormat->value.substr( date("y"),-2).date('m').$this->getSequence($num);
        $quotation = InvQuotation::find($id);
        $invoiceItems = InvQuotationItems::where('quotation_id',$id)->get();

        $newQuotation = new InvQuotation();
        $data = $newQuotation->create([
            'invoice_number'=>$referenceFormat->value.substr( date("y"),-2).date('m').$this->getSequence($num),
            'parent_quotation_id'=>$id,
            'customer_id'=>$quotation['customer_id'],
            'branch_id'=>$quotation['branch_id'],
            'location_id'=>$quotation['location_id'],
            'invoice_date'=>$quotation['invoice_date'],
            'payment_method_id'=>$quotation['payment_method_id'],
            'sales_type_id'=>$quotation['sales_type_id'],
            'customer_reference'=>$quotation['customer_reference'],
            'note'=>$quotation['note'],
            'discount'=>$quotation['discount'],
            'discount_type'=>$quotation['discount']==$quotation['discount_amount']?1:0,
            'discount_value'=>$quotation['discount_value'],
            'sub_total'=>$quotation['sub_total'],
            'grand_total'=>$quotation['grand_total'],
            'status'=>1
        ]);

        foreach($invoiceItems as $item){
            InvQuotationItems::create([
                'quotation_id' => $data['id'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'product_name' => $item['product_name'],
                'description' => $item['description'],
                'unit_cost' => $item['unit_cost'],
                'vat' => $item['vat'],
                'discount' => $item['discount']
            ]);
        }

        $data['customers'] = Customer::get()->toArray();
        $data['locations'] = Location::getLocationDropdown();
        $data['paymentMethods'] = PaymentMethod::getPaymentMethodDropdown();
        $data['salesTypes'] = SalesType::getSalesTypeDropdown();
        $salesOrder = InvQuotation::find($data['id']);
        $data['customerBranch'] = CustomerBranch::getCustomerBranchDropdown($salesOrder->customer_id);
        $customer = Customer::find($salesOrder->customer_id);
        $data['customerBalanceLimit'] = ($customer->balance?$customer->balance:0)+($customer->credit_limit?$customer->credit_limit:0);
        $items = InvQuotationItems::where('quotation_id',$data['id'])->get();
//        dd($salesOrder,$items);
        return view('backend.user.inv_quotation.quotation_edit', compact('data','salesOrder','items'));
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
                'invoices.id','invoices.invoice_number','invoices.grand_total','invoices.invoice_date','customers.name',
                'customer_branch.br_name','location.loc_code','location.location_name','payment_terms.name as payment_method_name',
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
        dd($salesOrder);
        return view('backend.user.sales_order.sales_order_view', compact('salesOrder'));
    }
}
