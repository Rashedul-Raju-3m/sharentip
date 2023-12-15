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
                    @if($ledgers && count($ledgers)>0)
                        @foreach($ledgers as $key => $ledger)
                            <option value="{{$ledger['id']}}" {{isset($item->ledger_id) && $item->ledger_id == $ledger['id']?'selected':''}}>{{ $ledger['name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </td>
            <td class="text-center">
                <input type="text" class="form-control debit" name="debit" row-id="{{$item->id}}" id="debit_{{$item->id}}" value="{{ $item->dc && $item->dc == 'D'?$item->amount:'' }}" placeholder="Debit">
            </td>
            <td class="text-center">
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
        <th>
        </th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
@endif
