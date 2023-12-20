@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => 'Update Service Category',
        'headerData' => 'Service Category' ,
        'url' => 'Service Category' ,
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-lg-8"><h2 class="section-title"> Update Service Category</h2></div>
        </div>

        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('service_category_update',[$serviceCategory->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group center">
                                    <label>{{__('Image')}} <span style="color: red"> *</span></label>
                                    <div id="image-preview" class="image-preview" style="background-image: url({{url('images/upload/'.$serviceCategory->image)}})">
                                        <label for="image-upload" id="image-label"> <i class="fas fa-plus"></i></label>
                                        <input type="file" name="image" id="image-upload" />
                                    </div>
                                    @error('image')
                                    <div class="invalid-feedback block">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Service Category Name</label>
                                    <input type="text" name="name" placeholder="Service category name" value="{{$serviceCategory->name}}" class="form-control @error('name')? is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{__('status')}}</label>
                                    <select name="is_active" class="form-control select2">
                                        <option value="1" {{$serviceCategory->is_active=="1" ? 'Selected' : ''}}>{{ __('Active') }}</option>
                                        <option value="0" {{$serviceCategory->is_active=="0" ? 'Selected' : ''}}>{{ __('Inactive') }}</option>
                                    </select>
                                    @error('is_active')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
