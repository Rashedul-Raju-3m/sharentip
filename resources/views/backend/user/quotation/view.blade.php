@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('public/backend/assets/css/invoice.css?v=1.0') }}">

<div class="row">
	<div class="col-lg-8 offset-lg-2">
		@include('backend.user.quotation.action')
		@include('backend.user.quotation.template.loader')
	</div>
</div>
@endsection