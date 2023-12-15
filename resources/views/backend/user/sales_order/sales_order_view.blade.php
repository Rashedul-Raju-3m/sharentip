@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <span class="panel-title">{{$salesOrder['type']=='invoice'?'Invoice':'Sales Orser'}}{{ _lang(' View') }}</span>
                    <div>
                        <a href="{{route('sales_order_edit',$salesOrder['id'])}}" class="btn btn-outline-success btn-xs">
                            <i class="fas fa-edit mr-1"></i>{{ _lang('Edit') }}
                        </a>
                        <button class="btn btn-outline-primary btn-xs print" data-print="report" type="button" id="report-print-btn">
                            <i class="fas fa-print mr-1"></i>{{ _lang('Print Report') }}
                        </button>
                    </div>
                </div>

                <div class="card-body pt-1">

                    @php $date_format = get_date_format(); @endphp

                    <div class="report-header text-left">
                        <h5>{{$salesOrder['type']=='invoice'?'Invoice':'Sales Orser'}}</h5>
                        <p>{{ _lang('Date').': '. date('d-m-Y',strtotime($salesOrder['invoice_date']))  }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-8" id="report">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="report-header" style="text-align: left !important;">
                                        <h5><b>Customer : {{$salesOrder['name']}}</b></h5>
                                        <p>
                                            <b>Address:</b> {{$salesOrder['address']}} <br>
                                            {{$salesOrder['city'].' '.$salesOrder['zip']}}<br>
                                            {{$salesOrder['country']}}<br>
                                            {{$salesOrder['email']}}<br>
                                            {{$salesOrder['mobile']}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="report-header" style="text-align: left !important;">
                                        <h5><b>Dealer Branch </b></h5>
                                        <p>
                                             {{$salesOrder['br_name']}} <br>
                                            <b>Address:</b> {{$salesOrder['shipping_street']}}<br>
                                            {{$salesOrder['shipping_city']}}, {{$salesOrder['shipping_state']}}<br>
                                            {{$salesOrder['shipping_country_id']}} , {{$salesOrder['shipping_zip_code']}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="report-header" style="text-align: left !important;">
                                        <h5><b>Shipment to</b></h5>
                                        <p>
                                            {{$salesOrder['location_name'].' ('.$salesOrder['location_name'].')'}} <br>
{{--                                            {{$salesOrder['delivery_address']}}<br>--}}
                                            <b>Payment Method : </b>{{$salesOrder['payment_method_name']}}<br>
                                            <b>Sales Type : </b>{{$salesOrder['sales_type']}}<br>
                                            <b>Reference : </b>{{$salesOrder['customer_reference']}}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <th>{{ _lang('SL') }}</th>
                                    <th>{{ _lang('Item Name') }}</th>
                                    <th>{{ _lang('Quantity') }}</th>
                                    <th>{{ _lang('Unit Cost') }}</th>
                                    <th>{{ _lang('Sub Total') }}</th>
                                    <th>{{ _lang('Vat') }}</th>
                                    <th>{{ _lang('Discount') }}</th>
                                    <th>{{ _lang('Total') }}</th>
                                    </thead>
                                    <tbody>
                                    @if(isset($salesOrder['items']))
                                        @php
                                            $i = 0;
                                            $totalQuantity = 0;
                                            $subTotal = 0;
                                            $totalVat = 0;
                                            $totalDiscount = 0;
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach($salesOrder['items'] as $item)
                                            @php
                                                $totalQuantity = $totalQuantity+$item['quantity'];
                                                $subTotal = $subTotal+$item['sub_total'];
                                                $totalVat = $totalVat+$item['vat_amount'];
                                                $totalDiscount = $totalDiscount+$item['discount_amount'];
                                                $totalAmount = $totalAmount+$item['total'];
                                            @endphp
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>{{ $item['name'].' ('.$item['sku'].')' }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>{{ $item['unit_cost'] }}</td>
                                                <td>{{ $item['sub_total'] }}</td>
                                                <td>{{ $item['vat_amount'] }}</td>
                                                <td>{{ $item['discount_amount'] }}</td>
                                                <td>{{ $item['total'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-right" colspan="7" style="color: #000;text-align: center">Total Quantity</th>
                                            <th class="text-right" style="color: #000;text-align: center">{{$totalQuantity}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="7" style="color: #000;text-align: center">Sub Total</th>
                                            <th class="text-right" style="color: #000;text-align: center">{{number_format($subTotal,2)}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="7" style="color: #000;text-align: center">Vat</th>
                                            <th class="text-right" style="color: #000;text-align: center">{{number_format($totalVat,2)}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="7" style="color: #000;text-align: center">Discount</th>
                                            <th class="text-right" style="color: #000;text-align: center">{{number_format($totalDiscount,2)}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="7" style="color: #000;text-align: center">Grand Total</th>
                                            <th class="text-right" style="color: #000;text-align: center">{{number_format($totalAmount,2)}}</th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <p><b>Note : </b>{{$salesOrder['note']}}</p>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header d-sm-flex align-items-center justify-content-between">
                                    <h5 class="text-left text-info"><b>Sales Order No # {{$salesOrder['invoice_number']}}</b></h5>
                                </div>
                            </div>

                            @php
                                $invoices = \App\Models\Invoice::where('parent_id',$salesOrder['id'])->where('type','invoice')->get();
                            @endphp

                            <div class="card">
                                <div class="card-header  align-items-center justify-content-between">
                                    <h5 class="text-center text-info"><b>Invoice</b></h5>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        @if(count($invoices)>0)
                                        <tbody>
                                        @foreach($invoices as $inv)
                                            <tr>
                                                <td>
                                                    <a href="{{route('sales_order_view',$inv->id)}}"><b>{{$inv->invoice_number}}</b></a>
                                                </td>
                                                <td class="text-right">{{number_format($inv->grand_total,2)}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                            @endif
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header  align-items-center justify-content-between">
                                    <div class="row">
                                        <button class="btn btn-success text-center " style="color: #fff;font-size: 12px;width: 40%;padding: 5px 5px !important;border-radius: 0 !important;">Create Manually</button>
                                        <button class="btn btn-danger text-center float-right" style="color: #fff;font-size: 12px;padding: 5px 5px !important;border-radius: 0 !important;margin-left: 25px !important;">Create Automatically</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header  align-items-center justify-content-between">
                                    <h5 class="text-center text-info"><b>Payment</b></h5>
                                    <br>
                                    <p  class="text-center text-info">This is payment tab</p>
                                    <div class="text-center">
                                        <button class="btn btn-primary text-center" style="color: #fff;font-size: 12px;width: 40%;padding: 5px 5px !important;border-radius: 0 !important;">Payment</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js-script')
    <script type="text/javascript">

        /*$(document).delegate('#report-print-btn','click',function () {
            $('.report_print').show()
        })*/

    </script>
@endsection
