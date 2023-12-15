@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Add New Ledger') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('store_ledger') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Parent Group') }}</label>
                                <a data-href="{{route('get_next_number_ledger')}}" id="nextNumberRoute" style="display: none;"></a>
                                <select class="form-control auto-select select2" data-selected="{{ old('parent_group') }}" name="parent_id" id="group_id" onchange="getNumber()" required>
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
								<input type="text" required readonly class="form-control" id="ledger_code" name="code" value="{{ old('code') }}">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">{{ _lang('Name') }}</label>
								<input type="text" required class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Opening Balance') }}</label>
                                <select class="form-control auto-select select2" data-selected="{{ old('op_balance_dc') }}" name="op_balance_dc" id="op_balance_dc" required>
                                    <option value="Dr">Dr</option>
                                    <option value="Cr">Cr</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Amount') }}</label>
                                <input type="text" required class="form-control" name="op_balance" value="{{ old('op_balance') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <div class="checkbox">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="type" value="1" id="type">
                                    <label class="custom-control-label" for="type">{{ _lang('Bank or Cash Account') }}</label>
                                </div>
                            </div>
                            <div class="checkbox">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="reconciliation" value="1" id="reconciliation">
                                    <label class="custom-control-label" for="reconciliation">{{ _lang('Reconciliation') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Notes') }}</label>
                                <input type="textarea" class="form-control" name="notes" value="{{ old('notes') }}">
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
            let id = $("#group_id option:selected").val();
            let base_url = $('#nextNumberRoute').attr('data-href');
            $.ajax({
                type:"get",
                url: base_url,
                data: { id }
            }).done(function(msg){
                $('#ledger_code').val(msg);
            });
        }
    </script>
@endsection

