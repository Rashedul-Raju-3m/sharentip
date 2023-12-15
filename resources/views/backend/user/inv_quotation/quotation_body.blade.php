@if(isset($items))
    @php $itemsSubTotal = 0;$itemsTotal = 0;$itemsVat = 0;$itemsDiscount = 0; @endphp
    @foreach($items as $item)
<tr>
    <td class="text-center" width="30%">{{$item->product_name}}</td>
    <td class="text-center" style="width: 10%">
        <input type="text" name="quantity" value="{{$item->quantity}}" data-id="{{$item->id}}" id="quantity" class="form-control text-center">
    </td>
    <td class="text-center" style="width: 15%">
        <input type="text" name="rate" value="{{$item->unit_cost}}" data-id="{{$item->id}}" id="unit_cost" class="form-control text-right">
    </td>
    <td class="text-center" width="12%">
        <input type="text" name="vat" value="{{$item->vat}}" class="form-control text-center" readonly>
    </td>

    <td class="text-center" style="width: 12%">
        <input type="text" name="discount" value="{{$item->discount}}" class="form-control text-center" readonly>
    </td>

    @php
        $subTotal = $item->quantity*$item->unit_cost;
        $vatAmount = ($subTotal*$item->vat)/100;
        $itemsVat = $itemsVat+$vatAmount;
        $discountAmount = ($subTotal*$item->discount)/100;
        $itemsDiscount = $itemsDiscount+$discountAmount;
        $itemsSubTotal = $itemsSubTotal+$subTotal;
        $total = $subTotal+$vatAmount-$discountAmount;
        $itemsTotal = $itemsTotal+$total;
    @endphp
    <td class="text-center" style="width: 15%">
        <input type="text" name="amount" value="{{number_format($total,2)}}" class="form-control text-right" readonly>
    </td>
    <td class="text-center" style="width: 5%">
        <span id="removeItem" data-id="{{$item->id}}"><i class="ti-trash mr-1"></i></span>
    </td>
</tr>
    @endforeach
    <tr>
        <th colspan="2" style="color: #000000;text-align: center;"> Total Amount (tk.)</th>
        <th class="text-center">
            <input type="text" name="sub_total" value="{{number_format($itemsSubTotal,2)}}" class="form-control sub_total text-right" placeholder="Sub Total" readonly>
        </th>
        <th class="text-center">
            <input type="text" name="total_vat" value="{{number_format($itemsVat,2)}}" class="form-control total_vat text-center" placeholder=" Total Vat" readonly>
        </th>
        <th class="text-center">
            <input type="text" name="total_discount" value="{{number_format($itemsDiscount,2)}}" class="form-control total_discount text-center" placeholder=" Total Discount" readonly>
        </th>
        <th class="text-center">
            <input type="text" name="total" id="total" value="{{number_format($itemsTotal,2)}}" class="form-control total text-right" placeholder=" Total" readonly>
        </th>
        <th></th>
    </tr>
    <tr>
        <th colspan="3" style="color: #000000;text-align: center;">Discount %</th>
        <th class="text-center">
            <input type="text" name="discount" class="form-control discount text-center" id="discount">

        </th>
        <th class="text-center">
{{--            <div class="checkbox">--}}
{{--                <div class="custom-control custom-checkbox">--}}
                    <input type="checkbox"  name="discount_type" value="0" id="discount_type">
                    <label for="discount_type">{{ _lang('Is percentage') }}</label>
{{--                </div>--}}
{{--            </div>--}}
        </th>
        <th class="text-center">
            <input type="text" name="discount_amount" id="discount_amount" value="" class="form-control text-right" placeholder="Discount">
        </th>
        <th></th>
    </tr>

    <tr>
        <th colspan="5" style="color: #000000;text-align: center;">Grand Amount</th>
        <th class="text-center">
            <input type="text" name="grand_amount" value="" class="form-control grand_amount text-right" id="grand_total" placeholder="Grand Amount">
        </th>
        <th></th>
    </tr>
@endif
