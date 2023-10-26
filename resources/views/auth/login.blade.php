@extends('app')

@section('title') {{trans('auth.login')}} -@endsection

@section('content')
<div class="py-5 bg-primary bg-sections">
  <div class="btn-block text-center text-white position-relative">
    <h1>{{ trans('misc.welcome_back') }}</h1>
    <p>{{$settings->title}}</p>
  </div>
</div><!-- container -->

<div class="py-5 bg-white text-center">
  <div class="container margin-bottom-40">

    <div class="row">
      <!-- Col MD -->
      <div class="col-md-12">
        <div class="d-flex justify-content-center">

          <form action="{{ url('login') }}" method="post" class="login-form text-left @if (count($errors) > 0)vivify shake @endif" name="form" id="signup_form">

            @csrf

            @if($settings->captcha == 'on')
            @captcha
            @endif

            @include('errors.errors-forms')

            @if (session('login_required'))
            <div class="alert alert-danger" id="dangerAlert">
              <i class="fa fa-exclamation-triangle"></i> {{ session('login_required') }}
            </div>
            @endif



            <div class="form-group">
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" required value="{{ old('email') }}" name="email" placeholder="{{ trans('auth.email') }}" title="{{ trans('auth.email') }}">
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-key"></i></span>
                <input type="password" class="form-control" required name="password" placeholder="{{ trans('auth.password') }}" title="{{ trans('auth.password') }}" autocomplete="off">
              </div>
            </div>

            <div class="my-1 d-flex justify-content-between align-items-center">
              <div class="form-check">
                <input type="checkbox" @if( old('remember') ) checked="checked" @endif class="form-check-input" name="remember" id="customControlInline" value="1">
                <label class="form-check-label" for="customControlInline">{{ trans('auth.remember_me') }}</label>
              </div>

              <small><a href="{{url('/password/reset')}}">{{ trans('auth.forgot_password') }}</a></small>
            </div>
            <button type="submit" class="btn btn-block mt-2 py-2 btn-primary font-weight-light">{{ trans('auth.sign_in') }}</button>
            @if ($settings->captcha == 'on')
            <small class="btn-block text-center">{{trans('misc.protected_recaptcha')}} <a href="https://policies.google.com/privacy" target="_blank">{{trans('misc.privacy')}}</a> - <a href="https://policies.google.com/terms" target="_blank">{{trans('misc.terms')}}</a></small>
            @endif
            <div class="text-center mt-2">
              <a href="{{url('register')}}">{{ trans('auth.not_have_account') }}</a>
            </div>
          </form>
        </div><!-- Login Form -->
      </div><!-- /COL MD -->
    </div><!-- ./ -->
  </div><!-- ./ -->
</div>
<!-- container wrap-ui -->

@endsection