
             @if(count($entriesItems)>0)
                 @php
                    $i = 1;
                 @endphp
                 @foreach($entriesItems as $item)
                     @php
                         $val = $i%2;
                     @endphp
            <tr style="background-color: {{$val==0?'#ffffff !important':'#eceaea !important'}} ;">
                <td class="text-bold">
                    {{$item->dc=='D'?'Dr.':'Cr.'}}
                </td>
                <td class=" text-bold">
                    @php
                        $ledger = \App\Models\Ledger::find($item->ledger_id);
                        $i++;
                    @endphp
                    {{$ledger->name?$ledger->name:''}}
                </td>
                <td class="text-center text-bold">
                    {{$item->dc=='D'?$item->amount:''}}
                </td>
                <td class="text-center text-bold">
                    {{$item->dc=='C'?$item->amount:''}}
                </td>
                <td class="text-center text-bold">{{$item->narration}}</td>
                <td class="text-center text-bold">{{$item->current_balance}}</td>
                <td class="text-center text-bold">
                    <span id="remove-entries-item" value="{{$item->id}}"><i class="ti-trash mr-1"></i> </span>
                </td>
            </tr>
                 @endforeach
                 <tr align="center">
                     <th colspan="2" style="color: #000000">Total Amount</th>
                     <th style="color: #000000">{{$totalDebit}}</th>
                     <th style="color: #000000">{{$totalCredit}}</th>
                     <th></th>
                     <th></th>
                     <th></th>
                 </tr>
                 <tr align="center">
                     <th colspan="2" style="color: #000000">Difference</th>
                     <th style="color: #000000" colspan="2">{{$totalDebit-$totalCredit}}</th>
                     <th>
{{--                         <input type="hidden" name="difference" value="{{$totalDebit-$totalCredit}}" {{$totalDebit-$totalCredit>0?'required':''}} >--}}
                     </th>
                     <th></th>
                     <th></th>
                 </tr>
             @endif

