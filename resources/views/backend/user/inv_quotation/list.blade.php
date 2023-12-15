@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Quotation') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" data-title="{{ _lang('New Quotation') }}" href="{{ route('quotation_create') }}"><i class="ti-plus mr-2"></i>{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="accounts_table" class="table data-table">
					<thead>
					    <tr>
						    <th>{{ _lang('SL') }}</th>
						    <th>{{ _lang('Customer Name') }}</th>
						    <th>{{ _lang('Parent') }}</th>
							<th>{{ _lang('Invoice Number') }}</th>
							<th>{{ _lang('Total Amount') }}</th>
							<th class="">{{ _lang('Date') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
                        @php $i = 1 ;@endphp
					    @foreach($invQuotation as $quotation)
                            @php
                                if (isset($quotation->parent_quotation_id) && !empty($quotation->parent_quotation_id) && $quotation->parent_quotation_id!=''){
                                    $parent = \App\Models\InvQuotation::find($quotation->parent_quotation_id);
                                }
                            @endphp
					    <tr data-id="row_{{ $quotation->id }}">
							<td class='account_name'>{{ $i }}</td>
							<td class='account_name'>{{ $quotation->name }}</td>
							<td class='account_name'>
                                {{ $quotation->parent_quotation_id?$parent->invoice_number:null }}
                            </td>
							<td class='account_name'>{{ $quotation->invoice_number }}</td>
							<td class='currency text-center'>{{ $quotation->grand_total }} </td>
							<td class='opening_date'>{{ date('d-m-Y', strtotime($quotation->invoice_date))}}</td>

							<td class="text-center">
								<span class="dropdown">
								  <button class="btn btn-outline-primary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  </button>
								  <form action="{{ route('sales_order_delete', $quotation->id) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">

									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 116px;">
                                        @if($quotation->parent_quotation_id == null)
										<a href="{{ route('quotation_edit', $quotation->id) }}" data-title="{{ _lang('Update Quotation') }}" class="dropdown-item dropdown-edit"><i class="ti-pencil mr-1"></i> {{ _lang('Edit') }}</a>
                                        @endif
										<a href="{{ route('sales_order_view', $quotation->id) }}" data-title="{{ _lang('View Sale Order') }}" class="dropdown-item dropdown-edit"><i class="ti-eye mr-1"></i> {{ _lang('View') }}</a>
										<button class=" dropdown-item" onclick="return confirm('Are you sure you want to delete?')" type="submit"><i class="ti-trash mr-1"></i> {{ _lang('Delete') }}</button>
									</div>
								  </form>
								</span>
							</td>
					    </tr>
                        @php $i++ ;@endphp
					    @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
