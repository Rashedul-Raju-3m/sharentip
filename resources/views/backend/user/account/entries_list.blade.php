@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card no-export">
                <div class="card-body" style="padding-bottom: 0px !important;">
                    <form method="POST" class="validate" autocomplete="off" action="{{ route('entries_filter') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3">Filter Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="33%">
                                    <div class="form-group">
                                        <label>{{ _lang('Date Range') }}</label>
                                        <input type="text" class="form-control select-filter" id="date_range" autocomplete="off" placeholder="{{ _lang('Date Range') }}" name="date_range" value="{{$input && $input['date_range']?$input['date_range']:''}}">

                                    </div>
                                </td>

                                <td width="33%">
                                    <div class="form-group">
                                        <label>{{ _lang('Ledger') }}</label>
                                        <select class="form-control auto-select select2" data-selected="{{ $input && $input['ladger_id']?$input['ladger_id']:'' }}" name="ladger_id" id="ledger_id">
                                            <option value="">{{ _lang('Select Ledger') }}</option>
                                            @if($data['ledgers'] && count($data['ledgers'])>0)
                                                @foreach($data['ledgers'] as $key => $ledger)
                                                    <option value="{{$ledger['id']}}">{{ $ledger['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td width="33%">
                                    <div class="form-group">
                                        <label>{{ _lang('Number') }}</label>
                                        <input type="text" class="form-control" name="number" value="{{ $input && $input['number'] ? $input['number']:'' }}">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="33%">
                                    <div class="form-group">
                                        <label>{{ _lang('Project') }}</label>
                                        <select class="form-control auto-select select2" data-selected="{{ $input && $input['project_id']?$input['project_id']:'' }}" name="project_id" id="project_id">
                                            <option value="">{{ _lang('Select One') }}</option>
                                            @if($data['projects'] && count($data['projects'])>0)
                                                @foreach($data['projects'] as $key => $project)
                                                    <option value="{{$project->id}}">{{ $project->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td width="33%">
                                    <div class="form-group">
                                        <label>{{ _lang('Tag') }}</label>
                                        <input type="text"  name="tag_id" value="{{$input && $input['tag_id'] ? $input['tag_id'] :''}}" class="form-control">
                                    </div>
                                </td>
                                <td width="33%">
                                    <div class="form-group">
                                        <label>{{ _lang('Type') }}</label>
                                        <select class="form-control auto-select select2" data-selected="{{ $input && $input['type']?$input['type']:'' }}" name="type" id="type">
                                            <option value="">{{ _lang('Select Type') }}</option>
                                            @if($entryTypes && count($entryTypes)>0)
                                                @foreach($entryTypes as $key => $type)
                                                    <option value="{{$type->id}}">{{ $type->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <div class="form-group" style="margin-bottom: 0px !important;">
                                        <button type="submit" value="all" class="btn btn-primary" id="submit-button"><i class="ti-check-box mr-2"></i>{{ _lang('Filter') }}</button>

                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align -items-center">
				<span class="panel-title">{{ _lang('Entries Not Approve') }}</span>


                <span class="dropdown ml-auto ">
                  <button class="btn btn-primary btn-xs dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ _lang('Add Entry') }}
                  </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="left: -22px !important;">
                        @if($entryTypes)
                            @foreach($entryTypes as $type)
                                <a href="{{route('accounts_create_entries',[$type->id,$type->name])}}" class="dropdown-item dropdown-view dropdown-view">
                                    <i class="ti-settings mr-2"></i>
                                    {{$type->name}}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </span>
			</div>
			<div class="card-body">

                <table id="accounts_table" class="table data-table">
					<thead>
					    <tr>
                            <th>Date</th>
                            <th>Number</th>
                            <th class="text-center">Ledger</th>
                            <th class="text-center">Type</th>
{{--                            <th class="text-center">Tag</th>--}}
                            <th class="text-center">Debit Amount (TK)</th>
                            <th class="text-center">Credit Amount (TK)</th>
                            <th class="text-center">Actions</th>
					    </tr>
					</thead>
					<tbody>
                    @php
                        $i = 1;
                    @endphp
                        @foreach($entries as $entry)
                            @php
                                $val = $i%2;
                            @endphp
                            <tr style="background-color: {{$val==0?'#ffffff !important':'#eceaea !important'}} ;">
                                @php
                                    $i++;
                                @endphp
                                <td class="text-bold">
                                    {{date('d-m-Y', strtotime($entry->date))}}
                                </td>
                                <td class=" text-bold">
                                    <a href="{{ route('entries_view',$entry->uu_id) }}" class="btn btn-outline-primary btn-xs">
                                        {{$entry->number}}
                                    </a>
                                </td>
                                <td class="text-center text-bold">
                                    @php
                                        $entriesLedgersID = \App\Models\EntriesItemsNotApprove::where('entry_id',$entry->id)->select(['ledger_id','dc'])->get()->toArray();
                                        $ledgerDebit = '';
                                        $ledgerCredit = '';
                                        foreach ($entriesLedgersID as $ledgerID){
                                            $ledger = \App\Models\Ledger::find($ledgerID['ledger_id']);
                                            if ($ledgerID['dc'] == 'D'){
$ledgerDebit = ($ledgerDebit && isset($ledger->code))?
        $ledgerDebit.' ['.$ledger->code.'] '.'Dr. '.(isset($ledger->name)?$ledger->name:''):
        $ledgerDebit.''.' Dr. '.(isset($ledger->name)?$ledger->name:'');
                                            }
                                            if ($ledgerID['dc'] == 'C'){
$ledgerCredit = ($ledgerCredit && isset($ledger->code))?
        $ledgerCredit.' ['.$ledger->code.'] '.'Cr. '.(isset($ledger->name)?$ledger->name:''):
        $ledgerCredit.''.' Cr. '.(isset($ledger->name)?$ledger->name:'');
                                            }
                                        }
                                    @endphp
                                    {{$ledgerDebit.' / '.$ledgerCredit}}
                                </td>
                                <td class="text-center text-bold">
                                    @php
                                        $entryType = \App\Models\EntryType::find($entry->entry_type_id);
                                    @endphp
                                    {{$entryType?$entryType->name:''}}
                                </td>
{{--                                <td class="text-center text-bold">{{$entry->tag}}</td>--}}
                                <td class="text-center text-bold">{{$entry->dr_total}}</td>
                                <td class="text-center text-bold">{{$entry->cr_total}}</td>
                                <td class="text-center text-bold">
                                        @if (isset($entry->uu_id) && !empty($entry->uu_id))

                                    <a href="{{ route('entries_view',$entry->uu_id) }}" class="btn btn-outline-primary btn-xs">
                                        <i class="ti-eye"></i>&nbsp;{{ _lang('View') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
    <script type="text/javascript">
        $('#date_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            invoice_table.draw();
        });

        $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            invoice_table.draw();
        });
    </script>
@endsection
