@extends('frontend.master', ['activePage' => 'sevice'])

@section('content')

    @include('frontend.layout.breadcrumbs', [
        'title' => $serviceCategory->name,
        'page' => 'Service Category',
    ])

    <section class="property-single nav-arrow-b">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
                        <div class="carousel-item-b">
                            <img src="{{url('images/upload/'.$serviceCategory->image)}}" alt="">
                        </div>
                        @foreach (explode(',',$serviceCategory->gallery) as $item)
                            <div class="carousel-item-b">
                                <img src="{{url('images/upload/'.$item)}}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="row justify-content-between">
                        <div class="col-md-12">
                            <div class="title-box-d">
                                <h3 class="title-d cat_name">{{$serviceCategory->name}}</h3>
                                <p>{{$serviceCategory->created_at->diffForHumans()}} , Post Date :: {{date_format($serviceCategory->created_at,'d-M-Y')}}</p>
                                <div class="tab">
                                    @if(count($serviceCategories)>0)
                                        @foreach($serviceCategories as $serviceCategorie)
                                            <button class="tablinks" id="click_{{$serviceCategorie->id}}"
                                                    onclick="openCity(event, {{$serviceCategorie->id}})">
                                                {{$serviceCategorie->name}}
                                            </button>
                                        @endforeach
                                    @endif
                                </div>

                                @if(count($serviceCategories)>0)
                                    @foreach($serviceCategories as $serviceCategorie)
                                        @php

                                            $services = \App\Models\Service::where([['service_category_id',$serviceCategorie->id],['is_active',1],['is_delete',0]])->get();
                                        @endphp
                                        <div id="{{$serviceCategorie->id}}" class="tabcontent table-responsive">
                                            @if(count($services)>0)

                                                <div class="d-flex justify-content-center row">
                                                    <div class="col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;">
                                                        <div class="rounded">
                                                            <div class="table-responsive table-borderless">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center">Service Name</th>
                                                                        <th>Company Name</th>
                                                                        <th>Contact Person</th>
                                                                        <th>Mobile</th>
                                                                        <th>Email</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="table-body">
                                                                    @foreach($services as $service)
                                                                        <tr class="cell-{{$service->id}}"
                                                                            data-toggle="collapse"
                                                                            data-target="#demo{{$service->id}}">
                                                                            <td>{{$service->name}}</td>
                                                                            <td>{{$service->company_name}}</td>
                                                                            <td>{{$service->contact_person_name}}</td>
                                                                            <td>{{$service->contact_person_mobile}} </td>
                                                                            <td>{{$service->contact_person_email}} </td>
                                                                        </tr>

                                                                        @php
                                                                            $items = \App\Models\ServiceItem::where([['service_id',$service->id]])->get();
                                                                        @endphp
                        @if(count($items)>0)

                            <tr style="background-color: #3bb557" id="demo{{$service->id}}" class="collapse cell-{{$service->id}} row-child" >
                                <th>Item Name</th>
                                <th> Description</th>
                                <th> Price</th>
                                <th> Qty</th>
                                <th>
                                    <button class="btn btn-dark service_details" data-id="{{$service->id}}" data-href="{{route('service_details_model')}}" >Details</button>
                                </th>
                            </tr>

                            @foreach($items as $item)
                                <tr id="demo{{$service->id}}" class="collapse cell-{{$service->id}} row-child">
                                    <td>{{$item->item_name}}</td>
                                    <td>{{$item->item_description}}</td>
                                    <td>{{$item->item_price}}</td>
                                    <td>{{$item->item_quantity}}</td>
                                    <td>
                                        <button class="btn btn-success add_cart_ajax" item-name="{{$item->item_name}}" item-description="{{$item->item_description}}" unit-price="{{$item->item_price}}" item-quantity="{{$item->item_quantity}}" item-service="{{$item->service_id}}" service-category="{{$item->service_category_id}}" item-id="{{$item->id}}" order-quantity="1" image="{{$service->image}}" company_name="{{$service->company_name}}" data-href="{{route('add_item_to_cart')}}">Add to cart</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-size: 20px;
font-weight: bold;">Service Details</h4>
                        <button style="margin-top: -29px;
color: #000;" type="button" class="close model-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('EveryPageCustomJS')
        <script>

            $(function () {
                $('#click_{{$serviceCategory->id}}').click();
            });

            function openCity(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }

            $(document).delegate('.item_show', 'click', function () {
                let id = $(this).attr('id');
                $('.item-hide').hide(1500)
                $('#item_' + id).show(1500)
            });


            $(document).delegate(".add_cart_ajax",'click',function(e) {
                e.preventDefault();

                let itemName = jQuery(this).attr('item-name');
                let itemDescription = jQuery(this).attr('item-description');
                let unitPrice = jQuery(this).attr('unit-price');
                let itemQuantity = jQuery(this).attr('item-quantity');
                let serviceId = jQuery(this).attr('item-service');
                let serviceCategory = jQuery(this).attr('service-category');
                let itemID = jQuery(this).attr('item-id');
                let image = jQuery(this).attr('image');
                let company_name = jQuery(this).attr('company_name');
                let order_quantity = jQuery(this).attr('order-quantity');

                let url = jQuery(this).attr('data-href');

                jQuery.ajax({
                    url: url,
                    method: "get",
                    data: {itemName:itemName,itemDescription:itemDescription,unitPrice:unitPrice,itemQuantity: itemQuantity,serviceCategory:serviceCategory,itemID:itemID,serviceId:serviceId,company_name:company_name,image:image,order_quantity:order_quantity},
                    dataType: "json",
                    beforeSend: function (xhr) {

                    }
                }).done(function( response ) {
                    let timerInterval
                    Swal.fire({
                        title: response.message,
                        // html: 'Item name : '+response.item.item_name+'<br>'+'Item quantity : '+response.item.item_quantity+'<br>'+'Item price : '+response.item.item_price+'<br> close in <b></b> milliseconds.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })
                    // jQuery('.cart-count').text(response.total_item);
                    jQuery('.total_item').text(response.total_item);
                    // jQuery('.price').text(response.cart_total);
                    // jQuery('.products').html(response.cart_body);


                }).fail(function( jqXHR, textStatus ) {

                });
                return false;

            });

            $(document).delegate('.model-close','click',function () {
                $('.modal').modal('hide');
            });

            $(document).delegate('.service_details','click',function () {
                let serviceID = $(this).attr('data-id');
                let route = $(this).attr('data-href');

                jQuery.ajax({
                    url: route,
                    method: "get",
                    data: {serviceID:serviceID},
                    dataType: "json",
                    beforeSend: function (xhr) {

                    }
                }).done(function( response ) {
                    jQuery('.modal-title').text(response.category_name);
                    jQuery('.modal-body').html(response.content);
                    $('.modal').modal('show');
                }).fail(function( jqXHR, textStatus ) {

                });
                return false;
            });

        </script>

    @endpush

@endsection


