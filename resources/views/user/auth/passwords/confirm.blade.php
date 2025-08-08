@extends('frontend.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center">
                    <h2 class="title">{{ __('Confirm Password') }}</h2>
                </div>
            </div>
        </div>
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    {!! Form::open(array('route' => 'password.confirm', 'method' => 'POST')) !!}
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Email Address')}}</span>
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <input name="email" placeholder="{{__('Email')}}" type="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('New Password')}}</span>
                        <span class="icon"><i class="fa fa-key"></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                    @include('partials.custom_captcha')
                    @include('partials.google_recaptcha')
                    <div class="text-center mb-3">
                        <button class="btn btn-base" type="submit">{{__('Confirm Password')}}</button>
                    </div>
                    @if (Route::has('password.request'))
                    <p class="text-center"><a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
