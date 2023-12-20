@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => 'Update Service',
        'headerData' => 'Service' ,
        'url' => 'Service' ,
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8"><h2 class="section-title"> Update Service</h2></div>
        </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('service_update',[$service->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group center">
                                    <label>{{__('Image')}} <span style="color: red"> *</span></label>
                                    <div id="image-preview" class="image-preview" style="background-image: url({{url('images/upload/'.$service->image)}})">
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
                                    <label> Service Category <span style="color: red"> *</span> </label>
                                    <select name="service_category_id" class="form-control select2">
                                        @foreach($serviceCategory as $item)
                                            <option value="{{$item->id}}"
                                                @php
                                                    if ($service->service_category_id == $item->id){
                                                        echo "Selected";
                                                    }
                                                @endphp>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('service_category_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label> Service Name<span style="color: red"> *</span></label>
                                    <input type="text" name="name" placeholder="Service name" value="{{$service->name?$service->name:''}}" class="form-control @error('name')? is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Company Name<span style="color: red"> *</span></label>
                                    <input type="text" name="company_name" placeholder="Company name" value="{{$service->company_name?$service->company_name:''}}" class="form-control @error('company_name')? is-invalid @enderror">
                                    @error('company_name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Contact Person Name<span style="color: red"> *</span></label>
                                    <input type="text" name="contact_person_name" placeholder="Contact person name" value="{{$service->contact_person_name?$service->contact_person_name:''}}" class="form-control @error('contact_person_name')? is-invalid @enderror">
                                    @error('contact_person_name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Contact Person Mobile<span style="color: red"> *</span></label>
                                    <input type="text" name="contact_person_mobile" placeholder="Contact person mobile" value="{{$service->contact_person_mobile?$service->contact_person_mobile:''}}" class="form-control @error('contact_person_mobile')? is-invalid @enderror">
                                    @error('contact_person_mobile')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Contact Person Email</label>
                                    <input type="text" name="contact_person_email" placeholder="Contact person email" value="{{$service->contact_person_email?$service->contact_person_email:''}}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Contact Person Whatsapp </label>
                                    <input type="text" name="contact_person_whatsapp" placeholder="Contact person whatsapp" value="{{$service->contact_person_whatsapp?$service->contact_person_whatsapp:''}}" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Division<span style="color: red"> *</span></label>
                                    {!! Form::Select('division',$divisions,$service->division,['placeholder'=>'Choose Division','id'=>'type', 'class'=>'form-control select2 division'.($errors->has('division') ? 'is-invalid':'')]) !!}
                                    @error('division')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> District <span style="color: red"> *</span></label>
                                    <a data-href="{{route('get_division_wise_district')}}" style="display: none" id="getDistrictRoute"></a>
                                    {!! Form::Select('district',$districts,$service->district,['placeholder'=>'Choose District','id'=>'district', 'class'=>'form-control select2 district'.($errors->has('district') ? 'is-invalid':'')]) !!}
                                    @error('district')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label> Upazila <span style="color: red"> *</span></label>
                                    <a data-href="{{route('get_district_wise_upazila')}}" style="display: none" id="getUpazilaRoute"></a>
                                    {!! Form::Select('upazila',$upazilas,$service->upazila,['placeholder'=>'Choose Upazila','id'=>'upazila', 'class'=>'form-control select2 '.($errors->has('upazila') ? 'is-invalid':'')]) !!}
                                    @error('upazila')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-switches-stacked mt-2">
                                <label class="custom-switch pl-0">
                                    <input type="radio" name="service_type" {{$service->service_type=="service"? 'checked' : ''}} value="service" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Service</span>
                                </label>
                                <label class="custom-switch pl-0">
                                    <input type="radio" name="service_type"  {{$service->service_type=="product"? 'checked' : ''}} value="product" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Product</span>
                                </label>
                            </div>
                        </div>

                        <table class="table table-responsive table-bordered tab" id="row-add">
                            <tr>
                                <th> Name</th>
                                <th> Description</th>
                                <th> Quantity</th>
                                <th> Price</th>
                                <th> EMS Discount</th>
                                <th>
                                    <button id="add_more_item" class="btn-success" data-href="{{route('add_more_item')}}" sl-no="999"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </th>
                            </tr>
                            @if(count($items)>0)
                                @php $index = 1 @endphp
                                @foreach($items as $item)
                                    <tr id="sl-{{$index}}" >
                                <td>
                                    <input type="text" name="item_name[]" placeholder="Item name" value="{{$item->item_name}}" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="item_description[]" placeholder="Item description" value="{{$item->item_description}}" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="item_quantity[]" placeholder="Item quantity" value="{{$item->item_quantity}}" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="item_price[]" placeholder="Item price" value="{{$item->item_price}}" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="ems_discount[]" placeholder="EMS Discount" value="{{$item->ems_discount}}" class="form-control">
                                </td>
                                        <td>
                                            <button class="btn_remove btn-danger" remove-id="{{$index}}"  ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                            </tr>
                                    @php $index++ @endphp
                                @endforeach
                            @endif
                        </table>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Comments</label>
                                    <input type="text" name="comment" placeholder="Comment" value="{{$service->comment}}" class="form-control @error('comment')? is-invalid @enderror">
                                    @error('comment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Details</label>
                                    <input type="textarea" name="details" placeholder="Service details" value="{{$service->details}}" class="form-control @error('details')? is-invalid @enderror">
                                    @error('details')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group table-responsive">

                                    {{--<table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="40%">File Attachments</th>
                                            <th style="text-align: right;" width="40%">

                                            </th>
                                            <th width="10%">
                                                <button sl-no="1" id="MoreAttachment" style="cursor: pointer" class="btn btn-primary" ><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                <a style="display: none" id="moreattachroute" data-href="{{route('add_multiple_service_image')}}" ></a>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="add_more_attach_row">
                                        <tr sl-no="1" id="delete_row_1">
                                            <td width="40%">
                                                {!! Form::text('img_level[]',null,['id'=>'img_level','placeholder'=>'Image Level','class'=>'form-control']) !!}
                                            </td>
                                            <td width="40%">
                                                <div style="position:relative;border: 1px solid #e6e0e0;">
                                                    <a class='btn btn-primary btn-sm font-10' href='javascript:;'>
                                                        Choose File...
                                                        <input name="attach_link[]" type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info1").html($(this).val());'>
                                                    </a>
                                                    &nbsp;
                                                    <span style="color: red">{!! $errors->first('attach_link[]') !!}</span>
                                                    <span class='label label-info' id="upload-file-info1"></span>
                                                </div>
                                            </td>
                                            <td width="10%" style="color: red">
                                                <i class="fa fa-trash btn btn-danger" id="moreImageDelete" sl-no={{1}} aria-hidden="true" style="text-align: right;cursor: pointer;"></i>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>--}}
                                    <div class="row" style="overflow-x: hidden;">
                                        @foreach($service->ServiceImage as $value)
                                            <div class="col-md-3" id="hide_{{$value->id}}">
                                                <div class="from-group">
                                                    <div class="mb-3">

                                                        <div style="text-align: center;padding-top: 5px;" >
                                                            <h6 style="background: #024493;padding: 5px;color: #fff;">{{$value->img_level}}</h6>
                                                            @if(isset($value) && $value->image !='')
                                                                <img id="feature_image" src="{{ asset('images/upload').'/'.$value->image}}" width="150" height="120"/>
                                                            @endif
                                                            <br><p data-href="{{route('service_image_delete')}}" class="btn btn-danger" sl-no="{{$value->id}}" id="deleteMoreAttachment" style="cursor: pointer;color: #fff;"><i class="fas fa-trash"></i></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            {{--<div class="col-lg-6">
                                <div class="form-group">
                                    <label>Unit Costs</label>
                                    <input type="text" name="unit_cost" placeholder="Service unit cost" value="{{$service->unit_cost}}" class="form-control @error('unit_cost')? is-invalid @enderror">
                                    @error('unit_cost')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>--}}

                            <div class="col-lg-6">
                                <div class="form-group">
                                    @php
                                        $review = [];
                                        $review[1] = 1;
                                        $review[2] = 2;
                                        $review[3] = 3;
                                        $review[4] = 4;
                                        $review[5] = 5;
                                    @endphp
                                    <label> Review</label>
                                    {!! Form::Select('review',$review,$service->review?$service->review:null,['placeholder'=>'Choose Review', 'class'=>'form-control select2 '.($errors->has('review') ? 'is-invalid':'')]) !!}
                                    @error('review')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{__('status')}}</label>
                                    <select name="is_active" class="form-control select2">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                    @error('is_active')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection

@push('EveryPageCustomJS')
    <script>
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

        $(document).delegate('#add_more_item','click',function (e) {
            e.preventDefault();
            let route = $(this).attr('data-href');
            let slNo = $(this).attr('sl-no');

            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {slNo: slNo},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                $('#row-add').append(response.content);
                $('#add_more_item').attr("sl-no", response.sl);
            }).fail(function( jqXHR, textStatus ) {

            });
        });

        $(document).on('click', '.btn_remove', function(e){
            e.preventDefault();
            let result = confirm("Are you sure you want to delete this item?");
            if (result) {
                let button_id = $(this).attr("remove-id");
                $('#sl-'+button_id+'').remove();
            }
        });

        $(document).delegate('#MoreAttachment','click',function () {
            let slNo = $(this).attr('sl-no');
            slNo = parseInt(slNo);
            let route = $('#moreattachroute').attr('data-href');

            slNo += 1;
            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {slNo: slNo},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                $('#add_more_attach_row').append(response.content);
                document.getElementById("MoreAttachment").setAttribute("sl-no",response.slNo);
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        });

        $(document).on('click', '#moreImageDelete', function(e){
            e.preventDefault();
            let result = confirm("Are you sure you want to delete this image?");
            if (result) {
                let button_id = $(this).attr("sl-no");
                $('#delete_row_'+button_id).remove();
            }
        });

        /*
        $(document).delegate('#deleteMoreAttachment','click',function () {
            var slNo = $(this).attr('sl-no');
            var route = $(this).attr('data-href');

            let result = confirm("Are you sure you want to delete this image?");
            if (result) {
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {slNo: slNo},
                    beforeSend: function( xhr ) {

                    }
                }).done(function( response ) {
                    $('#hide_'+slNo).remove();
                }).fail(function( jqXHR, textStatus ) {

                });
                return false;
            }
        });*/
    </script>
@endpush
