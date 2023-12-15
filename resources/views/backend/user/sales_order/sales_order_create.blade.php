@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ 'New Sales Order ' }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('store_sales_order') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
                        <input type="hidden" name="sales_order_id" value="{{$data['sales_order']->id}}" id="sales_order_id">
                        <a data-href="{{route('get_customer_credit_limit_balance_branch')}}" id="get_customer_credit_limit_balance_branch"></a>
                        <a data-href="{{route('get_product_for_sales')}}" id="get_product_for_sales"></a>
                        <a data-href="{{route('get_quantity_wise_product_body')}}" id="get_quantity_wise_product_body"></a>
                        <a data-href="{{route('remove_item_wise_product_body')}}" id="remove_item_wise_product_body"></a>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Customer') }} </label>
                                <span id="creditLimit" style="color: red;font-weight: bold"></span>
                                <select class="form-control auto-select select2" data-selected="{{ old('customer_id') }}" name="customer_id" id="customer_id" required>
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
                                <select class="form-control auto-select select2" data-selected="{{ old('branch_id') }}" name="branch_id" id="branch_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Location') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ old('location_id') }}" name="location_id" id="location_id" required>
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
                                <input type="text" class="form-control datepicker" name="invoice_date" value="{{ old('invoice_date') }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Payment Method') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ old('payment_method_id') }}" name="payment_method_id" id="payment_method_id" required>
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
                                <select class="form-control auto-select select2" data-selected="1" name="sales_type_id" id="sales_type_id" required>
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
                                <input type="text" name="reference" value="{{$data['invoiceNumber']}}" class="form-control" placeholder="Reference" readonly="true">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" id="tags">
                                <label class="control-label">{{ _lang('Customer Reference') }}</label>
                                <input type="text" name="customer_reference" value="" class="form-control" placeholder="Customer Reference">
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
{{--                                    <th class="text-center">Vat Amount</th>--}}
                                    <th class="text-center">Discount%</th>
{{--                                    <th class="text-center">Discount Amount</th>--}}
                                    <th class="text-center">Amount</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody class="product_body" style="background-color: #FFFFFF;">

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" id="notes">
                                <label class="">{{ _lang('Notes') }}</label>
                                <textarea class="form-control" name="notes">{{ old('notes') }}</textarea>
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

