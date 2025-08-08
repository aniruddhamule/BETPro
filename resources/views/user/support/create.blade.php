@extends('user.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-bottom-200">
    <div class="container-sub">
        <div class="contact-inner">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('ticket.store')}}" method="POST">
                        @csrf
                         <div class="row">
                            <div class="col-lg-6">
                                <div class="single-input-inner style-border">
                                    <span class="input-group-text">{{__('Your Full Name')}}</span>
                                    <span class="icon"><i class="fa fa-user"></i></span>
                                    <input name="name" value="{{@$user->name}}" placeholder="{{('Enter Your Name')}} *" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="single-input-inner style-border">
                                    <span class="input-group-text">{{__('Email Address')}}</span>
                                    <span class="icon"><i class="fa fa-envelope"></i></span>
                                    <input name="email" value="{{@$user->email}}" placeholder="{{__('Enter Your Email')}} *" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Subject')}}</span>
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <input name="subject" value="{{old('subject')}}" placeholder="{{__('Subject')}} *" type="text">
                        </div>
                        <div class="single-input-inner">
                            <span class="input-group-text">{{__('Message')}}</span>
                            <textarea name="comment" placeholder="Message">{{old('message')}}</textarea></textarea>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-base mt-3" type="submit">{{__('Submit')}} <i class="fas fa-arrow-circle-right ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection