@extends('frontend.layouts.master')
@section('content')

<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="contact-inner">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 mx-auto mb-50">
                    <img src="{{__('public/images/login.webp')}}" alt="img">
                </div>
                <div class="col-lg-5 col-md-8 col-12 mx-auto mb-50 align-self-center">
                    <h3 class="subtitle text-center mb-4 mt-5 mt-lg-0">{{ __('Login') }}</h3>
                    {!! Form::model(array('route' => 'login', 'method' => 'POST')) !!}
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Email Address')}}</span>
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                            <input name="email" placeholder="Email" type="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Password')}}</span>
                            <span class="icon"><i class="fa fa-key"></i></span>
                            <input id="password" name="password" placeholder="*************" type="password" required autocomplete="current-password">
                        </div>
                        @include('partials.custom_captcha')
                        @include('partials.google_recaptcha')
                        <div class="text-center mb-3">
                            <button class="btn btn-base" type="submit">{{__('Sign In')}}</button>
                        </div>
                        @if (Route::has('user.showEmailForm'))
                        <p class="text-center"><a href="{{ route('user.showEmailForm') }}">{{ __('Forgot Your Password?') }}</a></p>
                        @endif
                        <p class="text-center">{{__('Don\'t have any account')}}, <a href="{{ route('register') }}">{{__('Signup here')}}</a></p>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
