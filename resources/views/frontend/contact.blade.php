@extends('frontend.layouts.master')
@section('content')
<div class="contact-area contact-area-cust bg-navy-2 pd-top-100 pd-bottom-220">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title style-white text-center">
                    <h5 class="sub-title">{{__('Contact Us')}}</h5>
                    <h2 class="title">{{__('Get in Touch')}}</h2>
                </div>
            </div>
        </div>
        <div class="contact-inner contact-inner-cust">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="subtitle mb-4">{{__('Message Send')}}</h4>
                    <form action="{{route('frontend.contact.send')}}" method="POST">
                        @csrf
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Your Full Name')}}</span>
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <input name="name" placeholder="{{__('Jhone smith')}}" type="text">
                        </div>
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Email Address')}}</span>
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                            <input name="email" placeholder="esacexample@gmail.com" type="text">
                        </div>
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Subject')}}</span>
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <input name="subject" type="text">
                        </div>
                        <div class="single-input-inner">
                            <span class="input-group-text">{{__('Message')}}</span>
                            <textarea name="message"></textarea>
                        </div>
                        <button class="btn btn-base mt-3" type="submit">{{__('Send')}} <i class="fas fa-arrow-circle-right ms-2"></i></button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <h4 class="subtitle mb-4 mt-5 mt-lg-0">{{__('Address')}}:</h4>
                    <div class="single-plan-wrap">
                        <div class="thumb">
                            <img src="public/frontend/img/icon/1.png" alt="img">
                        </div>
                        <div class="details">
                            <h4>{{__('Email')}}</h4>
                            <p><a href="mailto:{{$general->contact_email}}">{{$general->contact_email}}</a></p>
                        </div>
                    </div>
                    <div class="single-plan-wrap">
                        <div class="thumb">
                            <img src="public/frontend/img/icon/2.png" alt="img">
                        </div>
                        <div class="details">
                            <h4>{{__('Location')}}</h4>
                            <p>{{$general->contact_address}}</p>
                        </div>
                    </div>
                    <div class="single-plan-wrap">
                        <div class="thumb">
                            <img src="public/frontend/img/icon/3.png" alt="img">
                        </div>
                        <div class="details">
                            <h4>{{__('Phone')}}</h4>
                            <p><a href="tel:{{$general->contact_phone}}"> {{$general->contact_phone}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection