@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ 'Add New '. $entryName }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('store_entries') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ _lang('Number') }}
                                    <span style="color: red" id="uniqueMessage"></span>
                                </label>
                                <input type="hidden" id="entry_id" name="entry_id" value="{{$newEntries->id}}">

                                <a data-href="{{route('ledger_number_unique_check')}}" id="ledger_number_unique_check" style="display: none;"></a>
                                <a data-href="{{route('entries_item_added')}}" id="entries_item_added" style="display: none;"></a>
                                <a data-href="{{route('get_current_balance')}}" id="get_current_balance" style="display: none;"></a>
                                <a data-href="{{route('remove_entries_item')}}" id="remove_entries_item_route" style="display: none;"></a>
                                <input type="text" required class="form-control legderNumber" name="number" value="{{ old('number') }}">
                                <input type="hidden" class="form-control" name="entry_type_id" value="{{ $entryID }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Date') }}</label>
                                <input type="text" class="form-control datepicker" name="invoice_date" value="{{ old('invoice_date') }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Project') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ old('project_id') }}" name="project_id" id="project_id" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['projects'] && count($data['projects'])>0)
                                        @foreach($data['projects'] as $key => $project)
                                            <option value="{{$project->id}}">{{ $project->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" id="tags">
                                <label class="control-label">{{ _lang('Tag') }}</label>
                                <input type="text"  name="tags" value="{{old('tags')}}" class="form-control">
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td class="text-center" width="100px">
                                        <select class="form-control " name="op_balance_dc" id="op_balance_dc">
                                            <option value="D">Dr</option>
                                            <option value="C">Cr</option>
                                        </select>
                                    </td>
                                    <td class="text-center" colspan="2">
                                        <select class="form-control auto-select select2" data-selected="{{ old('parent_group') }}" name="parent_id" id="ledger_id">
                                            <option value="">{{ _lang('Select Ledger') }}</option>
                                            @if($data['ledgers'] && count($data['ledgers'])>0)
                                                @foreach($data['ledgers'] as $key => $ledger)
                                                    <option value="{{$ledger['id']}}">{{ $ledger['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Amount">
                                    </td>
                                    <td class="text-center">
                                        <input type="textarea" required class="form-control" name="narration" id="narration" value="{{ old('narration') }}" placeholder="Narration">
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control" name="current_balance" id="current_balance" value="{{ old('current_balance') }}" placeholder="Current Balance" readonly>
                                    </td>
                                    <td class="text-center">
                                        <span class="btn btn-primary" id="entriesAdded">Add</span>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                            <table class="table table-striped table-bordered" id="customers_table">
                                <thead>
                                <tr>
                                    <th class="text-center">Dr. / Cr.</th>
                                    <th class="text-center">Ledger</th>
                                    <th class="text-center">Dr. Amount (TK)</th>
                                    <th class="text-center">Cr. Amount (TK)</th>
                                    <th class="text-center">Narration</th>
                                    <th class="text-center">Current Balance (TK)</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="Entries-body">

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" id="notes">
                                <label class="">{{ _lang('Notes') }}</label>
                                <textarea class="form-control" name="notes">{{ old('notes') }}</textarea>
                            </div>
                        </div>

						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary" id="submit-button"><i class="ti-check-box mr-2"></i>{{ _lang('Save Changes') }}</button>
							</div>
						</div>
					</div>
			    </form>
			</div>
		</div>
    </div>
</div>
@endsection


@section('js-script')
    <script type="text/javascript">
        $(document).delegate('.legderNumber','keyup',function () {
            let legderNumber = $(this).val();
            let route = $('#ledger_number_unique_check').attr('data-href');
            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {legderNumber: legderNumber},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                if(response.message=='exists'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Already exists!',
                        position: 'top-end',
                        timer: 1500,
                        width : 300,
                        height : 300
                    })
                    $('#uniqueMessage').text('Already exists');
                }else{
                    $('#uniqueMessage').text('');
                }
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        });

        $(document).delegate('#entriesAdded','click',function () {
            let dc = $('#op_balance_dc').val();
            let ledgerID = $('#ledger_id').val();
            let amount = $('#amount').val();
            let narration = $('#narration').val();
            let currentBalance = $('#current_balance').val();
            let entry_id = $('#entry_id').val();
            let route = $('#entries_item_added').attr('data-href');
            let validation = true;
            let validationMessage = '';
            if(!ledgerID || ledgerID == '' || ledgerID == null){
                validation = false;
                validationMessage = 'Choose ledger'
            }
            if(!amount || amount == '' || amount == null){
                validation = false;
                validationMessage = 'Enter amount'
            }

            if(validation){
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {dc: dc,ledgerID:ledgerID,amount:amount,narration:narration,currentBalance:currentBalance,entry_id:entry_id},
                    beforeSend: function( xhr ) {

                    }
                }).done(function( response ) {
                    if(response.message=='error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            position: 'top-end',
                            timer: 1500,
                            width : 300,
                            height : 300
                        })
                    }else{
                        $('.Entries-body').html(response.content);
                    }
                    if(response.difference == 0){
                        $('#submit-button').show(1500);
                    }else{
                        $('#submit-button').hide(1500);
                    }
                }).fail(function( jqXHR, textStatus ) {

                });
                return false;
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: validationMessage+' !',
                    position: 'top-end',
                    timer: 1500,
                    width : 300,
                    height : 300
                })
            }
        });

        $(document).delegate('#ledger_id','change',function () {
            let ledgerID = $(this).val();
            let route = $('#get_current_balance').attr('data-href');
            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {ledgerID: ledgerID},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                $('#current_balance').val(response.currentBalance);
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        });

        $(document).delegate('#remove-entries-item','click',function () {
            if (confirm('Are you sure you want to delete this data ?')) {

                let entriesItemID = $(this).attr('value');
                let route = $('#remove_entries_item_route').attr('data-href');
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {entriesItemID: entriesItemID},
                    beforeSend: function (xhr) {

                    }
                }).done(function (response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Data Delete!',
                        position: 'top-end',
                        timer: 1500,
                        width: 300,
                        height: 300
                    })
                    $('.Entries-body').html(response.content);
                    if (response.difference == 0) {
                        $('#submit-button').show(1500);
                    } else {
                        $('#submit-button').hide(1500);
                    }
                }).fail(function (jqXHR, textStatus) {

                });
                return false;
            }
        });
    </script>
@endsection

