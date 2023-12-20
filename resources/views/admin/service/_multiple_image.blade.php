
<tr sl-no="{{$slNo}}" id="delete_row_{{$slNo}}">
    <td width="40%">
        {!! Form::text('img_level[]',null,['id'=>'img_level','placeholder'=>'Image Level','class'=>'form-control']) !!}
    </td>
    <td width="40%">
        <div style="position:relative;border: 1px solid #e6e0e0;">
            <a class='btn btn-primary btn-sm font-10' href='javascript:;'>
                Choose File...
                <input name="attach_link[]" type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info{{$slNo}}").html($(this).val());'>
            </a>
            &nbsp;
            <span style="color: red">{!! $errors->first('attach_link[]') !!}</span>
            <span class='label label-info' id="upload-file-info{{$slNo}}"></span>

        </div>

    </td>
    <td width="10%" style="color: red">
    <i class="fa fa-trash btn btn-danger" id="moreImageDelete" sl-no={{$slNo}} aria-hidden="true" style="text-align: right;cursor: pointer;"></i>
    </td>

</tr>
