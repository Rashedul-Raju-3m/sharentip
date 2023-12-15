@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ 'Add New '. $data['entryType']->name }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('update_entries') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ _lang('Number') }}
                                    <span style="color: red" id="uniqueMessage"></span>
                                </label>
                                <input type="hidden" id="entry_id" name="entry_id" value="{{$data['entries']->id}}">

                                <a data-href="{{route('ledger_number_unique_check')}}" id="ledger_number_unique_check" style="display: none;"></a>
                                <a data-href="{{route('entries_item_added')}}" id="entries_item_added" style="display: none;"></a>
                                <a data-href="{{route('get_current_balance')}}" id="get_current_balance" style="display: none;"></a>
                                <a data-href="{{route('remove_entries_item')}}" id="remove_entries_item_route" style="display: none;"></a>
                                <a data-href="{{route('entries_item_inline_update')}}" id="entries_item_inline_update" style="display: none;"></a>
                                <a data-href="{{route('added_empty_entries_item')}}" id="added_empty_entries_item" style="display: none;"></a>
                                <input type="text" required class="form-control legderNumber" name="number" value="{{$data['entries']->number}}">
                                <input type="hidden" class="form-control" name="entry_type_id" value="{{ $data['entryType']->id }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Date') }}</label>
                                <input type="text" class="form-control datepicker" name="invoice_date" value="{{$data['entries']->date}}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Project') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{$data['entries']->project_id}}" name="project_id" id="project_id" required>
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
                                <input type="text"  name="tags" value="{{$data['entries']->tag_id}}" class="form-control">
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="customers_table">
                                <thead>
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Ledger</th>
                                    <th class="text-center">Debits</th>
                                    <th class="text-center">Credits</th>
                                    <th class="text-center">Narration</th>
                                    <th class="text-center">Current Bal.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="Entries-body">
                                @if(count($entriesItems)>0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($entriesItems as $key => $item)
                                        <tr style="background-color: #ffffff !important;">
                                            <td class="text-center text-bold">{{$i}}</td>
                                            <td>
                                                <select class="form-control select2 ledger_id" row-id="{{$item->id}}" name="ledger_id" id="ledger_id_{{$item->id}}" style="width: 200px !important;">
                                                    <option value="">{{ _lang('Select Ledger') }}</option>
                                                    @if($data['ledgers'] && count($data['ledgers'])>0)
                                                        @foreach($data['ledgers'] as $key => $ledger)
                                                            <option value="{{$ledger['id']}}" {{isset($item->ledger_id) && $item->ledger_id == $ledger['id']?'selected':''}}>{{ $ledger['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control debit" name="debit" row-id="{{$item->id}}" id="debit_{{$item->id}}" value="{{ $item->dc && $item->dc == 'D'?$item->amount:'' }}" placeholder="Debit">
                                            </td>
                                            <td class="text-center" >
                                                <input type="text" class="form-control credit" name="credit" row-id="{{$item->id}}" id="credit_{{$item->id}}" value="{{ $item->dc && $item->dc == 'C'?$item->amount:'' }}" placeholder="Credit">
                                            </td>
                                            <td class="text-center">
                                                <input type="textarea" class="form-control narration" name="narration" row-id="{{$item->id}}" id="narration_{{$item->id}}" value="{{ $item->narration?$item->narration:'' }}" placeholder="Narration">
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control" name="current_balance" id="current_balance_{{$item->id}}" value="{{ $item->current_balance?$item->current_balance:'' }}" placeholder="Current Bal." readonly>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control select2 user_id" row-id="{{$item->id}}" name="user_id" id="user_id_{{$item->id}}" style="width: 150px !important;">
                                                    <option value="">{{ _lang('Select User') }}</option>
                                                    @if($data['users'] && count($data['users'])>0)
                                                        @foreach($data['users'] as $key => $user)
                                                            <option value="{{$user['id']}}" {{isset($item->assign_user) && $item->assign_user == $user['id']?'selected':''}}>{{ $user['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <span id="remove-entries-item" value="{{$item->id}}"><i class="ti-trash mr-1"></i> </span>
                                            </td>
                                            @php $i++ @endphp
                                        </tr>
                                    @endforeach
                                    <tr align="center">
                                        <th colspan="2" style="color: #000000">Total Amount</th>
                                        <th style="color: #000000">{{$totalDebit}}</th>
                                        <th style="color: #000000">{{$totalCredit}}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-center" style="background-color: #FFFFFF;color: #000000;cursor: pointer">
                                            <span id="add-entries-item"><i class="ti-plus mr-1"></i> </span>
                                        </th>
                                    </tr>
                                    <tr align="center">
                                        <th colspan="2" style="color: #000000">Difference</th>
                                        <th style="color: #000000" colspan="2">{{$totalDebit-$totalCredit}}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" id="notes">
                                <label class="">{{ _lang('Notes') }}</label>
                                <textarea class="form-control" name="notes">{{$data['entries']->notes}}</textarea>
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

        $(document).delegate('.debit,.credit,.narration','blur',function () {
            let rowID = $(this).attr('row-id');
            let fieldName = $(this).attr('name');
            let value = $(this).val();

            if(fieldName == 'debit'){
                $("#credit_"+rowID).val('');
            }
            if(fieldName == 'credit'){
                $("#debit_"+rowID).val('');
            }
            let route = $('#entries_item_inline_update').attr('data-href');
            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {rowID: rowID,fieldName:fieldName,value:value},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                if(response.content && response.content !=''){
                    $('.Entries-body').html(response.content);
                }
                $('.ledger_id').select2();
                $('.user_id').select2();
                if (response.difference == 0) {
                    $('#submit-button').show(1500);
                } else {
                    $('#submit-button').hide(1500);
                }
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        });

        $(document).delegate('.ledger_id,.user_id','change',function () {
            let rowID = $(this).attr('row-id');
            let fieldName = $(this).attr('name');
            let value = $(this).val();

            let route = $('#entries_item_inline_update').attr('data-href');
            $.ajax({
                url: route,
                method: "GET",
                dataType: "json",
                data: {rowID: rowID,fieldName:fieldName,value:value},
                beforeSend: function( xhr ) {

                }
            }).done(function( response ) {
                if(response.content && response.content !=''){
                    $('.Entries-body').html(response.content);
                }
                $('.ledger_id').select2();
                $('.user_id').select2();
            }).fail(function( jqXHR, textStatus ) {

            });
            return false;
        });

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
                   /* Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Data Delete!',
                        position: 'top-end',
                        timer: 1500,
                        width: 300,
                        height: 300
                    })*/
                    $('.Entries-body').html(response.content);
                    $('.ledger_id').select2();
                    $('.user_id').select2();
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


        $(document).delegate('#add-entries-item','click',function () {
            // if (confirm('Are you sure you want to delete this data ?')) {
                let entryID = $('#entry_id').val();
                let route = $('#added_empty_entries_item').attr('data-href');
                $.ajax({
                    url: route,
                    method: "GET",
                    dataType: "json",
                    data: {entry_id: entryID},
                    beforeSend: function (xhr) {

                    }
                }).done(function (response) {
                    $('.Entries-body').html(response.content);
                    $('.ledger_id').select2();
                    $('.user_id').select2();
                    if (response.difference == 0) {
                        $('#submit-button').show(1500);
                    } else {
                        $('#submit-button').hide(1500);
                    }
                }).fail(function (jqXHR, textStatus) {

                });
                return false;
            // }
        });
    </script>
@endsection

