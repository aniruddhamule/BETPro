
@extends('frontend.layouts.master')
@section('content')

<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        <div class="contact-inner">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 mx-auto mb-50">
                    <img src="{{__('public/images/about-thumb.webp')}}" alt="img">
                </div>
                <div class="col-lg-5 col-md-8 col-12 mx-auto mb-50">
                    <h3 class="subtitle text-center mb-4 mt-5 mt-lg-0">{{ __('Signup') }}</h3>
                    {!! Form::open(array('route' => 'register', 'method' => 'POST')) !!}
                    @csrf
                    @isset($refName)
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{('Referral')}}</span>
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <input type="text" disabled value="{{$refName->name}}">
                    </div>
                    <input type="hidden" value="{{$refName->id}}" name="ref_id">
                    @endisset
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Your Full Name')}}</span>
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <input name="name" id="name" placeholder="Name" type="text" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Email Address')}}</span>
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <input name="email" id="email" placeholder="Email" type="email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Password')}}</span>
                        <span class="icon"><i class="fa fa-key"></i></span>
                        <input name="password" id="password" placeholder="**********" type="password" required autocomplete="new-password" title="{{__('Password should be at least 8 characters')}}">
                    </div>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Retype Password')}}</span>
                        <span class="icon"><i class="fa fa-key"></i></span>
                        <input name="password_confirmation" id="password-confirm" placeholder="**********" type="password" required autocomplete="new-password" title="{{__('Password should be at least 8 characters')}}">
                    </div>
                    @include('partials.custom_captcha')
                    @include('partials.google_recaptcha')
                    <div class="text-center mb-3">
                        <button class="btn btn-base" type="submit">{{__('Sign Up')}}</button>
                    </div>
                    <p class="text-center">{{__('Already have account')}},  <a href="{{route('login')}}">{{__('Login here')}}</a></p>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
