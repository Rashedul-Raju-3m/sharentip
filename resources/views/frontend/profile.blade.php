@extends('frontend.master', ['activePage' => 'profile'])

@section('content')

    <section class="agent-single">
        <div class="profile-top-section" style="background-image: url('https://wallpapercave.com/wp/q1QDvC6.jpg')">
            <div class="profile-overly"></div>
        </div>
        <div class="container">
            <div class="row">


                <div class="col-lg-4 profile-left">
                    <div class="profile-image text-center">
                        <img src="{{url('images/upload/'.$user->image)}}" id="imagePreview" class="avatar">
                        <div class="edit-profile-img">
                          <form method="post" action="#" id="imageUploadForm" enctype="multipart/form-data" >
                            @csrf
                            <input type="file" name="image" id="imgUpload" class="hide">
                          </form>
                            <span id="OpenImgUpload"><i class="fa fa-camera"></i></span>
                        </div>
                    </div>
                    <div class="user-description">
                        <h4 class="text-center mb-1">{{$user->name.' '.$user->last_name}}</h4>
                        <p class="text-center mb-1"><i class="fa fa-map-marker pr-2"></i>{{$user->address}}</p>
                        <p class="text-center"><i class="fa fa-envelope pr-2"></i>{{$user->email }}</p>

                    </div>
                    <div class="user-description bio-section px-5 mt-4">
                        @if($user->bio==null)
                        <p class="text-center">
                            <input type="text" name="bio" placeholder="{{ __('Your Bio') }}" class="bio-control hide">
                            <button class="btn btn-bio">{{__('Add Bio')}} <i class="fa fa-pencil pl-1"></i></button>
                        </p>
                        @else
                            <p class="detail-bio">{{$user->bio}}</p>
                        @endif
                    </div>
                    <div class="profile-left-link px-5 mt-4">
                      <p><a href="{{url('change-password')}}"> {{__('Change Password')}}</a></p>
                      <p><a href="{{url('my-tickets')}}"> {{__('My Tickets')}}</a></p>
                      <p><a href="{{url('update_profile')}}"> {{__('Update Profile')}}</a></p>
                      <p><a href="{{route('user_billing_info')}}">Billing Information</a></p>
                    </div>
                </div>
                <div class="col-lg-8 profile-right">
                    <div class="row">
                      <div class="col-12">
                        @if (session('status'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ session('status') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                        @endif
                      </div>
                    </div>
                    <ul class="nav nav-pills-a nav-pills mb-4 section-t1" id="pills-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="saved-event-tab" data-toggle="pill" href="#saved-event" role="tab" aria-controls="saved-event" aria-selected="true">On going</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="saved-blog-tab" data-toggle="pill" href="#saved-blog" role="tab" aria-controls="saved-blog" aria-selected="false">Already Delivered</a>
                        </li>
                        {{--<li class="nav-item">
                            <a class="nav-link" id="following-tab" data-toggle="pill" href="#following" role="tab" aria-controls="following" aria-selected="false">{{__('Following')}}</a>
                        </li>--}}
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="saved-event" role="tabpanel" aria-labelledby="saved-event-tab">
                            <div class="row">

                                <div class="table-responsive">
                                    <table class="table" id="report_table" style="font-size: 10px">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{__('Order Id')}}</th>
                                            <th>{{__('Customer Name')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>Total Item</th>
                                            <th>Total Price</th>
                                            <th>{{__('Payment Gateway')}}</th>
                                            <th width="15%">{{__('Order Status')}}</th>
                                            <th width="15%">{{__('Payment Status')}}</th>
                                            <th></th>
                                            {{--                                            <th>{{__('Action')}}</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($orders as $item)
                                            @if($item->status === 'Delivered')
                                                <tr>
                                                    <td></td>
                                                    <td class="cell-{{$item->id}}"
                                                        data-toggle="collapse"
                                                        data-target="#demo{{$item->id}}"
                                                        style="cursor: pointer;color: blue"
                                                    >
                                                        {{$item->order_id}}
                                                    </td>
                                                    <td>{{$item->orderCustomer->name.' '.$item->orderCustomer->last_name}}</td>

                                                    <td>
                                                        <p class="mb-0">{{$item->created_at->format('Y-m-d')}}</p>
                                                        {{--                                                        <p class="mb-0">{{$item->created_at->format('h:i a')}}</p>--}}
                                                    </td>
                                                    <td>{{$item->total_item}}</td>
                                                    <td>{{$item->total_price}}</td>
                                                    <td>{{$item->payment_type === 'cod' ? 'Cash on delivery':'Online Payment'}}</td>
                                                    <td width="15%">
                                                        {{$item->status}}
                                                    </td>
                                                    <td  width="15%" >
                                                        {{$item->is_payment === 0 ? 'Due' :'Paid'}}
                                                    </td>
                                                    <td></td>
                                                </tr>

                                                @if(count($item->orderItem)>0)
                                                    <tr style="background:rgb(206, 205, 205);text-align: center"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th colspan="10" style="padding: 0px">Item Details</th>
                                                    </tr>
                                                    <tr style="background: rgb(227, 227, 227);"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th></th>
                                                        <th colspan="2"> Name</th>
                                                        <th colspan="2">Description</th>
                                                        <th> Price</th>
                                                        <th>Bundle Qty.</th>
                                                        <th>Order Qty.</th>
                                                        <th colspan="2">Category</th>
                                                    </tr>
                                                    @foreach($item->orderItem as $myItem)
                                                        <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} " style="background: #eeebeb;">
                                                            <td></td>
                                                            <td colspan="2">{{$myItem->item_name}}</td>
                                                            <td colspan="2">{{$myItem->item_description}}</td>
                                                            <td>{{$myItem->item_price}}</td>
                                                            <td>{{$myItem->bundle_quantity}}</td>
                                                            <td>{{$myItem->order_quantity}}</td>
                                                            <th colspan="2">{{$myItem->serviceCategory->name}}</th>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                @if($item->orderBilling)
                                                    <tr style="background:rgb(206, 205, 205);text-align: center"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th colspan="10" style="padding: 0px">Shipping Details</th>
                                                    </tr>
                                                    <tr style="background: rgb(227, 227, 227);"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th></th>
                                                        <th colspan="2"> Name</th>
                                                        <th colspan="2">Address</th>
                                                        <th> Email</th>
                                                        <th>Mobile</th>
                                                        <th>Upazila</th>
                                                        <th>District</th>
                                                        <th>Division</th>
                                                    </tr>
                                                    {{--                                    @foreach($item->orderBilling as $myBilling)--}}
                                                    <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} " style="background: #eeebeb;">
                                                        <td></td>
                                                        <td colspan="2">{{$item->orderBilling->name.' '.$item->orderBilling->last_name}}</td>
                                                        <td colspan="2">{{$item->orderBilling->address1}}</td>
                                                        <td>{{$item->orderBilling->email}}</td>
                                                        <td>{{$item->orderBilling->mobile}}</td>
                                                        <td>
                                                            {{$item->orderBilling->shippingUpazila->name}} <br>
                                                            {{$item->orderBilling->shippingUpazila->bn_name}}
                                                        </td>
                                                        <td>
                                                            {{$item->orderBilling->shippingDistrict->name}} <br>
                                                            {{$item->orderBilling->shippingDistrict->bn_name}}
                                                        </td>
                                                        <td>
                                                            {{$item->orderBilling->shippingDivision->name}} <br>
                                                            {{$item->orderBilling->shippingDivision->bn_name}}
                                                        </td>
                                                    </tr>
                                                    {{--                                    @endforeach--}}
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="saved-blog" role="tabpanel" aria-labelledby="saved-blog-tab">
                            <div class="row">

                                <div class="table-responsive">
                                    <table class="table" id="report_table" style="font-size: 10px">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{__('Order Id')}}</th>
                                            <th>{{__('Customer Name')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>Total Item</th>
                                            <th>Total Price</th>
                                            <th>{{__('Payment Gateway')}}</th>
                                            <th width="15%">{{__('Order Status')}}</th>
                                            <th width="15%">{{__('Payment Status')}}</th>
                                            <th></th>
{{--                                            <th>{{__('Action')}}</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($orders as $item)
                                            @if($item->status === 'Delivered')
                                                <tr>
                                                    <td></td>
                                                    <td class="cell-{{$item->id}}"
                                                        data-toggle="collapse"
                                                        data-target="#demo{{$item->id}}"
                                                        style="cursor: pointer;color: blue"
                                                    >
                                                        {{$item->order_id}}
                                                    </td>
                                                    <td>{{$item->orderCustomer->name.' '.$item->orderCustomer->last_name}}</td>

                                                    <td>
                                                        <p class="mb-0">{{$item->created_at->format('Y-m-d')}}</p>
{{--                                                        <p class="mb-0">{{$item->created_at->format('h:i a')}}</p>--}}
                                                    </td>
                                                    <td>{{$item->total_item}}</td>
                                                    <td>{{$item->total_price}}</td>
                                                    <td>{{$item->payment_type === 'cod' ? 'Cash on delivery':'Online Payment'}}</td>
                                                    <td width="15%">
                                                        {{$item->status}}
                                                    </td>
                                                    <td  width="15%" >
                                                        {{$item->is_payment === 0 ? 'Due' :'Paid'}}
                                                    </td>
                                                    <td></td>
                                                </tr>

                                                @if(count($item->orderItem)>0)
                                                    <tr style="background:rgb(206, 205, 205);text-align: center"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th colspan="10" style="padding: 0px">Item Details</th>
                                                    </tr>
                                                    <tr style="background: rgb(227, 227, 227);"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th></th>
                                                        <th colspan="2"> Name</th>
                                                        <th colspan="2">Description</th>
                                                        <th> Price</th>
                                                        <th>Bundle Qty.</th>
                                                        <th>Order Qty.</th>
                                                        <th colspan="2">Category</th>
                                                    </tr>
                                                    @foreach($item->orderItem as $myItem)
                                                        <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} " style="background: #eeebeb;">
                                                            <td></td>
                                                            <td colspan="2">{{$myItem->item_name}}</td>
                                                            <td colspan="2">{{$myItem->item_description}}</td>
                                                            <td>{{$myItem->item_price}}</td>
                                                            <td>{{$myItem->bundle_quantity}}</td>
                                                            <td>{{$myItem->order_quantity}}</td>
                                                            <th colspan="2">{{$myItem->serviceCategory->name}}</th>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                @if($item->orderBilling)
                                                    <tr style="background:rgb(206, 205, 205);text-align: center"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th colspan="10" style="padding: 0px">Shipping Details</th>
                                                    </tr>
                                                    <tr style="background: rgb(227, 227, 227);"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                                        <th></th>
                                                        <th colspan="2"> Name</th>
                                                        <th colspan="2">Address</th>
                                                        <th> Email</th>
                                                        <th>Mobile</th>
                                                        <th>Upazila</th>
                                                        <th>District</th>
                                                        <th>Division</th>
                                                    </tr>
                                                    {{--                                    @foreach($item->orderBilling as $myBilling)--}}
                                                    <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} " style="background: #eeebeb;">
                                                        <td></td>
                                                        <td colspan="2">{{$item->orderBilling->name.' '.$item->orderBilling->last_name}}</td>
                                                        <td colspan="2">{{$item->orderBilling->address1}}</td>
                                                        <td>{{$item->orderBilling->email}}</td>
                                                        <td>{{$item->orderBilling->mobile}}</td>
                                                        <td>
                                                            {{$item->orderBilling->shippingUpazila->name}} <br>
                                                            {{$item->orderBilling->shippingUpazila->bn_name}}
                                                        </td>
                                                        <td>
                                                            {{$item->orderBilling->shippingDistrict->name}} <br>
                                                            {{$item->orderBilling->shippingDistrict->bn_name}}
                                                        </td>
                                                        <td>
                                                            {{$item->orderBilling->shippingDivision->name}} <br>
                                                            {{$item->orderBilling->shippingDivision->bn_name}}
                                                        </td>
                                                    </tr>
                                                    {{--                                    @endforeach--}}
                                                @endif
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection
