@extends('frontend.master', ['activePage' => 'sevice'])

@section('content')

    @php
        use App\Models\Country;
        use App\Models\District;
        use App\Models\Division;
        use App\Models\Upazila;
        use Illuminate\Support\Facades\Auth;
        $user = Auth::guard('appuser')->user();
        $totalItem = 0;
        $totalPrice = 0;
        $status = session('status');
        if($status){
            /*if (isset($status->id)){
                $orderBilling = \App\Models\OrderBilling::where('order_id',$status->id)->first();
            }
            $districts = [];
            $upazilas = [];
            if (isset($user->division)){
                $districts = District::GetAllDivisionWiseDistrictDropdownData($user->division);
            }
            if (isset($user->district)){
                $upazilas = Upazila::GetAllDistrictWiseUpazilaDropdownData($user->district);
            }
            $country = Country::GetAllCountry();
            $divisions = Division::GetAllDivisionDropdownData();*/
        }
    @endphp
    <section class="" style="background-color: #d2c9ff;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    @if (session('status'))

                    @else
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">

{{--                                <form action="{{ url('/order/place/next') }}" method="POST">--}}
                                <form action="{{ route('order_place_next') }}" method="POST">

                                                                        @csrf
{{--                                    <input type="text" name="_token" value="XyGTxErm78Hcn1puOOKP4Vitz8QlqTgDGXX96woE">--}}
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-lg-8">
                                                <div class="p-5">
                                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                                        <h1 class="fw-bold mb-0 text-black">Item Cart</h1>
                                                        <h6 class="mb-0 text-muted">{{count($cart_items)>0?count($cart_items):0}}
                                                            items</h6>
                                                    </div>


                                                    @if(count($cart_items)>0)
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Choose Tour Date</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" required name="tour_date" type="date" value="">
                                                                    </div>
                                                                    @error('tour_date')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4 d-flex justify-content-between align-items-center" style="background: #37517e;padding: 10px;">

                                                            <div class="col-md-2" style="margin-left: 0px !important;padding: 0px !important;">
                                                            </div>
                                                            <div class="col-md-2 " style="padding: 0 !important;">
                                                                <h6 class="text-black mb-0" style="color: white">Item Name</h6>
                                                            </div>

                                                            <div class="col-md-2 " style="padding: 0 !important;">
                                                                <h6 class="text-black mb-0" style="color: white">Order Qty</h6>
                                                            </div>
                                                            <div class="col-md-2 " style="padding: 0 !important;">
                                                                <h6 class="text-black mb-0" style="color: white">Item Price</h6>
                                                            </div>

                                                        </div>
                                                        <hr class="my-4">
                                                        @php
                                                            $totalItem = 0;
                                                            $totalPrice = 0;
                                                        @endphp
                                                        @foreach($cart_items as $key => $item)
                                                            <div
                                                                class="row mb-4 d-flex justify-content-between align-items-center">
                                                                <div class="col-md-2 " style="padding: 0 !important;">
                                                                    <img src="{{ url('images/upload/'.$item['image'])}}" class="img-fluid rounded-3" alt="{{$item['item_name']}}">
                                                                </div>

                                                                <div class="col-md-2 " style="padding: 0 !important;">
                                                                    <h6 class="text-muted">{{$item['serviceName']}}</h6>
                                                                    <h6 class="text-black mb-0">
                                                                        {{$item['item_name']}}
                                                                        <span style="font-size: 12px;">{{' - (TK. '.$item['unit_price'].')'}}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-2 " style="padding: 0 !important;">
                                                                    <div class=" d-flex">
                                                                        <button class="btn btn-link px-2 mycart-quantity-minus" button-status="minus" item-id="{{$item['item_id']}}">
                                                                            <i class="fa fa-minus text-muted"></i>
                                                                        </button>

                                                                        <input id="quantity_value_{{$item['item_id']}}" button-status="input" item-id="{{$item['item_id']}}" min="0" name="quantity" value="{{$item['order_quantity']}}" type="type" class="form-control form-control-sm text-center input_value"/>

                                                                        <button class="btn btn-link px-2 mycart-quantity-plus" button-status="plus" item-id="{{$item['item_id']}}">
                                                                            <i class="fa fa-plus text-muted"></i>
                                                                        </button>

                                                                        <a data-href="{{route('cart_update')}}" id="cart_update"></a>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2"
                                                                     style="margin-left: 0px !important;padding: 0px !important;">
                                                                    <h6 class="mb-0 text-right subtotal_{{$item['item_id']}}">{{number_format($item['subtotal'],2)}}</h6>
                                                                </div>
                                                            </div>
                                                            <hr class="my-4">
                                                            @php
                                                                $totalItem = $totalItem + $item['order_quantity'];
                                                                $totalPrice = $totalPrice + $item['subtotal'];
                                                            @endphp
                                                        @endforeach
                                                        <div
                                                            class="row mb-4 d-flex justify-content-between align-items-center">
                                                            <div class="col-md-2 col-lg-2 col-xl-2">
                                                                <b>Total</b>
                                                            </div>

                                                            <div class="col-md-3 col-lg-3 col-xl-3">

                                                            </div>
                                                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                                <b class="total-quantity">{{$totalItem}}</b>
                                                            </div>
                                                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1 text-end" style="margin-left: 0px !important;padding: 0px !important;">
                                                                <h6 class="mb-0 text-right total-amount">{{number_format($totalPrice,2)}}</h6>

                                                            </div>
                                                        </div>
                                                        <hr class="my-4">
                                                    @endif

                                                    <div class="pt-5">
                                                        <h6 class="mb-0"><a href="#!" class="text-body">
                                                                <i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop
                                                            </a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 bg-grey">
                                                <div class="p-5">
                                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                                    <hr class="my-4">

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;" class="text-uppercase QUANTITYITEMS">
                                                            items {{count($cart_items)>0?count($cart_items):0}}</h5>
                                                        <h5 style="font-size: 15px !important;"  class="total-amount-tk">
                                                            TK. {{number_format($totalPrice,2)}}
                                                            <input type="hidden" name="total_price" value="{{$totalPrice}}">
                                                        </h5>
                                                    </div>

                                                    <hr class="my-4">

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;" class="text-uppercase ">Refer Discount</h5>
                                                        <h5 style="font-size: 15px !important;"  class="refer-discount">
                                                            TK. {{number_format(0,2)}}
                                                            <input type="hidden" name="refer_discount" value="{{0}}">
                                                        </h5>
                                                    </div>

                                                    <hr class="my-4">

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;width: 60%" class="text-uppercase ">
                                                            <a data-href="{{route('get_promo_discount')}}" id="get_promo_discount"></a>
                                                            <input type="text" name="promo_code" id="promo_code" class="form-control" placeholder="Promo Code">
                                                        </h5>
                                                        <h5 style="font-size: 15px !important;"  class="promo-discount">
{{--                                                            TK. {{number_format(0,2)}}--}}
                                                            TK. 0.00
{{--                                                            <input type="hidden" name="refer_discount" value="{{0}}">--}}
                                                        </h5>
                                                    </div>

                                                    <hr class="my-4">

                                                    <div class="d-flex justify-content-between mb-5">
                                                        <h5 class="text-uppercase" style="font-size: 15px !important;">Total price</h5>
                                                        <h5 style="font-size: 15px !important;" class="total_amount_without_refer">
                                                            Tk. {{number_format($totalPrice,2)}}</h5>
                                                    </div>

                                                    <?php $setting = App\Models\PaymentSetting::find(1); ?>

                                                    @if($totalItem>0 && $user)
                                                        <div class="card checkout-right">
                                                            <div class="card-body">
                                                                <h5 class="mb-4"> Shipping Details </h5>
                                                                <div class="payments">
                                                                    <label class="chk-container">{{$user->address1?$user->address1:$user->address2}}</label>
                                                                    <p>
                                                                        @php
                                                                            $upazila = \App\Models\Upazila::find($user->upazila);
                                                                            $district = \App\Models\District::find($user->district);
                                                                            $division = \App\Models\Division::find($user->division);
                                                                            $country = \App\Models\Country::find($user->country);
                                                                        @endphp
                                                                        {{$upazila ? $upazila->name.' , ':''}}
                                                                        {{$district ? $district->name.' , ':''}}
                                                                        {{$division ? $division->name.' , ':''}}
                                                                        {{$country ? $country->name:''}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($totalItem>0)
                                                        <br>
                                                        <div class="card checkout-right">
                                                            <div class="card-body">
                                                                <h5 class="mb-4"> {{ __('Choose Payment') }}</h5>
                                                                <div class="payments">
                                                                    <label class="chk-container">{{ __('Cash On Delivery') }}
                                                                        <input type="radio" name="payment_type"
                                                                               class="payment_method" value="LOCAL" checked>
                                                                        <span class="checkmark"></span>
                                                                    </label>

                                                                    <label class="chk-container">Debit / Credit Card / Mobile Payment
                                                                        <input type="radio" name="payment_type"
                                                                               class="payment_method" value="PAYPAL">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>
                                                    @endif
                                                        <button type="submit"
                                                                class="register_button btn btn-dark btn-block btn-lg"
                                                                data-mdb-ripple-color="dark">Next
                                                        </button>
                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </section>

    @push('EveryPageCustomJS')
        <script>
            $(document).on('keyup', '#promo_code', function (e) {
                let promoCode = $(this).val();
                let url = jQuery('#get_promo_discount').attr('data-href');
                jQuery.ajax({
                    url: url,
                    method: "get",
                    data: {promoCode:promoCode},
                    dataType: "json",
                    beforeSend: function (xhr) {

                    }
                }).done(function( response ) {
                    $('.promo-discount').text('TK. '+response.promoDiscount);
                    $('.total_amount_without_refer').text('TK. '+response.totalAmount);
                }).fail(function( jqXHR, textStatus ) {

                });
                return false;
            });

            $(document).delegate(".input_value",'change',function(e) {
                let itemId = jQuery(this).attr('item-id');
                let orderQuantity = jQuery(this).val();
                if (orderQuantity == 0){
                    orderQuantity = 1;
                }
                ajaxCall(orderQuantity,itemId)
            })


            $(document).delegate(".mycart-quantity-plus ,.mycart-quantity-minus",'click',function(e) {
                e.preventDefault();
                let itemId = jQuery(this).attr('item-id');
                let buttonStatus = jQuery(this).attr('button-status');
                let promoCode = jQuery('#promo_code').val();

                let orderQuantity = jQuery('#quantity_value_'+itemId).val();
                orderQuantity = parseInt(orderQuantity);

                if (buttonStatus == 'plus'){
                    orderQuantity = orderQuantity+1;
                }

                if (buttonStatus == 'minus'){
                    orderQuantity = orderQuantity-1;
                    if (orderQuantity == 0){
                        orderQuantity = 1;
                    }
                }
                ajaxCall(orderQuantity,itemId,promoCode)
            });

            function ajaxCall(orderQuantity,itemId,promoCode) {
                let url = jQuery('#cart_update').attr('data-href');
                jQuery.ajax({
                    url: url,
                    method: "get",
                    data: {itemId:itemId,orderQuantity:orderQuantity,promoCode:promoCode},
                    dataType: "json",
                    beforeSend: function (xhr) {

                    }
                }).done(function( response ) {
                    $('#quantity_value_'+itemId).val(response.order_quantity);
                    $('.subtotal_'+itemId).text(response.subtotal);
                    $('.total-quantity').text(response.total_order_qty);
                    $('.QUANTITYITEMS').text(' items '+response.total_order_qty);
                    $('.total-amount').text(response.total_amount);
                    $('.refer-discount').text('TK. '+response.refer_discount);
                    $('.total-amount-tk').text('TK. '+response.total_amount);
                    $('.total_amount_without_refer').text('TK. '+response.total_amount_without_refer);
                    $('.promo-discount').text('TK. '+response.promoDiscount);
                }).fail(function( jqXHR, textStatus ) {

                });
                return false;
            }


            $(document).delegate('.division','change',function () {
                let divisionID = $(this).val();
                let route = $('#getDistrictRoute').attr('data-href');
                jQuery('#district').html([]);
                jQuery('#upazila').html([]);
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {divisionID: divisionID},
                    beforeSend: function( xhr ) {

                    }
                }).done(function( response ) {
                    let allDistricts = response;
                    let districtsDataOption = '';
                    districtsDataOption='<option value="">Choose District</option>';
                    jQuery.each(allDistricts, function(i, item) {
                        districtsDataOption += '<option value="'+i+'">'+item+'</option>';
                    });
                    jQuery('#district').html(districtsDataOption);
                    jQuery('#district').prop('disabled', false);
                }).fail(function( jqXHR, textStatus ) {

                });
            });

            $(document).delegate('.district','change',function () {
                let districtID = $(this).val();
                let route = $('#getUpazilaRoute').attr('data-href');
                jQuery('#upazila').html([]);
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {districtID: districtID},
                    beforeSend: function( xhr ) {

                    }
                }).done(function( response ) {
                    let allUpazilas = response;
                    let upazilasDataOption = '';
                    upazilasDataOption='<option value="">Choose Upazila</option>';
                    jQuery.each(allUpazilas, function(i, item) {
                        upazilasDataOption += '<option value="'+i+'">'+item+'</option>';
                    });
                    jQuery('#upazila').html(upazilasDataOption);
                    jQuery('#upazila').prop('disabled', false);
                }).fail(function( jqXHR, textStatus ) {

                });
            });


        </script>
    @endpush

@endsection





