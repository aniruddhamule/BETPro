@extends('frontend.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center">
                    <h2 class="title">{{ __('Reset Password') }}</h2>
                </div>
            </div>
        </div>
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    {!! Form::open(array('route' => 'user.resetPassword', 'method' => 'POST')) !!}
                        <input type="hidden" name="code" value="{{$code}}">
                        <input type="hidden" name="email" value="{{$email}}">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('New Password')}}</span>
                            <span class="icon"><i class="fa fa-key"></i></span>
                            <input id="password" type="password" placeholder="{{__('New Password')}}" name="password" required autocomplete="password">
                        </div>
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Confirm Password')}}</span>
                            <span class="icon"><i class="fa fa-key"></i></span>
                            <input id="password" type="password" placeholder="{{__('Confirm Password')}}" name="password_confirmation" required autocomplete="password_confirmation" autofocus>
                        </div>
                        @include('partials.custom_captcha')
                        @include('partials.google_recaptcha')
                        <div class="text-center mb-3">
                            <button class="btn btn-base" type="submit">{{__('Update Password')}}</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
