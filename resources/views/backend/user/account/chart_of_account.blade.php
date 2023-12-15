@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align -items-center">
				<span class="panel-title">{{ _lang('Chart of Accounts') }}</span>

                <span class="dropdown ml-auto ">
                  <button class="btn btn-primary btn-xs dropdown-toggle btn-xs" type="button"
                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                  {{ _lang('Add Entry') }}
                  </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                         style="left: -22px !important;">
                        @if($entryTypes)
                            @foreach($entryTypes as $type)
                                <a href="{{route('accounts_create_entries',[$type->id,$type->name])}}"
                                   class="dropdown-item dropdown-view dropdown-view">
                                    <i class="ti-settings mr-2"></i>
                                    {{$type->name}}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </span>

				<a class="btn btn-primary btn-xs ml-auto" style="margin-left: 10px !important;" href="{{ route('accounts_create_ledger') }}">
                    <i class="ti-plus mr-2"></i>{{ _lang('Add New Ledger') }}
                </a>

				<a class="btn btn-primary btn-xs ml-auto" style="margin-left: 10px !important;" href="{{ route('accounts_create_group') }}">
                    <i class="ti-plus mr-2"></i>{{ _lang('Add New Group') }}
                </a>
			</div>
			<div class="card-body">
				<table class="table">
					<thead>
					    <tr>
                            <th class="text-center">Account Code</th>
                            <th class="text-center">Account Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center"> O/P Balance (INR)</th>
                            <th class="text-center">C/L Balance (INR)</th>
                            <th class="text-center">Actions</th>
					    </tr>
					</thead>
					<tbody>
                        @foreach($groups as $group)
                            <tr class="" style="background-color: #eceaea !important;font-weight: bold">
                                <td class="text-bold">
                                    @php
                                        if (substr_count($group->code, "-") == 1){
                                            $space = "-";
                                        }elseif (substr_count($group->code, "-") == 2){
                                            $space = "--";
                                        }elseif (substr_count($group->code, "-") == 3){
                                            $space = "---";
                                        }elseif (substr_count($group->code, "-") == 4){
                                            $space = "----";
                                        }elseif (substr_count($group->code, "-") == 5){
                                            $space = "-----";
                                        }elseif (substr_count($group->code, "-") == 6){
                                            $space = "------";
                                            //$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                        }else{
                                            $space = "";
                                        }
                                    @endphp

                                    {{$space.$group->code}}
                                </td>
                                <td class=" text-bold">{{$group->name}}</td>
                                <td class="text-center text-bold">Group</td>
                                <td class="text-center text-bold">-</td>
                                <td class="text-center text-bold">-</td>
                                <td class="text-center text-bold">
                                    @if(isset($group->parent_id) && !empty($group->parent_id))
                                    <a href="{{ route('group_edit', $group->id) }}" class="dropdown-item dropdown-edit"><i class="ti-pencil mr-1"></i> {{ _lang('Edit') }}</a>
                                    @endif

                                </td>
                            </tr>
                            @php
                                $ledgers = DB::table('ledgers')->where('group_id',$group->id)->orderBy('code')->get();
                            @endphp

                            @foreach($ledgers as $ledger)
                                <tr class="" style="background-color: #fff !important;">
                                    <td>
                                        @php
                                            if (substr_count($ledger->code, "-") == 1){
                                                $space = "-";
                                            }elseif (substr_count($ledger->code, "-") == 2){
                                                $space = "--";
                                            }elseif (substr_count($ledger->code, "-") == 3){
                                                $space = "---";
                                            }elseif (substr_count($ledger->code, "-") == 4){
                                                $space = "----";
                                            }elseif (substr_count($ledger->code, "-") == 5){
                                                $space = "-----";
                                            }elseif (substr_count($ledger->code, "-") == 6){
                                                $space = "------";
                                            }else{
                                                $space = "";
                                            }
                                        @endphp
                                        <a href="">
                                            {{$space.$ledger->code}}
                                        </a>
                                    </td>
                                    <td>{{$ledger->name}}</td>
                                    <td class="text-center">Ledger</td>
                                    @php
                                        if ($ledger->op_balance_dc == 'D'){
                                            $dcType = 'Dr.';
                                        }else{
                                            $dcType = 'Cr.';
                                        }
                                    @endphp
                                    <td class="text-right">{{$dcType.number_format($ledger->op_balance,2)}}</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">
                                        <a href="{{ route('ledger_edit', $ledger->id) }}" class="dropdown-item dropdown-edit"><i class="ti-pencil mr-1"></i> {{ _lang('Edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach

                        @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
