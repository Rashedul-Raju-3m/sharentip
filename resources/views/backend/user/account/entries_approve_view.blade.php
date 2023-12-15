@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <span class="panel-title">{{ _lang('Entries Approve') }}</span>
                    <button class="btn btn-outline-primary btn-xs print" data-print="report" type="button" id="report-print-btn"><i class="fas fa-print mr-1"></i>{{ _lang('Print Report') }}</button>
                </div>

                <div class="card-body pt-1" id="report">

                    @php $date_format = get_date_format(); @endphp

                    <div class="report-header">
                        <h4>{{ $entryType?$entryType->name:'' }}</h4>
                        <h5>{{ _lang('Entries Approve') }}</h5>
{{--                        <p>{{ _lang('Date').': '. date($date_format) }}</p>--}}
                        <p>{{ _lang('Date').': '. date('d-m-Y')  }}</p>

                    </div>

                    <div class="report-header" style="text-align: left !important;">
                        <h5>Number : {{ $entries->number }}</h5>
                        <h5>Date : {{ date('d-m-Y',strtotime($entries->date)) }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <th>{{ _lang('Dr / Cr') }}</th>
                            <th>{{ _lang('Ledger') }}</th>
                            <th>{{ _lang('Dr Amount (TK)') }}</th>
                            <th>{{ _lang('Cr Amount (TK)') }}</th>
                            <th>{{ _lang('Narration') }}</th>
                            </thead>
                            <tbody>
                            @if(isset($entriesItems))
                                @php
                                    $totalCredit = 0.00;
                                    $totalDebit = 0.00;
                                @endphp
                                @foreach($entriesItems as $item)
                                    <tr>
                                        <td>{{ $item->dc && $item->dc == 'D'?'Dr':'Cr' }}</td>
                                        <td>
                                            @php
                                                $ledger = \App\Models\Ledger::find($item->ledger_id);
                                                $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
                                                $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
                                            @endphp
                                            {{ '['.$ledger->code.'] '.$ledger->name }}
                                        </td>
                                        <td class="balance text-right">{{ $item->dc && $item->dc == 'D'?$item->amount:'' }}</td>
                                        <td class="balance text-right">{{ $item->dc && $item->dc == 'C'?$item->amount:'' }}</td>
                                        <td>{{ $item->narration }}</td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <th colspan="2" style="color: #000;text-align: center">Total</th>
                                        <th style="color: #000;text-align: right;">{{number_format($totalDebit,2)}}</th>
                                        <th style="color: #000;text-align: right;">{{number_format($totalCredit,2)}}</th>
                                        <th></th>
                                    </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="report-header" style="text-align: left !important;">
                        <p>Tags : {{$entries->tag_id}}</p>
                        <p>Notes : {{$entries->notes}}</p>
                    </div>

                    {{--<div class="card-footer d-sm-flex align-items-center justify-content-between">
                        <a class="btn btn-outline-primary btn-xs" href="{{route('entries_approve',$entries->id)}}"><i class="fas fa-print mr-1"></i>{{ _lang('Approve') }}</a>
                        <a class="btn btn-outline-primary btn-xs" href="{{route('entries_edit',$entries->id)}}"><i class="fas fa-print mr-1"></i>{{ _lang('Edit') }}</a>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection
