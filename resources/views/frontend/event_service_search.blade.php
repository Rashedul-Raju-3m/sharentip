@extends('frontend.master', ['activePage' => 'event'])

@section('content')

    @include('frontend.layout.breadcrumbs', [
        'title' => 'Advance Search',
        'page' => 'Advance Search',
    ])

    <section class="section-property" style="padding-top: 0px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class=" d-flex justify-content-between">
                        <form method="POST" action="{{ route('event_service_search') }}" style="width: 100%;" autocomplete="nope">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" name="search" id="search" required placeholder="Search events and categories" class="form-control">
                                <span class="input-group-btn" style="margin-left: 5px">
                                    <input type="submit" name="commit" value="Search" class="btn btn-primary" data-disable-with="Search">
                                </span>
                                <span class="input-group-btn" style="margin-left: 5px">
                                    <button type="button" class="btn btn-success advance_search">Advance Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="property-grid grid" style="padding: 0px">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="text-left">
                  <h2 style="font-size: 20px;
margin-left: 15px;
font-family: revert-layer;">Total {{count($events)}} events found , for keyword <b>{{'"'.$input['search'].'"'}}</b>.</h2>
              </div>
            </div>
          </div>
        </div>
    </section>

    @if(isset($events) && count($events)>0)

        <div class="container-xxl py-5 health-search-page section-gap">

        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                        @foreach($events as $event)
                            <div class="col-lg-12">
                        <div class="health-plan-grid">
                            <div class="inner">
                                <div class="company-logo" style="position: relative">
                                    <div class="compare-btn-wrap">
                                        <div class="compare-btn" id="compare-id-83" style="position: absolute;
top: -50px;
left: -16px;
background-color: #37517e;
padding: 5px 5px;
color: #fff;
font-size: 15px;">
                                            <i class="fa fa-plus"></i> Add to Compare
                                        </div>
                                    </div>

                                    <img width="100%"
                                         src="{{url('images/upload/'.$event['image'])}}"
                                         alt="Green Delta Insurance">
                                </div>



    <div class="plan-content">
    <ul>
        <div class="row">
            <div class="col-md-6">
                <li>
                    <span class="label">Event Name</span>
                    <h6 class="value">{{$event['event_name']?$event['event_name']:''}}</h6>
                </li>
            </div>

            <div class="col-md-6">
            <li>
                <span class="label">Event Time & Instruction</span>

                <div class="coverage-detail">
                    <h6 class="value">
                        {{$event['start_time']?date('l', strtotime($event['start_time'])).', '.date('M d, Y h:i a', strtotime($event['start_time'])).'  to':''}}
                        {{$event['end_time']?date('l', strtotime($event['end_time'])).', '.date('M d, Y h:i a', strtotime($event['end_time'])):''}}
                    </h6>
                    <span class="tooltip-title">
                        <i class="fa-solid fa-circle-info"></i> {{$event['instruction']?$event['instruction']:''}}
                    </span>
                </div>
            </li>
        </div>
        </div>
        <li>
            <span class="label">Event Organizer</span>
            <h6 class="value">{{$event['organizer_name']?$event['organizer_name']:''}}</h6>
        </li>
    </ul>
    </div>


                                <div class="plan-action">
                                    <div class="plan-premium">
                                        <h6 class="price">BDT. {{$event['price']?number_format($event['price'],2):''}}</h6>
                                    </div>
                                    <div class="group-btn">
                                        <a href="{{url('event/'.$event['id'].'/'.preg_replace('/\s+/', '-', $event['event_name']))}}" class="details-btn" id="more-details-83" href="#" title="More Details"
                                           >More Details</a>

                                        <a class="buy-btn" href="#" title="Buy Now">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif


    <section class="property-grid grid" style="padding: 0px">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-left">
                        <h2 style="font-size: 20px;
margin-left: 15px;
font-family: revert-layer;">Total {{count($services)}} services found , for keyword <b>{{'"'.$input['search'].'"'}}</b>.</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($services) && count($services)>0)

        <div class="container-xxl py-5 health-search-page section-gap">

            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                        @foreach($services as $service)
                            <div class="col-lg-12">
                                <div class="health-plan-grid">
                                    <div class="inner">
                                        <div class="company-logo" style="position: relative">
                                            <div class="compare-btn-wrap">
                                                <div class="compare-btn" id="compare-id-83" style="position: absolute;
top: -50px;
left: -16px;
background-color: #37517e;
padding: 5px 5px;
color: #fff;
font-size: 15px;">
                                                    <i class="fa fa-plus"></i> Add to Compare
                                                </div>
                                            </div>

                                            <img width="100%"
                                                 src="{{url('images/upload/'.$service['image'])}}"
                                                 alt="Green Delta Insurance">
                                        </div>



                                        <div class="plan-content">
                                            <ul>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <li>
                                                            <span class="label">Service Name</span>
                                                            <h6 class="value">{{$service['service_name']?$service['service_name']:''}}</h6>
                                                        </li>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <li>
                                                            <span class="label">Contact Person Information</span>

                                                            <div class="coverage-detail">
                                                                <h6 class="value">
                                                                    {{$service['contact_person_name']?$service['contact_person_name']:''}}
                                                                    {{$service['contact_person_mobile']?' ('.$service['contact_person_mobile'].' )':''}}
                                                                </h6>
                                                                <span class="tooltip-title">
                        <i class="fa-solid fa-circle-info"></i> {{$service['service_category_name']?$service['service_category_name']:''}}
                    </span>
                                                            </div>
                                                        </li>
                                                    </div>
                                                </div>
                                                <li>
                                                    <span class="label">Service Provider</span>
                                                    <h6 class="value">{{$service['company_name']?$service['company_name']:''}}</h6>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="plan-action">
                                            <div class="plan-premium">
{{--                                                <h6 class="price">BDT. {{$event['price']?number_format($event['price'],2):''}}</h6>--}}
                                                <h6 class="price">Type. {{$service['service_type'] && $service['service_type'] === 'product'?'Product':'Service'}} </h6>
                                            </div>
                                            <div class="group-btn">
                                                <button class=" details-btn service_details" data-id="{{$service['id']}}" data-href="{{route('service_details_model')}}" >More Details</button>

{{--                                                <a data-id="{{$service['id']}}" data-href="{{route('service_details_model')}}" class="details-btn service_details" title="More Details"--}}
{{--                                                >More Details</a>--}}

                                                <a class="buy-btn" href="#" title="Buy Now">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


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

@endsection


@push('EveryPageCustomJS')
    <script>


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
