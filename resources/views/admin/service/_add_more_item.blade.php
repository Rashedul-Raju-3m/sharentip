<tr id="sl-{{$slNo}}">
    <td>
        <input type="text" name="item_name[]" placeholder="Item name" value="{{old('item_name')}}" class="form-control">
    </td>
    <td>
        <input type="text" name="item_description[]" placeholder="Item description" value="{{old('item_description')}}" class="form-control">
    </td>
    <td>
        <input type="text" name="item_quantity[]" placeholder="Item quantity" value="{{old('item_quantity')}}" class="form-control">
    </td>
    <td>
        <input type="text" name="item_price[]" placeholder="Item price" value="{{old('item_price')}}" class="form-control">
    </td>
    <td>
        <input type="text" name="ems_discount[]" placeholder="EMS Discount" value="{{old('ems_discount')}}" class="form-control">
    </td>
    <td>
{{--        <button class="btn_remove btn-danger" remove-id="{{$slNo}}"><i class="fa fa-trash" aria-hidden="true"></i></button>--}}
        <i class="fa fa-trash btn btn-danger btn_remove" remove-id="{{$slNo}}" aria-hidden="true" style="text-align: right;cursor: pointer;"></i>
    </td>
</tr>
