@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Add Event'),
        'headerData' => __('Event') ,
        'url' => 'events' ,
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8"><h2 class="section-title"> {{__('Add Event')}}</h2></div>
        </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    <form method="post" class="event-form" action="{{url('events')}}" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group center">
                                    <label>{{__('Image')}}</label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label"> <i class="fas fa-plus"></i></label>
                                        <input type="file" name="image" id="image-upload" />
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback block">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{__('Name')}}</label>
                                    <input type="text" name="name" value="{{old('name')}}" placeholder="{{__('Name')}}" class="form-control @error('name')? is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>{{__('Category')}}</label>
                                    <select name="category_id" class="form-control select2">
                                        <option value="">{{ __('Select Category') }}</option>
                                        @foreach ($category as $item)
                                        <option value="{{$item->id}}" {{$item->id == old('category_id') ? 'Selected' : ''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback block">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" name="price" id="price" value="{{old('price')}}" placeholder="Price" class="form-control @error('price')? is-invalid @enderror">
                                    @error('price')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Instruction</label>
                                    <input type="text" name="instruction" id="instruction" value="{{old('instruction')}}" placeholder="Instruction" class="form-control @error('instruction')? is-invalid @enderror">
                                    @error('instruction')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{__('Start Time')}}</label>
                                    <input type="text" name="start_time" id="start_time" value="{{old('start_time')}}" placeholder="{{ __('Choose Start time') }}" class="form-control date @error('start_time')? is-invalid @enderror">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{__('End Time')}}</label>
                                    <input type="text" name="end_time" id="end_time" value="{{old('end_time')}}" placeholder="{{ __('Choose End time') }}" class="form-control date @error('end_time')? is-invalid @enderror">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->hasRole('admin'))
                        <div class="form-group">
                            <label>{{__('Organization')}}</label>
                            <select name="user_id" required class="form-control select2" id="org-for-event">
                                <option  value="">{{__('Choose Organization')}}</option>
                                @foreach ($users as $item)
                                <option value="{{$item->id}}" {{$item->id==old('user_id')?'Selected':''}}>{{$item->first_name.' '.$item->last_name}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Contact Person</label>
                            <select name="scanner_id" required class="form-control scanner_id select2">
                                <option  value="">Choose Contact Person</option>
                                @foreach ($scanner as $item)
                                <option value="{{$item->id}}" {{$item->id==old('scanner_id')?'Selected':''}}>{{$item->first_name.' '.$item->last_name}}</option>
                                @endforeach
                            </select>
                            @error('scanner_id')
                                <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{__('Maximum people will join in this event')}}</label>
                                    <input type="number" name="people" id="people" value="{{old('people')}}" placeholder="{{ __('Maximum people will join in this event') }}" class="form-control @error('people')? is-invalid @enderror">
                                    @error('people')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{__('status')}}</label>
                                    <select name="status" class="form-control select2">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{__('Tags')}}</label>
                            <input type="text" name="tags" value="{{old('tags')}}" class="form-control inputtags @error('tags')? is-invalid @enderror">
                            @error('tags')
                                <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{__('Description')}}</label>
                            <textarea name="description" Placeholder ="Description" class="textarea_editor @error('description')? is-invalid @enderror">
                                {{old('description')}}
                            </textarea>
                            @error('description')
                                <div class="invalid-feedback block">{{$message}}</div>
                            @endif
                        </div>
                        <h6 class="text-muted mt-4 mb-4">{{__('Location Detail')}}</h6>
                        <div class="form-group">
                            <div class="selectgroup">
                              <label class="selectgroup-item">
                                <input type="radio" name="type" {{old('type')=="online"? '' : 'checked'}} checked value="offline" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">{{__('Venue')}}</span>
                              </label>
                              <label class="selectgroup-item">
                                <input type="radio" {{old('type')=="online"? 'checked' : ''}} name="type" value="online" class="selectgroup-input">
                                <span class="selectgroup-button">{{__('Online Event')}}</span>
                              </label>
                            </div>
                          </div>
                        <div class="location-detail {{old('type')=="online"? 'hide' : ''}}">
                            <div class="form-group">
                                <label>{{__('Event Address')}}</label>
                                <input type="text" name="address" id="address" value="{{old('address')}}" placeholder="{{ __('Event Address') }}" class="form-control @error('address')? is-invalid @enderror">
                                @error('address')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Latitude')}}</label>
                                        <input type="text" name="lat" id="lat" value="{{old('lat')}}" placeholder="{{ __('Latitude') }}" class="form-control @error('lat')? is-invalid @enderror">
                                        @error('lat')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Longitude')}}</label>
                                        <input type="text" name="lang" id="lang" value="{{old('lang')}}" placeholder="{{ __('Longitude') }}" class="form-control @error('lang')? is-invalid @enderror">
                                        @error('lang')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="custom-switches-stacked mt-2">
                                <label class="custom-switch pl-0">
                                  <input type="radio" name="security" {{old('security')=="0"? '' : 'checked'}} checked value="1" class="custom-switch-input">
                                  <span class="custom-switch-indicator"></span>
                                  <span class="custom-switch-description">{{__('Public')}}</span>
                                </label>
                                <label class="custom-switch pl-0">
                                  <input type="radio" name="security"  {{old('security')=="0"? 'checked' : ''}} value="0" class="custom-switch-input">
                                  <span class="custom-switch-indicator"></span>
                                  <span class="custom-switch-description">{{__('Private')}}</span>
                                </label>
                              </div>
                        </div>

                        <div class="form-group">
                            <label>{{$setting->event_text?$setting->event_text:'This is my text'}}</label>
                            <select name="event_service_type" class="form-control select2 showService">
                                <option value="system_provide_service">System provided service</option>
                                <option value="self_service">Self service</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{$message}}</div>
                            @endif
                        </div>

                        <div class="row system_provide_service_content">
                            <div class="col-sm-12">
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="title-box-d">
{{--                                            <h3 class="title-d cat_name">{{$serviceCategory->name}}</h3>--}}
{{--                                            <p>{{$serviceCategory->created_at->diffForHumans()}} , Post Date :: {{date_format($serviceCategory->created_at,'d-M-Y')}}</p>--}}
                                            <div class="tab">
                                                @if(count($serviceCategory)>0)
                                                    @foreach($serviceCategory as $serviceCategorie)
                                                        <button type="button" class="tablinks" id="click_{{$serviceCategorie->id}}"
                                                                onclick="openCity(event, {{$serviceCategorie->id}})">
                                                            {{$serviceCategorie->name}}
                                                        </button>
                                                    @endforeach
                                                @endif
                                            </div>

                                            @if(count($serviceCategory)>0)
                                                @foreach($serviceCategory as $serviceCategorie)
                                                    @php

                                                        $services = \App\Models\Service::where([['service_category_id',$serviceCategorie->id],['is_active',1],['is_delete',0]])->get();
