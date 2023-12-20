

                            <div class="container">
                                <header>
                                    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                                        <h3 class="display-4 fw-normal" style="font-size: 25px;font-weight: bold;">{{$service->name}}</h3>
                                        <p class="fs-5 text-body-secondary">{{$service->details}}</p>
                                    </div>
                                </header>

                                <main>
{{--                                    <h2 class="display-6 text-center mb-4">Compare plans</h2>--}}

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table text-center">
                                                    {{--<thead>
                                                    <tr>
                                                        <th style="width: 34%;"></th>
                                                        <th style="width: 22%;">Free</th>
                                                    </tr>
                                                    </thead>--}}
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" class="text-start">Category </th>
                                                        <td>  {{$serviceCategory->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Service Type </th>
                                                        <td>  {{$service->service_type === 'service' ? 'Service' : 'Product'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Company Name </th>
                                                        <td>  {{$service->company_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Contact Person </th>
                                                        <td>  {{$service->contact_person_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Mobile </th>
                                                        <td>  {{$service->contact_person_mobile}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Email </th>
                                                        <td>  {{$service->contact_person_mobile}}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table text-center">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" class="text-start">WhatApps </th>
                                                        <td>  {{$service->contact_person_whatsapp}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Division </th>
                                                        @php
                                                            $division = \App\Models\Division::find($service->division);
                                                            $district = \App\Models\District::find($service->district);
                                                            $upazila = \App\Models\Upazila::find($service->upazila);
                                                        @endphp
                                                        <td>  {{$division ? $division->name : ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">District </th>
                                                        <td>  {{$district ? $district->name:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Upazila</th>
                                                        <td>  {{$upazila->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Comment </th>
                                                        <td>  {{$service->comment}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">Review </th>
                                                        <td>  {{$service->review}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="lightbox-gallery">
                                        <div class="container">
                                            <div class="intro" style="height: 100%">
                                                <h2 class="text-center">Service Gallery</h2>
{{--                                                <p class="text-center">Find the lightbox gallery for your project. click on any image to open gallary</p>--}}
                                            </div>
                                            <div class="row photos">
                                                <div class="col-sm-6 col-md-4 col-lg-3 item">
                                                    <p style="font-size: 12px;">Feature Image</p>
                                                    <a href="{{url('images/upload/'.$service->image)}}" data-lightbox="photos">
                                                        <img class="img-fluid" src="{{url('images/upload/'.$service->image)}}">
                                                    </a>
                                                </div>
                                                @if(count($service->ServiceImage)>0)
                                                    @foreach($service->ServiceImage as $img)
                                                <div class="col-sm-6 col-md-4 col-lg-3 item">
                                                    <p style="font-size: 12px;">{{$img->img_level}}</p>
                                                    <a href="{{url('images/upload/'.$img->image)}}" data-lightbox="photos">
                                                        <img class="img-fluid" src="{{url('images/upload/'.$img->image)}}">
                                                    </a>
                                                </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="intro" style="height: 100%">
                                        <h2 class="text-center">Service Items</h2>
                                    </div>

                                    @if(count($service->ServiceItem)>0)
                                        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                                        @foreach($service->ServiceItem as $item)
                                                <div class="col">
                                                    <div class="card mb-4 rounded-3 shadow-sm border-primary">
                                                        <div class="card-header py-3 text-bg-primary border-primary">
                                                            <h4 class="my-0 fw-normal">{{$item->item_name}}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <h1 class="card-title pricing-card-title"> {{number_format($item->item_price,2)}}<small class="text-body-secondary fw-light">/tk</small></h1>
                                                            <ul class="list-unstyled mt-3 mb-4">
                                                                <li>{{$item->item_description}}</li>
                                                                <li>{{$item->item_quantity}} quantities</li>
                                                                <li>EMS discount {{$item->ems_discount}}</li>
{{--                                                                <li>Help center access</li>--}}
                                                            </ul>
{{--                                                            <button type="button" class="w-100 btn btn-lg btn-primary">Contact us</button>--}}
                                                            <button class="w-100 btn btn-lg btn-primary add_cart_ajax" item-name="{{$item->item_name}}" item-description="{{$item->item_description}}" item-price="{{$item->item_price}}" item-quantity="{{$item->item_quantity}}" item-service="{{$item->service_id}}" service-category="{{$item->service_category_id}}" item-id="{{$item->id}}" data-href="{{route('add_item_to_cart')}}">Add to cart</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </main>
                            </div>
