@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => 'Service Category',
    ])

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    <div class="row mb-4 mt-2">
                        <div class="col-lg-8"><h2 class="section-title mt-0"> View Service Category</h2></div>
                        <div class="col-lg-4 text-right">
                            @can('scanner_create')
                            <button class="btn btn-primary add-button"><a href="{{route('service_category_add')}}"><i class="fas fa-plus"></i> {{__('Add New')}}</a></button>
                            @endcan
                        </div>
                    </div>
                  <div class="table-responsive">
                    <table class="table" id="report_table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Service Category</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach ($serviceCategory as $item)
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>{{$item->name}}</td>
                                    <td><span class="badge {{$item->is_active==1?'badge-success':'badge-danger'}} badge-primary"> {{$item->is_active==1?'Active':'Inactive'}}</span></td>
                                    <td>
                                        <a href="{{ route('service_category_edit',$item->id) }}" title="Edit {{$item->name}}" class="btn-icon text-success"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('service_category_delete',$item->id) }}" onclick="return confirm('Are you sure you want to delete this item?');" title="Delete {{$item->name}}" class="btn-icon text-danger"><i class="fas fa-trash text-danger"></i></a>
                                    </td>

                                </tr>
                                @php $index++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