$serviceCategoryDetails = \App\Models\ServiceCategory::find($serviceCategorie->id);

                                                    @endphp
                                                    <div id="{{$serviceCategorie->id}}" class="tabcontent table-responsive"  style="display: none">
                                                        @if(count($services)>0)

                                                            <div class="d-flex justify-content-center row">
                                                                <div class="col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;">
                                                                    <div class="rounded">
                                                                        <div class="table-responsive table-borderless">
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th class="text-center"
                                                                                    @if($serviceCategoryDetails->category_type === 1)
                                                                                        colspan="2"
                                                                                    @endif
                                                                                    >Service Name</th>
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
                                                                                        <td
                                                                                            @if($serviceCategoryDetails->category_type === 1)
                                                                                            colspan="2"
                                                                                            @endif
                                                                                        >{{$service->name}}</td>
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
                                                                                            @if($serviceCategoryDetails->category_type === 1)
                                                                                                <th>Available ticket</th>
                                                                                            @endif
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
                                                                                                @if($serviceCategoryDetails->category_type === 1)
                                                                                                    <th>
                                                                                                        <input type="text" class="available_tricket" id="{{$item->id}}">
                                                                                                    </th>
                                                                                                @endif
                                                                                                <td>
                                                                                                    <button class="btn btn-success add_cart_ajax" count="0" item-name="{{$item->item_name}}" item-description="{{$item->item_description}}" unit-price="{{$item->item_price}}" item-quantity="{{$item->item_quantity}}" item-service="{{$item->service_id}}" service-category="{{$item->service_category_id}}" item-id="{{$item->id}}" order-quantity="1" image="{{$service->image}}" company_name="{{$service->company_name}}" id="ticket-{{$item->id}}" ticket="" data-href="{{route('add_item_to_cart')}}">Add to cart</button>
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


                        <div class="form-group" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </form>
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

        // $(document).on('click', '.custom-switch-input', function(e){
        $(document).on('change', '.showService', function(e){
            e.preventDefault();
            if ($(this).val() === 'system_provide_service'){
                $('.system_provide_service_content').show();
            }else{
                $('.system_provide_service_content').hide();
            }
        });

        $(document).on('keyup', '.available_tricket', function(e){
            e.preventDefault();
            let value = $(this).val();
            let id = $(this).attr("id");
            $("#ticket-"+id).attr('ticket',value)
        });

        $(document).on('click', '.service-category', function(e){
            e.preventDefault();
            let serviceCategoryID = $(this).attr('service-category-id');
            let serviceCategoryRoute = $(this).attr('data-href');
            $('#service_category_id').attr('value',serviceCategoryID);
            $('.service-category').attr('class','btn btn-primary form-control service-category');
            $('#service-category-'+serviceCategoryID).attr('class','btn btn-primary form-control service-category active-service-category');
            $.ajax({
                url: serviceCategoryRoute,
                method: "GET",
                dataType: "json",
                data: {serviceCategoryID: serviceCategoryID},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                jQuery('.service_content').html(response.content);
                jQuery('.service_content').prop('disabled', false);
            }).fail(function( jqXHR, textStatus ) {

            });
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
            let ticket = jQuery(this).attr('ticket');

            let url = jQuery(this).attr('data-href');
            jQuery(this).removeClass('btn-success');
            jQuery(this).addClass('btn-warning');
            let count = jQuery(this).attr('count');
            count = parseInt(count)+1;
            jQuery(this).attr('count',count)
            jQuery(this).text('Added ('+count+')');


            jQuery.ajax({
                url: url,
                method: "get",
                data: {itemName:itemName,itemDescription:itemDescription,unitPrice:unitPrice,itemQuantity: itemQuantity,serviceCategory:serviceCategory,itemID:itemID,serviceId:serviceId,company_name:company_name,image:image,order_quantity:order_quantity,ticket:ticket},
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
                    /*didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }*/
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
                // jQuery('.modal-title').text(response.category_name);
                // jQuery('.modal-body').html(response.content);
                $('.modal').modal('show');
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        });
    </script>
@endpush

@endsection
