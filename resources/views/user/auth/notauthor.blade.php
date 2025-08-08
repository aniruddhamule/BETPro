@extends('frontend.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-top-100 pd-bottom-120">
    <div class="container">
        @if (Auth::user()->status != '1')
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center pd-bottom-60">
                    <h2 class="title">{{__('Your account is Deactivated')}}</h2>
                </div>
            </div>
        </div>
        @elseif(Auth::user()->emailv != '0')
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                {!! Form::model(array('route' => 'sendemailver', 'method' => 'POST')) !!}
                    <h4 class="subtitle mb-4">{{__('Please Verify your Email')}}</h4>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Email Address')}}</span>
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <input type="text" readonly placeholder="{{__('Your Email address')}}" value="{{Auth::user()->email}}">
                    </div>
                    <div class="text-center mb-3">
                        <button class="btn btn-base" type="submit">{{__('Send Verification Code')}}</button>
                    </div>
                {!! Form::close() !!}
                </div>
                <div class="col-lg-6">
                {!! Form::model(array('route' => 'emailverify', 'method' => 'POST')) !!}
                    <h4 class="subtitle mb-4">{{__('Verify Code')}}</h4>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Enter Verification Code')}}</span>
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <input type="text" name="code" placeholder="{{__('Your Verification Code')}}" required>
                    </div>
                    {!! Form::model(array('route' => 'sendemailver', 'method' => 'POST')) !!}
                    <div class="text-center mb-3">
                        <button class="btn btn-base" type="submit">{{__('Verify')}}</button>
                    </div>
                    {!! Form::close() !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
        @elseif(Auth::user()->tfver != '0')
        <div class="contact-inner">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                <form action="{{route('go2fa.verify') }}" method="POST">
                    @csrf
                    <h4 class="subtitle mb-4">{{__('Verify Google Authenticator Code')}}</h4>
                    <div class="single-input-inner style-border">
                        <span class="input-group-text">{{__('Enter Google Authenticator Code')}}</span>
                        <span class="icon"><i class="fa fa-envelope"></i></span>
                        <input type="text" name="code" placeholder="{{__('Your Google Authenticator Code')}}" required>
                    </div>
                    <div class="text-center mb-3">
                        <button class="btn btn-base" type="submit">{{__('Verify')}}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection