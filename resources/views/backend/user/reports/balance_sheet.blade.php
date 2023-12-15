@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-10 offset-lg-1">
		<div class="card">
			<div class="card-header d-sm-flex align-items-center justify-content-between">
				<span class="panel-title">{{ _lang('Account Balances Sheet') }}</span>
				<button class="btn btn-outline-primary btn-xs print" data-print="report" type="button" id="report-print-btn"><i class="fas fa-print mr-1"></i>{{ _lang('Print Report') }}</button>
			</div>

			<div class="card-body pt-1" id="report">

				@php $date_format = get_date_format(); @endphp

				<div class="report-header">
				   <h4>{{ request()->activeBusiness->name }}</h4>
				   <h5>{{ _lang('Account Balances') }}</h5>
				   <p>{{ _lang('Date').': '. date($date_format) }}</p>
				</div>

				<div class="table-responsive">
					<table class="table">
						<thead>
							<th>{{ _lang('Account Name') }}</th>
							<th>{{ _lang('Group Code') }}</th>
							<th>{{ _lang('Cr Amount') }}</th>
							<th>{{ _lang('Dr Amount') }}</th>
							<th>{{ _lang('Balance') }}</th>
						</thead>
						<tbody>
                        @if(isset($reportCode))
                            @foreach($reportCode as $code)
                                @php
                                    if (isset($code['code']) && !empty($code['code'])){
                                        $group = \App\Models\Group::where('code',$code['code'])->first();
                                        if (isset($group) && !empty($group)){
                                            $data = \App\Models\EntriesItemsApprove::getFinancialYearWiseCrDrTransctions($code['code']);
                                        }
                                    }
                                @endphp
                                @if(isset($code['code']) && !empty($code['code']) && isset($group) && !empty($group))
                                    <tr>
                                        <td>
                                            @for($i=0;$i<=$code['white_space'];$i++)
                                                &nbsp;
                                            @endfor
                                            {{ $data['group_name'] }}
                                        </td>
                                        <td>{{ $data['group_code'] }}</td>
                                        <td class="text-right">{{$data['cr_total']}}</td>
                                        <td class="text-right">{{$data['dr_total']}}</td>
                                        <td class="text-right">{{ number_format($data['cr_total']-$data['dr_total'],2)}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
