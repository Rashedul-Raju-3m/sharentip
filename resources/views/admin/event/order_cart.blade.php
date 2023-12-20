@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Event Detail'),
            'headerData' => __('Event') ,
            'url' => 'events' ,
        ])

      <div class="section-body">
         <div class="row event-single">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="event-img w-100" style="background: url({{url('images/upload/'.$event->image)}})">
                                </div>
                            </div>
                            <div class="col-12 event-description">
                                <h2 class="mt-3">{{$event->name}}
{{--                                    <button type="button" class="btn btn-primary "><a class="text-white" href="{{url($event->id.'/'.preg_replace('/\s+/', '-', $event->name).'/tickets')}}">{{__('Manage Tickets')}}</a></button>--}}
                                </h2>
                                <p> {!!$event->description!!}  </p>
                            </div>
                        </div>
                        <div class="row ml-0 mr-0 mt-4">
                            <div class="col-lg-3">
                                <div class="card single-card-light">
                                    <div class="row">
                                        <div class="col-3 text-center">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">{{__('People allowed')}}</p>
                                            <span>{{$event->people}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card single-card-light">
                                    <div class="row">
                                        <div class="col-3 text-center">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">{{__('Date')}}</p>
                                            <span>{{Carbon\Carbon::parse($event->start_time)->format('l').','}}{{$event->start_time->format('d F Y')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card single-card-light">
                                    <div class="row">
                                        <div class="col-2 text-center">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">{{__('Location')}}</p>
                                            @if($event->type=="offline")
                                            <span> {{$event->address}} </span>
                                            @else
                                            <span> {{__('Online Event')}} </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                {{--<h2 class="section-title"> {{__('Recent Sales')}}</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="">
                                <thead>
                                    <tr>
                                        <th>{{__('Order Id')}}</th>
                                        <th>{{__('Customer Name')}}</th>
                                        <th>{{__('Ticket Name')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Sold Ticket')}}</th>
                                        <th>{{__('Payment')}}</th>
                                        <th>{{__('Payment Gateway')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->sales as $item)
                                        <tr>
                                            <td>{{$item->order_id}}</td>
                                            <td>{{$item->customer->name}}</td>
                                            <th>{{$item->ticket->name}}</th>
                                            <th>{{$item->created_at->format('Y-m-d')}}</th>
                                            <th>{{$item->quantity}}</th>
                                            <th>{{$currency.$item->payment}}</th>
                                            <th>{{$item->payment_type}}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>--}}

                 @php
                     use App\Models\Country;
                     use App\Models\District;
                     use App\Models\Division;
                     use App\Models\Upazila;
                     use Illuminate\Support\Facades\Auth;
                     #$user = Auth::guard('appuser')->user();
                     $user = \App\Models\User::find($event['user_id']);
                     $totalItem = 0;
                     $totalPrice = 0;
                     $status = session('status');
                     $cart_items = $orderItems['orderItem'];

                     if($status){
                         if (isset($status->id)){
                             $orderBilling = \App\Models\OrderBilling::where('order_id',$status->id)->first();
                         }
                         $districts = [];
                         $upazilas = [];
                         if ($user->division){
                             $districts = District::GetAllDivisionWiseDistrictDropdownData($user->division);
                         }
                         if ($user->district){
                             $upazilas = Upazila::GetAllDistrictWiseUpazilaDropdownData($user->district);
                         }
                         $country = Country::GetAllCountry();
                         $divisions = Division::GetAllDivisionDropdownData();
                     }
                 @endphp
                 <section class="" style="background-color: #d2c9ff;">
                     <div class="container py-5 h-100">
                         <div class="row d-flex justify-content-center align-items-center h-100">
                             <div class="col-12">
                                 @if (session('status'))
                                     @if(isset($orderBilling))
                                         <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                             <div class="card-body p-0">
                                                 <div class="row g-0">
                                                     <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 100%;margin-bottom: 0px;">
                                                         Order process successfully. Order NO # {{$status->order_id}}

                                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @else

                                         <form action="{{ url('/order/place/event') }}" method="POST">
                                             <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                                 <div class="card-body p-0">
                                                     <div class="row g-0">
                                                         <div class="col-lg-8">
                                                             <div class="p-5">
                                                                 {{--<div class="d-flex justify-content-between align-items-center mb-5">
                                                                     <h3 class="fw-bold mb-0 text-black">If you change billing information , please fill-up.</h3>
                                                                 </div>--}}

                                                                 {{--                                                    <form action="{{ route('update_order_billing',$status->id) }}" method="post"  data-qa="form-login" name="login">--}}
                                                                 @csrf
                                                                 <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">Update Shipping Information</p>
                                                                 <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                                                                     <div class="row">
                                                                         <div class="col-lg-12">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Email')}}</label></div>
                                                                                 <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                                     <input autocomplete="off" class="RJT7RW5k" required name="email" type="email" value="{{$user->email}}" placeholder="{{ __('Your Email') }}" readonly>
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
                                                                                     <input autocomplete="off" class="RJT7RW5k" required name="phone" type="text" value="{{$user->phone}}" placeholder="Enter mobile">
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
                                                                                     <input autocomplete="off" class="RJT7RW5k" required name="name" type="text" value="{{ $user->name }}" placeholder="{{ __('First Name') }}">
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
                                                                                     <input autocomplete="off" class="RJT7RW5k" required name="last_name" value="{{$user->last_name}}"  type="text" placeholder="{{ __('Last Name') }}">
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
                                                                                 <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Address 1 </label></div>
                                                                                 <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                                     <input autocomplete="off" class="RJT7RW5k" name="address1" type="textarea" value="{{$user->address1}}" placeholder="Enter address 1">
                                                                                 </div>
                                                                                 @error('address1')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>
                                                                     </div>

                                                                     <div class="row">
                                                                         <div class="col-lg-12">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Address 2 </label></div>
                                                                                 <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                                     <input autocomplete="off" class="RJT7RW5k" name="address2" type="textarea" value="{{$user->address2}}" placeholder="Enter address 2">
                                                                                 </div>
                                                                                 @error('address2')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>
                                                                     </div>

                                                                     {{--<div class="row">
                                                                         <div class="col-lg-12">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Address 2</label></div>
                                                                                 <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                                     <input autocomplete="off" class="RJT7RW5k" name="address2" type="textarea" value="{{$user->address2?$user->address2:''}}" placeholder="Enter address 1">
                                                                                 </div>
                                                                                 @error('address2')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>
                                                                     </div>--}}

                                                                     <div class="row">
                                                                         <div class="col-lg-6">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">Choose Country</label> </div>
                                                                                 <div class="_2fessCXR p2xx3nlH">
                                                                                     <select required name="country" class="form-control select2">
                                                                                         <option value="">Choose Country</option>
                                                                                         @foreach ($country as $val)
                                                                                             <option value="{{$val->id}}"
                                                                                                 {{$val->id==18?'Selected' : ''}}>{{$val->name}}</option>
                                                                                         @endforeach
                                                                                     </select>
                                                                                 </div>
                                                                                 @error('country')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>
                                                                         <div class="col-lg-6">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Division</label></div>
                                                                                 <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                                                                     {!! Form::Select('division',$divisions,$user->division,['placeholder'=>'Choose Division','id'=>'type', 'class'=>'_2fessCXR p2xx3nlH up-A7EAi division select2'.($errors->has('division') ? 'is-invalid':'')]) !!}
                                                                                 </div>
                                                                                 @error('division')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-lg-6">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">District</label> </div>
                                                                                 <div class="_2fessCXR p2xx3nlH">
                                                                                     <a data-href="{{route('get_division_wise_district_user')}}" style="display: none" id="getDistrictRoute"></a>
                                                                                     {!! Form::Select('district',$districts,$user->district,['placeholder'=>'Choose District','id'=>'district', 'class'=>'_2fessCXR p2xx3nlH up-A7EAi district select2'.($errors->has('district') ? 'is-invalid':'')]) !!}
                                                                                 </div>
                                                                                 @error('district')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-lg-6">
                                                                             <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                                                                                 <div class="_2iCrTJcD"> <label class="_2x_Fz5Ot" data-qa="label-name">Upazila</label> </div>
                                                                                 <div class="_2fessCXR p2xx3nlH">
                                                                                     <a data-href="{{route('get_district_wise_upazila_user')}}" style="display: none" id="getUpazilaRoute"></a>
                                                                                     {!! Form::Select('upazila',$upazilas,$user->upazila,['placeholder'=>'Choose Upazila','id'=>'upazila', 'class'=>'_2fessCXR p2xx3nlH up-A7EAi select2'.($errors->has('upazila') ? 'is-invalid':'')]) !!}
                                                                                 </div>
                                                                                 @error('upazila')
                                                                                 <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                                                                                 @endif
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>

                                                                 <div class="pt-5">
                                                                     <h6 class="mb-0"><a href="" class="text-body">
                                                                             <i class="fas fa-long-arrow-alt-left me-2"></i>Back to Cart
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
                                                                         TK. {{number_format($status['total_price'],2)}}
                                                                     </h5>
                                                                 </div>

                                                                 <hr class="my-4">

                                                                 <div class="d-flex justify-content-between mb-5">
                                                                     <h5 class="text-uppercase" style="font-size: 15px !important;">Total
                                                                         price</h5>
                                                                     <h5 style="font-size: 15px !important;" class="total-amount-tk">
                                                                         Tk. {{number_format($status['total_price'],2)}}
                                                                     </h5>
                                                                 </div>

                                                                 <div class="card checkout-right">
                                                                     <div class="card-body">
                                                                         <h5 class="mb-4"> {{ __('Choose Payment') }}</h5>
                                                                         <div class="payments">
                                                                             <label class="chk-container">{{ __('Cash On Delivery') }}
                                                                                 <input type="radio" name="payment_type"
                                                                                        class="payment_method" value="LOCAL"
                                                                                     {{$status['payment_type']==='LOCAL'?'checked':''}}
                                                                                 >
                                                                                 <span class="checkmark"></span>
                                                                             </label>

                                                                             <label class="chk-container">Debit / Credit Card / Mobile Payment
                                                                                 <input type="radio" name="payment_type"
                                                                                        class="payment_method" value="PAYPAL"
                                                                                     {{$status['payment_type']==='PAYPAL'?'checked':''}}
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
                                                                         Order Place
                                                                     </button>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </form>
                                     @endif

                                 @else
                                     <div class="card card-registration card-registration-2" style="border-radius: 15px;">

                                         @if($user)
                                             <form action="{{ url('/order/place/next/event') }}" method="POST">
                                                 @csrf
                                                 @endif
                                                 <div class="card-body p-0">
                                                     <div class="row g-0">
                                                         <div class="col-lg-8">
                                                             <div class="p-5">
                                                                 <div class="d-flex justify-content-between align-items-center mb-5">
                                                                     <h1 class="fw-bold mb-0 text-black">Item Cart</h1>
                                                                     <h6 class="mb-0 text-muted">{{count($cart_items)>0?count($cart_items):0}}
                                                                         items</h6>
                                                                     <input type="hidden" name="event_id" value="{{$event->id}}">
                                                                 </div>


                                                                 @if(count($cart_items)>0)
                                                                     <div
                                                                         class="row mb-4 d-flex justify-content-between align-items-center"
                                                                         style="background: #37517e;
padding: 10px;">
                                                                         <div class="col-md-2" style="padding: 0 !important;"></div>
                                                                         <div class="col-md-2" style="padding: 0 !important;">
                                                                             <h6 class="text-black mb-0" style="color: white">Item Name</h6>
                                                                         </div>

                                                                         <div class="col-md-2" style="padding: 0 !important;">
                                                                             <h6 class="text-black mb-0" style="color: white">Bundle QTY</h6>
                                                                         </div>

                                                                         <div class="col-md-2" style="padding: 0 !important;">
                                                                             <h6 class="text-black mb-0" style="color: white">Order Qty</h6>
                                                                         </div>

                                                                         <div class="col-md-2" style="padding: 0 !important;">
                                                                             <h6 class="text-black mb-0" style="color: white">Item Price</h6>
                                                                         </div>
                                                                         <div class="col-md-2" style="padding: 0 !important;">
                                                                         </div>
                                                                     </div>
                                                                     @php
                                                                         $totalItem = 0;
                                                                         $totalPrice = 0;
                                                                     @endphp
 @foreach($cart_items as $key => $item)
     @php
        $service = \App\Models\Service::find($item['service_id']);
     @endphp
     <div class="row mb-4 d-flex justify-content-between align-items-center">
         <div class="col-md-2 " style="padding: 0 !important;">
             <img src="{{ url('images/upload/'.$service['image'])}}" class="img-fluid rounded-3" alt="{{$item['item_name']}}">
         </div>

         <div class="col-md-2 " style="padding: 0 !important;">
             @php
                 $serviceCategory = \App\Models\ServiceCategory::find($item['service_category_id']);

             @endphp
             <h6 class="text-muted">{{$serviceCategory->name}}</h6>
             <h6 class="text-black mb-0">{{$item['item_name']}}</h6>
             <h6 class="text-black mb-0">{{$service['company_name']}}</h6>
         </div>
         <div class="col-md-2 " style="padding: 0 !important;">
             {{$item['bundle_quantity']}}
         </div>
         <div class="col-md-2 " style="padding: 0 !important;">
             <div class=" d-flex">
                 @if($event->sold == 0)
                 <button class="btn btn-link px-2 mycart-quantity-minus" button-status="minus" item-id="{{$item['item_id']}}">
                     <i class="fa fa-minus text-muted"></i>
                 </button>


                 <input id="quantity_value_{{$item['item_id']}}" button-status="input" item-id="{{$item['item_id']}}" min="0" name="quantity[]" value="{{$item['order_quantity']}}" type="type" class="form-control form-control-sm text-center input_value"/>
                     <input type="hidden" name="order_item_id[]" value="{{$item['id']}}">

                 <button class="btn btn-link px-2 mycart-quantity-plus" button-status="plus" item-id="{{$item['item_id']}}" unit-price="{{$item['item_price']/$item['order_quantity']}}">
                     <i class="fa fa-plus text-muted"></i>
                 </button>
                 @else
                     <span class="btn btn-link px-2">{{$item['order_quantity']}}</span>
                 @endif

                 <a data-href="{{route('cart_update')}}" id="cart_update"></a>
             </div>
         </div>
         <div class="col-md-2"
              style="margin-left: 0px !important;padding: 0px !important;">
             <h6 class="mb-0 text-right subtotal_{{$item['item_id']}}">{{number_format($item['item_price'],2)}}</h6>
         </div>
         <div class="col-md-2 col-lg-1 col-xl-1 text-end" style="padding: 0 !important;">
             @if($event->sold == 0)
             <a onclick="return confirm(' you want to remove from cart?');"
                href="{{route('cart_item_remove',$item['item_id'])}}"
                class="text-muted"><i class="fa fa-trash"
                                      aria-hidden="true"></i></a>
             @endif
         </div>
     </div>
     <hr class="my-4">
     @php
         $totalItem = $totalItem + $item['order_quantity'];
         $totalPrice = $totalPrice + $item['item_price'];
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
                                                                         <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1 text-end"
                                                                              style="margin-left: 0px !important;padding: 0px !important;">
                                                                             <h6 class="mb-0 text-right total-amount">{{number_format($totalPrice,2)}}</h6>

                                                                         </div>
                                                                         <div class="col-md-1 col-lg-1 col-xl-1 text-end">

                                                                         </div>
                                                                     </div>
                                                                     <hr class="my-4">
                                                                 @endif

                                                                 {{--<div class="pt-5">
                                                                     <h6 class="mb-0"><a href="#!" class="text-body">
                                                                             <i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop
                                                                         </a>
                                                                     </h6>
                                                                 </div>--}}
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

                                                                 <div class="d-flex justify-content-between mb-5">
                                                                     <h5 class="text-uppercase" style="font-size: 15px !important;">Total
                                                                         price</h5>
                                                                     <h5 style="font-size: 15px !important;" class="total-amount-tk">
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
                                                                                 <label class="chk-container">
                                                                                     <span class="checkmark"></span>
                                                                                     <input type="radio" name="payment_type"
                                                                                            class="payment_method" value="LOCAL" checked>
                                                                                     {{ __('Cash On Delivery') }}
                                                                                 </label>

                                                                                 <label class="chk-container">
                                                                                     <span class="checkmark"></span>

                                                                                     <input type="radio" name="payment_type"
                                                                                            class="payment_method" value="PAYPAL">
                                                                                     Debit / Credit Card / Mobile Payment
                                                                                 </label>
                                                                             </div>
                                                                         </div>
                                                                     </div>

                                                                     <br>
                                                                 @endif
                                                                 @if($user)
                                                                     @if($totalItem>0)
                                                                         <button type="submit" class="register_button btn btn-dark btn-block btn-lg"
                                                                                 data-mdb-ripple-color="dark">Next
                                                                         </button>
                                                                    @endif

                                             </form>
                                         @else
                                             <a href="{{route('user_login_checkout','checkout')}}">
                                                 <button type="button" class="register_button btn btn-dark btn-block btn-lg"
                                                         data-mdb-ripple-color="dark">Register
                                                 </button>
                                             </a>
                                         @endif

                                     </div>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </section>
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
                    $('#quantity_value_'+itemId).val(response.order_quantity);
                    $('.subtotal_'+itemId).text(response.subtotal);
                    $('.total-quantity').text(response.total_order_qty);
                    $('.QUANTITYITEMS').text(' items '+response.total_order_qty);
                    $('.total-amount').text(response.total_amount);
                    $('.total-amount-tk').text('TK. '+response.total_amount);
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
