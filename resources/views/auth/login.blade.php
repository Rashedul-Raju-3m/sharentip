@extends('master')

@section('content')

  <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
          <img src="{{ url('images/upload/'.\App\Models\Setting::find(1)->logo)}}" alt="logo" width="80" class="login-logo mb-4 mt-2">
            <h4 class="text-dark font-weight-normal mb-4">{{__('Welcome to ')}}<span class="font-weight-bold">{{\App\Models\Setting::find(1)->app_name}}</span></h4>
            <form method="POST" action="{{url('admin/login')}}" class="needs-validation" novalidate="">
                @csrf
              <div class="form-group">
                <label for="email">{{__('Email')}}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
                @if(Session::has('error_msg'))
                    <span class="invalid-feedback" style="display: block;">
                        <strong>{{Session::get('error_msg')}}</strong>
                    </span>
                @endif
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">{{__('Password')}}</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox"  name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                  <label class="custom-control-label" for="remember-me">{{__('Remember Me')}}</label>
                </div>
              </div>

              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  {{__('Login')}}
                </button>
              </div>
                <a href="{{ url('google/redirect') }}">Login with Google</a>

            </form>
          </div>
        </div>
    <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{url('images/login-bg.jpg')}}">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">{{ __('Welcome') }}</h1>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
