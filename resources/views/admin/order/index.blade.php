@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('View Orders'),
    ])

    @php
        $totalAmount = 0;
    @endphp

    <div class="section-body">

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
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    <div class="row mb-4 mt-2">
                        <div class="col-lg-8"><h2 class="section-title mt-0"> {{__('Order List')}}</h2></div>
                        <div class="col-lg-4 text-right">
                        </div>
                    </div>
                  <div class="table-responsive">
                    <table class="table" id="report_table">
                        <thead>
                            <tr>
                                <th>{{__('Order Id')}}</th>
                                <th>{{__('Customer Name')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>{{__('Payment Gateway')}}</th>
                                <th width="15%">{{__('Order Status')}}</th>
                                <th width="15%">{{__('Payment Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                        {{dd($orders)}}--}}
                            @foreach ($orders as $item)
                                <tr>
                                    <td class="cell-{{$item->id}}"
                                        data-toggle="collapse"
                                        data-target="#demo{{$item->id}}"
                                        style="cursor: pointer;color: blue"
                                    >
                                        {{$item->order_id}}
                                    </td>
                                    <td>
                                        @php
                                            $customer = \Illuminate\Support\Facades\DB::table('order_billing')->where('order_id',$item->id)->first();
                                        @endphp

                                        {{$customer->name.' '.$customer->last_name}}
                                    </td>

                                    <td>
                                        <p class="mb-0">{{$item->created_at->format('Y-m-d')}}</p>
                                        <p class="mb-0">{{$item->created_at->format('h:i a')}}</p>
                                    </td>
                                    <td>{{$item->order_quantity}}</td>
                                    <td class="text-right">{{number_format($item->total_price,2)}}</td>
                                    <td>{{$item->payment_type === 'cod' ? 'Cash on delivery':'Online Payment'}}</td>
                                    <td width="15%">
                                        {!! Form::Select('status',$orderStatus,$item->status,['placeholder'=>'Choose status','id'=>'status-'.$item->id ,"onchange"=>"changeOrderStatus($item->id)", 'class'=>'form-control select2 division'.($errors->has('status') ? 'is-invalid':'')]) !!}
                                    </td>
                                    <td  width="15%" >
                                        <select name="payment_status" id="payment-{{ $item->id }}" class="form-control p-2" onchange="changePaymentStatus({{$item->id}})" {{ $item->is_payment == 1? 'disabled':'' }}>
                                            <option value="0" {{ $item->is_payment == 0? 'selected':''}}> {{ __('Pending') }} </option>
                                            <option value="1" {{ $item->is_payment == 1? 'selected':''}}> {{ __('Complete') }} </option>
                                        </select>
                                    </td>
                                    <td>
{{--                                        <a href="{{url('order-invoice/'.$item->id)}}" class="btn-icon text-primary"><i class="far fa-eye"></i></a>--}}
                                        <a href="" class="btn-icon text-primary"><i class="far fa-eye"></i></a>
                                    </td>
                                </tr>

                                @if(count($item->orderItem)>0)
                                    <tr style="background:rgb(206, 205, 205);text-align: center"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                        <th colspan="9" style="padding: 0px">Item Details</th>
                                    </tr>
                                    <tr style="background: rgb(227, 227, 227);"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}">
                                        <th colspan="2"> Name</th>
                                        <th colspan="2">Description</th>
                                        <th class="text-center"> Price</th>
                                        <th class="text-center">Bundle Qty.</th>
                                        <th class="text-center">Order Qty.</th>
                                        <th colspan="2">Category</th>
                                    </tr>
                                    @foreach($item->orderItem as $myItem)
                                        <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} " style="background: #eeebeb;">
                                            <td colspan="2">{{$myItem->item_name}}</td>
                                            <td colspan="2">{{$myItem->item_description}}</td>
                                            <td class="text-right">{{number_format($myItem->item_price,2)}}</td>
                                            <td class="text-center">{{$myItem->bundle_quantity}}</td>
                                            <td class="text-center">{{$myItem->order_quantity}}</td>
                                            <th colspan="2">{{isset($myItem->serviceCategory)?$myItem->serviceCategory->name:null}}</th>
                                        </tr>
                                        @php
                                            $totalAmount = $totalAmount + $myItem->item_price;
                                        @endphp
                                    @endforeach
                                    <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} " style="background: #eeebeb;">
                                        <td colspan="4" class="text-center" style="font-weight: bolder">Total Price</td>
                                        <td style="font-weight: bolder" class="text-right">{{number_format($totalAmount,2)}}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                @endif


                                @if(isset($item->orderBilling))
                                    <tr style="background:rgb(206, 205, 205);text-align: center;cursor: pointer;"  id="demo{{$item->id}}" class="collapse cell-{{$item->id}}" onclick="showShipping({{$item->id}})">
                                        <th colspan="10" style="padding: 0px">Shipping Details</th>
                                    </tr>

                                        <tr id="demo{{$item->id}}" class="collapse cell-{{$item->id}} demo{{$item->id}} " style="background: #eeebeb;display: none">
                                            <td></td>
                                            <td colspan="4">
                                                Name : {{$item->orderBilling->name.' '.$item->orderBilling->last_name}} <br>
                                                Address : {{$item->orderBilling->address1}}
                                            </td>
                                            <td colspan="5">
                                                Email : {{$item->orderBilling->email}}<br>
                                                Mobile : {{$item->orderBilling->mobile}} <br>
{{--                                                {{$item->orderBilling->shippingUpazila->name.' ( '.$item->orderBilling->shippingUpazila->bn_name.' ) ,'}}--}}
{{--                                                {{$item->orderBilling->shippingDistrict->name.' ( '.$item->orderBilling->shippingDistrict->bn_name.' ) ,'}}--}}
{{--                                                {{$item->orderBilling->shippingDivision->name.' ( '.$item->orderBilling->shippingDivision->bn_name.' )'}}--}}

                                            </td>
                                        </tr>
                                @endif
                                @php
                                    $totalAmount = 0;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection

@push('EveryPageCustomJS')
    <script>
        function showShipping(id) {
            $('.demo'+id).show(1500)
        }
    </script>
@endpush


