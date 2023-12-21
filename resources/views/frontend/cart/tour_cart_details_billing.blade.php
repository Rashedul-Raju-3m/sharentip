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
            $country = Country::GetAllCountry();
            $divisions = Division::GetAllDivisionDropdownData();
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
{{--                    @if (session('status'))--}}
                        @if(isset($orderHead))
                            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 100%;margin-bottom: 0px;">
                                            Order process successfully. Order NO # {{$orderHead->order_id}}

                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @else

                            <form action="{{ route('order_place') }}" method="POST">
                                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-lg-8">
                                                <div class="p-5">
                                                    @csrf
                                                    <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">Update Shipping Information</p>
                                                    <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Email')}}</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" name="email" type="email" value="" placeholder="{{ __('Your Email') }}">
                                                                        <input type="hidden" name="tour_date" value="{{$data['tour_date']}}">
                                                                    </div>
                                                                    @error('email')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Mobile</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" required name="phone" type="text" value="" placeholder="Enter mobile">
                                                                    </div>
                                                                    @error('phone')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('First Name')}}</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" required name="name" type="text" value="" placeholder="{{ __('First Name') }}">
                                                                    </div>
                                                                    @error('name')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Last Name')}}</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" required name="last_name" value=""  type="text" placeholder="{{ __('Last Name') }}">
                                                                    </div>
                                                                    @error('last_name')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Address </label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" name="address" type="textarea" value="" placeholder="Enter address">
                                                                    </div>
                                                                    @error('address')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Pickup Point </label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" name="pick_up_point" type="textarea" value="" placeholder="Enter pick up point">
                                                                    </div>
                                                                    @error('pick_up_pont')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Referer Number</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" name="referer_number" type="textarea" value="" placeholder="Enter referer number">
                                                                    </div>
                                                                    @error('referer_number')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                    <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Bkash/Nagad Transaction Number</label></div>
                                                                    <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                        <input autocomplete="off" class="RJT7RW5k" name="transaction_number" type="textarea" value="" placeholder="Enter transaction number">
                                                                    </div>
                                                                    @error('transaction_number')
                                                                    <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 bg-grey">
                                                <div class="p-5">
                                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                                    <hr class="my-4">

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;" class="text-uppercase">Booking Quantity</h5>
                                                        <h5 style="font-size: 15px !important;"  class="total-amount-tk">{{$data['totalQuantity']}}</h5>
                                                        <input type="hidden" name="totalQuantity" value="{{$data['totalQuantity']}}">
                                                    </div>

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;" class="text-uppercase">Subtotal</h5>
                                                        <h5 style="font-size: 15px !important;"  class="total-amount-tk">{{$data['subTotal']}}</h5>
                                                        <input type="hidden" name="subTotal" value="{{$data['subTotal']}}">
                                                    </div>

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;" class="text-uppercase">Refer Discount</h5>
                                                        <h5 style="font-size: 15px !important;"  class="total-amount-tk">{{number_format($data['referDiscount'],2)}}</h5>
                                                        <input type="hidden" name="referDiscount" value="{{$data['referDiscount']}}">
                                                    </div>

                                                    @if(isset($data['promoDiscount']) && $data['promoDiscount']>0)

                                                    <div class="d-flex justify-content-between mb-4">
                                                        <h5 style="font-size: 15px !important;" class="text-uppercase">Promo Discount</h5>
                                                        <h5 style="font-size: 15px !important;"  class="total-amount-tk">{{number_format($data['promoDiscount'],2)}}</h5>
                                                        <input type="hidden" name="promoDiscount" value="{{$data['promoDiscount']}}">
                                                    </div>
                                                    @endif

                                                    <hr class="my-4">

                                                    <div class="d-flex justify-content-between mb-5">
                                                        <h5 class="text-uppercase" style="font-size: 15px !important;">Total Amount</h5>
                                                        <h5 style="font-size: 15px !important;" class="total-amount-tk">
                                                            Tk. {{$data['totalAmount']}}
                                                        </h5>
                                                        <input type="hidden" name="totalAmount" value="{{$data['totalAmount']}}">
                                                    </div>

                                                    <div class="card checkout-right">
                                                        <div class="card-body">
                                                            <h5 class="mb-4"> {{ __('Choose Payment') }}</h5>
                                                            <div class="payments">
                                                                <label class="chk-container">{{ __('Cash On Delivery') }}
                                                                    <input type="radio" name="payment_type"
                                                                           class="payment_method" value="LOCAL"
                                                                        {{$data['payment_type']==='LOCAL'?'checked':''}}
                                                                    >
                                                                    <span class="checkmark"></span>
                                                                </label>

                                                                <label class="chk-container">Debit / Credit Card / Mobile Payment
                                                                    <input type="radio" name="payment_type"
                                                                           class="payment_method" value="PAYPAL"
                                                                        {{$data['payment_type']==='PAYPAL'?'checked':''}}
                                                                    >
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <span style="font-weight: bold;">SSLCommerz</span>
                                                    <p style="text-align: justify;background: #dadbdb;padding: 8px;">
                                                        Pay securely by Credit/Debit card, Internet banking or Mobile banking through SSLCommerz.
                                                    </p>
                                                    <hr>

                                                    <p style="text-align: justify;">
                                                        Your personal data will be used to process your order, support your experience through out this website, and for other purposes described in our
                                                        <a href="{{route('cms_page','privacy_policy')}}">privacy policy.</a>
                                                    </p>

                                                    <p style="text-align: justify;">
                                                        <input type="checkbox" required>
                                                        I have read and agree to the website <a href="{{route('cms_page','terms_conditions')}}">terms and conditions</a>,
                                                        <a href="{{route('cms_page','privacy_policy')}}">Privacy policy</a>, <a href="{{route('cms_page','refund_policy')}}">Refund Policy</a>
                                                    </p>
                                                    <br>

                                                    <div class="Flex-nqja63-0 styled__ButtonWrapper-sc-1vy69nr-0 lhtHXX">
                                                        <button type="submit" data-qa="login-button" class="styled__ButtonWrapper-sc-56doij-3 hnulbU">
                                                            Booking
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif

                </div>
            </div>
        </div>
    </section>

    @push('EveryPageCustomJS')
        <script>
            /*$(document).on('click', '.payment_method', function (e) {
                let paymentMethod = $(this).val();
                if (paymentMethod === 'LOCAL') {
                    $('.register_button').removeAttr("disabled");
                } else {
                    $('.register_button').attr('disabled', 'disabled');
                }
            });*/

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
                ajaxCall(orderQuantity,itemId)
            });

            function ajaxCall(orderQuantity,itemId) {
                let url = jQuery('#cart_update').attr('data-href');
                jQuery.ajax({
                    url: url,
                    method: "get",
                    data: {itemId:itemId,orderQuantity:orderQuantity},
                    dataType: "json",
                    beforeSend: function (xhr) {

                    }
                }).done(function( response ) {
                    console.log(response)
                    $('#quantity_value_'+itemId).val(response.order_quantity);
                    $('.subtotal_'+itemId).text(response.subtotal);
                    $('.total-quantity').text(response.total_order_qty);
                    $('.QUANTITYITEMS').text(' items '+response.total_order_qty);
                    $('.total-amount').text(response.total_amount);
                    $('.refer-discount').text('TK. '+response.refer_discount);
                    $('.total-amount-tk').text('TK. '+response.total_amount);
                    $('.total_amount_without_refer').text('TK. '+response.total_amount_without_refer);
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





