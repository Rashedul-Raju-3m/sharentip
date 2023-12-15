@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
        @if(isset($invoices) && count($invoices)>0)
        <div class="card" style="padding: 0px">
            <div class="card-header">
                <span class="panel-title">{{ 'Invoice for this sales order' }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="card-body" style="padding: 0px">
                        <table class="table table-bordered" id="product_table" style="margin: 0px">
                            <thead>
                            <tr>
                                <th class="text-center">Invoice Number</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Sub Total</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Grand Total</th>
                            </tr>
                            </thead>
                            <tbody class="product_body" style="background-color: #FFFFFF;">
                            @if(isset($invoices))
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{route('invoice_edit_agst_so',$invoice->id)}}">{{$invoice->invoice_number}}</a>
                                        </td>
                                        <td class="text-center">{{date('d-m-Y',strtotime($invoice->invoice_date))}}</td>
                                        <td class="text-right">{{$invoice->sub_total}}</td>
                                        <td class="text-right">{{$invoice->discount_value}}</td>
                                        <td class="text-right">{{$invoice->grand_total}}</td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card">
			<div class="card-header">
				<span class="panel-title">{{ 'New Sales Order ' }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('store_sales_order') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
                        <input type="hidden" name="sales_order_id" value="{{$salesOrder->id}}" id="sales_order_id">
                        <a data-href="{{route('get_customer_credit_limit_balance_branch')}}" id="get_customer_credit_limit_balance_branch"></a>
                        <a data-href="{{route('get_product_for_sales')}}" id="get_product_for_sales"></a>
                        <a data-href="{{route('get_quantity_wise_product_body')}}" id="get_quantity_wise_product_body"></a>
                        <a data-href="{{route('remove_item_wise_product_body')}}" id="remove_item_wise_product_body"></a>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Customer') }} </label>
                                <span id="creditLimit" style="color: red;font-weight: bold">{{'Credit Limit '.$data['customerBalanceLimit']}}</span>
                                <select class="form-control auto-select select2" data-selected="{{ $salesOrder->customer_id }}" name="customer_id" id="customer_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['customers'] && count($data['customers'])>0)
                                        @foreach($data['customers'] as $key => $customer)
                                            <option value="{{$customer['id']}}">{{ $customer['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Dealer Branch') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ $salesOrder->branch_id }}" name="branch_id" id="branch_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['customerBranch'] && count($data['customerBranch'])>0)
                                        @foreach($data['customerBranch'] as $key => $customerBranch)
                                            <option value="{{$customerBranch['id']}}">{{ $customerBranch['br_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Location') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ $salesOrder->location_id }}" name="location_id" id="location_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['locations'] && count($data['locations'])>0)
                                        @foreach($data['locations'] as $key => $location)
                                            <option value="{{$location['id']}}">{{ $location['location_name'].' ('.$location['loc_code'].')' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Date') }}</label>
                                <input type="text" class="form-control datepicker" name="invoice_date" value="{{ $salesOrder->invoice_date }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Payment Method') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ $salesOrder->payment_method_id }}" name="payment_method_id" id="payment_method_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['paymentMethods'] && count($data['paymentMethods'])>0)
                                        @foreach($data['paymentMethods'] as $key => $paymentMethod)
                                            <option value="{{$paymentMethod['id']}}">{{ $paymentMethod['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Sales Type') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{$salesOrder->sales_type_id}}" name="sales_type_id" id="sales_type_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['salesTypes'] && count($data['salesTypes'])>0)
                                        @foreach($data['salesTypes'] as $key => $salesType)
                                            <option value="{{$salesType['id']}}">{{ $salesType['sales_type'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" id="tags">
                                <label class="control-label">{{ _lang('Reference') }}</label>
                                <input type="text" name="reference" value="{{$salesOrder->invoice_number}}" class="form-control" placeholder="Reference" readonly="true">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" id="tags">
                                <label class="control-label">{{ _lang('Customer Reference') }}</label>
                                <input type="text" name="customer_reference" value="{{$salesOrder->customer_reference}}" class="form-control" placeholder="Customer Reference">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="tags" style="position: relative;">
                                <label class="control-label">{{ _lang('Add Product') }}</label>
                                <a data-href="{{route('get_product_dropdown')}}" id="getProductDropdown" style="display: none;"></a>
                                    <input type="text" name="product" class="form-control" id="autocomplete-ajax" placeholder="Press data for product search" style="position: absolute; z-index: 2; background: transparent;"/>
                                    <input type="text" name="product"  class="form-control" id="autocomplete-ajax-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1;"/>
                            </div>
                            <div id="selction-ajax"></div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="card-body">
                            <table class="table table-bordered" id="product_table">
                                <thead>
                                <tr>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Vat%</th>
                                    <th class="text-center">Discount%</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody class="product_body" style="background-color: #FFFFFF;">
                                @if(isset($items))
                                    @php $itemsSubTotal = 0;$itemsTotal = 0;$itemsVat = 0;$itemsDiscount = 0; @endphp
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="text-center" width="30%">{{$item->product_name}}</td>
                                            <td class="text-center" style="width: 10%">
                                                <input type="text" name="quantity" value="{{$item->quantity}}" data-id="{{$item->id}}" id="quantity" class="form-control text-center">
                                            </td>
                                            <td class="text-center" style="width: 15%">
                                                <input type="text" name="rate" value="{{$item->unit_cost}}" class="form-control text-right" readonly>
                                            </td>
                                            <td class="text-center" width="12%">
                                                <input type="text" name="vat" value="{{$item->vat}}" class="form-control text-center" readonly>
                                            </td>

                                            <td class="text-center" style="width: 12%">
                                                <input type="text" name="discount" value="{{$item->discount}}" class="form-control text-center" readonly>
                                            </td>

                                            @php
                                                $subTotal = $item->quantity*$item->unit_cost;
                                                $vatAmount = ($subTotal*$item->vat)/100;
                                                $itemsVat = $itemsVat+$vatAmount;
                                                $discountAmount = ($subTotal*$item->discount)/100;
                                                $itemsDiscount = $itemsDiscount+$discountAmount;
                                                $itemsSubTotal = $itemsSubTotal+$subTotal;
                                                $total = $subTotal+$vatAmount-$discountAmount;
                                                $itemsTotal = $itemsTotal+$total;
                                            @endphp
                                            <td class="text-center" style="width: 15%">
                                                <input type="text" name="amount" value="{{number_format($total,2)}}" class="form-control text-right" readonly>
                                            </td>
                                            <td class="text-center" style="width: 5%">
                                                <span id="removeItem" data-id="{{$item->id}}"><i class="ti-trash mr-1"></i></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="2" style="color: #000000;text-align: center;"> Total Amount (tk.)</th>
                                        <th class="text-center">
                                            <input type="text" name="sub_total" value="{{number_format($itemsSubTotal,2)}}" class="form-control sub_total text-right" placeholder="Sub Total" readonly>
                                        </th>
                                        <th class="text-center">
                                            <input type="text" name="total_vat" value="{{number_format($itemsVat,2)}}" class="form-control total_vat text-center" placeholder=" Total Vat" readonly>
                                        </th>
                                        <th class="text-center">
                                            <input type="text" name="total_discount" value="{{number_format($itemsDiscount,2)}}" class="form-control total_discount text-center" placeholder=" Total Discount" readonly>
                                        </th>
                                        <th class="text-center">
                                            <input type="text" name="total" id="total" value="{{number_format($itemsTotal,2)}}" class="form-control total text-right" placeholder=" Total" readonly>
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" style="color: #000000;text-align: center;">Discount %</th>
                                        <th class="text-center">
                                            <input type="text" name="discount" value="{{$salesOrder->discount}}" class="form-control discount text-center" id="discount">

                                        </th>
                                        <th class="text-center">
                                            <input type="checkbox"  name="discount_type" value="{{$salesOrder->discount_type==1?0:1}}" id="discount_type" {{$salesOrder->discount_type==1?'':'checked'}}>
                                            <label for="discount_type">{{ _lang('Is percentage') }}</label>
                                        </th>
                                        <th class="text-center">
                                            <input type="text" name="discount_amount" id="discount_amount" value="{{$salesOrder->discount_value}}" class="form-control text-right" placeholder="Discount">
                                        </th>
                                        <th></th>
                                    </tr>

                                    <tr>
                                        <th colspan="5" style="color: #000000;text-align: center;">Grand Amount</th>
                                        <th class="text-center">
                                            <input type="text" name="grand_amount" value="{{number_format(($itemsTotal-$salesOrder->discount_value),2)}}" class="form-control grand_amount text-right" id="grand_total" placeholder="Grand Amount">
                                        </th>
                                        <th></th>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" id="notes">
                                <label class="">{{ _lang('Notes') }}</label>
                                <textarea class="form-control" name="notes">{{ $salesOrder->note }}</textarea>
                            </div>
                        </div>

						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary" id="submit-button"><i class="ti-check-box mr-2"></i>{{ _lang('Save Changes') }}</button>
							</div>
						</div>
					</div>
			    </form>
			</div>
		</div>
    </div>
</div>
@endsection


@section('js-script')
    <script type="text/javascript">
        $(function () {
            'use strict';
            $('#autocomplete-ajax').autocomplete({
                cache: false,
                lookup: function (query, done) {
                    let productDropdownRoute = $('#getProductDropdown').attr('data-href');
                    $.ajax({
                        url: productDropdownRoute,
                        method: "GET",
                        dataType: "json",
                        data: {query: query},
                        beforeSend: function( xhr ) {

                        }
                    }).done(function( res ) {
                        let productDropdownValue = [];
                        if(res.count > 0){
                             productDropdownValue = (res.products).map(element => {
                                return {value: ""+element.name+" ("+element.sku+")", data: ""+element.id+""}
                            });
                            done({suggestions: productDropdownValue});
                        }
                    }).fail(function( jqXHR, textStatus ) {

                    });
                },
                lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function(suggestion) {
                    let productID = suggestion.data
                    let salesTypeID = $('#sales_type_id').val()
                    let salesOrderID = $('#sales_order_id').val()
                    // console.log(suggestion.value,suggestion.data)
                    let route = $('#get_product_for_sales').attr('data-href');
                    $.ajax({
                        url: route,
                        method: "GET",
                        dataType: "json",
                        data: {productID: productID,salesTypeID:salesTypeID,salesOrderID:salesOrderID},
                        beforeSend: function( xhr ) {

                        }
                    }).done(function( response ) {
                        jQuery('.product_body').html(response.content);
                        jQuery('#autocomplete-ajax').val('');
                    }).fail(function( jqXHR, textStatus ) {

                    });
                    return false;
                },
                onHint: function (hint) {
                    $('#autocomplete-ajax-x').val(hint);
                },
                onInvalidateSelection: function() {
                    $('#selction-ajax').html('');
                }
            });
        });

        $(document).delegate('#customer_id','change',function () {
            let customerID = $(this).val();
            let route = $('#get_customer_credit_limit_balance_branch').attr('data-href');
            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {customerID: customerID},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                if(response.customerBranch){
                    let allItems = response.customerBranch;
                    let branchDataOption = '';
                    branchDataOption='<option value="">Select One</option>';
                    jQuery.each(allItems, function(i, item) {
                        branchDataOption += '<option value="'+item.id+'">'+item.br_name+'</option>';
                    });
                    jQuery('#branch_id').html(branchDataOption);
                    jQuery('#branch_id').prop('disabled', false);
                }
                $('#creditLimit').text('Credit Limit '+response.customerBalanceLimit);
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        })


        $(document).delegate('#quantity','blur',function () {
            let quantity = $(this).val();
            let itemID = $(this).attr('data-id');
            let route = $('#get_quantity_wise_product_body').attr('data-href');

            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {itemID: itemID,quantity:quantity},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                jQuery('.product_body').html(response.content);
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        })

        $(document).delegate('#removeItem','click',function () {
            let itemID = $(this).attr('data-id');
            let route = $('#remove_item_wise_product_body').attr('data-href');

            if (confirm('Are you sure you want remove this item?')) {
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {itemID: itemID},
                    beforeSend: function( xhr ) {

                    }
                }).done(function( response ) {
                    jQuery('.product_body').html(response.content);
                }).fail(function( jqXHR, textStatus ) {

                });
                return false;
            }
        })

        $(document).delegate('#discount_type','click',function () {
            let discount = $('#discount').val();
            let total = $('#total').val()
                total = total.replace(/\,/g,'')
            if ($(this).is(":checked")) {
                $('#discount_amount').val(Number((parseInt(total)*parseInt(discount))/100).toFixed(2))
                $('#grand_total').val(Number(parseInt(total)-(parseInt(total)*parseInt(discount))/100).toFixed(2))
                $(this).val(1)
            }else{
                $('#discount_amount').val(Number(parseInt(discount)).toFixed(2))
                $('#grand_total').val(Number(parseInt(total)-parseInt(discount)).toFixed(2))
                $(this).val(0)
            }
        })

        $(document).delegate('#discount','blur',function () {
            let discount = $(this).val();
            let discountType = $('#discount_type').val();
            let total = $('#total').val();
                total = total.replace(/\,/g,'')
            if(discountType == 0){
                $('#discount_amount').val(Number(parseInt(discount)).toFixed(2))
                $('#grand_total').val(Number(parseInt(total)-parseInt(discount)).toFixed(2))
            }else{
                $('#discount_amount').val(Number((parseInt(total)*parseInt(discount))/100).toFixed(2))
                $('#grand_total').val(Number(parseInt(total)-(parseInt(total)*parseInt(discount))/100).toFixed(2))
            }
        })

    </script>
@endsection

