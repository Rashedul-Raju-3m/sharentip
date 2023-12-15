@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align -items-center">
				<span class="panel-title">{{ _lang('Entries Approve') }}</span>


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
                                <td class=" text-bold">{{$entry->number}}</td>
                                <td class="text-center text-bold">
                                    @php
                                        $entriesLedgersID = \App\Models\EntriesItemsApprove::where('entry_id',$entry->id)->select(['ledger_id','dc'])->get()->toArray();
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
                                    @if(isset($entry->uu_id) && $entry->uu_id != '')
                                    <a href="{{ route('entries_approve_view',$entry->uu_id) }}" class="btn btn-outline-primary btn-xs">
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
