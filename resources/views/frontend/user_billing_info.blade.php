@extends('frontend.auth.app')

@section('content')

    <div class="Card-sc-8zkhaa-0 styled__StyledCard-mxvrth-1 fogDtz">
        <form action="{{ route('update_user_billing') }}" method="post"  data-qa="form-login" name="login">
        @csrf
            <p data-qa="title" class="Text-st1i2q-0 styled__Title-sc-1subqgs-0 jTZzYs">Update Billing Information</p>
            <div class="NGrUbJBA _1Z8A3Tz5 _1FaKA6Nk _3cNt_ILG LoginForm__StyledGrid-sc-1jdwe0j-1 iPBaVu">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">{{__('Email')}}</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" required name="email" type="email" value="{{$user->email}}" readonly placeholder="{{ __('Your Email') }}">
                            </div>
                            @error('email')
                            <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{--<div class="row">
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
                </div>--}}

                {{--<div class="row">
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
                </div>--}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="_1RLMtIP3 _1w0U-CY6 Qso_pkui mb-4">
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Address 1</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" name="address1" type="textarea" value="{{$user->address1?$user->address1:null}}" placeholder="Enter address 1">
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
                            <div class="_2iCrTJcD"><label class="_2x_Fz5Ot" data-qa="label-name">Address 2</label></div>
                            <div class="_2fessCXR p2xx3nlH up-A7EAi">
                                <input autocomplete="off" class="RJT7RW5k" name="address2" type="textarea" value="{{$user->address2?$user->address2:''}}" placeholder="Enter address 1">
                            </div>
                            @error('address2')
                            <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif
                        </div>
                    </div>
                </div>

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
                                {!! Form::Select('division',$divisions,$user->division?$user->division:null,['placeholder'=>'Choose Division','id'=>'type', 'class'=>'_2fessCXR p2xx3nlH up-A7EAi division select2'.($errors->has('division') ? 'is-invalid':'')]) !!}
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
                                {!! Form::Select('district',$districts,$user->division?$user->division:null,['placeholder'=>'Choose District','id'=>'district', 'class'=>'_2fessCXR p2xx3nlH up-A7EAi district select2'.($errors->has('district') ? 'is-invalid':'')]) !!}
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
                                {!! Form::Select('upazila',$upazilas,$user->upazila?$user->upazila:null,['placeholder'=>'Choose Upazila','id'=>'upazila', 'class'=>'_2fessCXR p2xx3nlH up-A7EAi select2'.($errors->has('upazila') ? 'is-invalid':'')]) !!}
                            </div>
                            @error('upazila')
                            <div class="_2OcwfRx4" data-qa="email-status-message">{{$message}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="Flex-nqja63-0 styled__ButtonWrapper-sc-1vy69nr-0 lhtHXX">
                <button type="submit" data-qa="login-button" class="styled__ButtonWrapper-sc-56doij-3 hnulbU">
                    {{__('Change')}}
                </button>
            </div>

        </form>
    </div>



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
    </script>
@endpush
