@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Edit Group') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('update_group',$data['group']->id) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
{{--                    {{dd()}}--}}
					<div class="row">
						<div class="col-md-6">
                            <div class="form-group">
                                <label  class="control-label">{{ _lang('Parent Group') }}</label>
                                <a data-href="{{route('get_next_number')}}" id="nextNumberRoute" style="display: none;"></a>
                                <select class="form-control auto-select select2" data-selected="{{ $data['group']->parent_id }}" name="parent_id" id="parent_id" onchange="getNumber()" required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    @if($data['groups'] && count($data['groups'])>0)
                                        @foreach($data['groups'] as $key => $group)
                                            <option value="{{$key}}">{{ $group }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
						</div>


						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">{{ _lang('Code') }}</label>
								<input type="text" required readonly class="form-control" id="group_code" name="group_code" value="{{ $data['group']->code }}">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">{{ _lang('Name') }}</label>
								<input type="text" required class="form-control" name="group_name" value="{{ $data['group']->name }}">
							</div>
						</div>


						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary"><i class="ti-check-box mr-2"></i>{{ _lang('Save Changes') }}</button>
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
        function getNumber() {
            let id = $("#parent_id option:selected").val();
            let base_url = $('#nextNumberRoute').attr('data-href');
            $.ajax({
                type:"get",
                url: base_url,
                data: { id }
            }).done(function(msg){
                $('#group_code').val(msg);
            });
        }
    </script>
@endsection

