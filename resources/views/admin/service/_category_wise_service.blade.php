<div class="form-group">
    <label>Service</label>
    <br>
    @if($services)
        @foreach($services as $value)
            <input type="checkbox" name="service_id[]" id="lang{{$value->id}}" value="{{$value->id}}">
            <label for="lang{{$value->id}}">{{$value->name}}</label>

        @endforeach
    @endif
</div>
