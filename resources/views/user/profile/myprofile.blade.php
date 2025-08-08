@extends('user.layouts.master')
@section('content')
<div class="signup-area bg-navy-2 pd-bottom-120">
    <div class="container-sub profile-create-page">
        <div class="contact-inner">
            {!! Form::open(array('route' => 'profile.update', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="row justify-content-center">
                <div class="col-xl-3">
                    <div class="form_input mb-5">
                        <div class="imange_cont">
                        <div class="imageWrapper mb-3">
                            <img class="image profile-img-upload" src="{{$user->image_url}}">
                        </div>
                        </div>
                        <a class="file-upload">
                        <input type="file" name="image" class="file-input mb-3 w-100">{{__('Select File')}}
                        </a>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="row"> 
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Your Full Name')}}</span>
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <input name="name" id="name" type="text" value="{{$user->name}}">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Gender')}}</span>
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <select name="gender" class="form-control">
                                <option {{$user->gender == 1? 'selected':''}} value="1">{{__('Male')}}</option>
                                <option {{$user->gender == 0? 'selected':''}} value="0">{{__('Female')}}</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Email Address')}}</span>
                            <span class="icon"><i class="fa fa-envelope"></i></span>
                            <input disabled name="email" id="email" type="email" value="{{$user->email}}">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Phone Number')}}</span>
                            <span class="icon"><i class="fa fa-phone-alt"></i></span>
                            <input name="mobile" value="{{$user->mobile}}" type="text">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Address')}}</span>
                            <span class="icon"><i class="fa fa-map-marker-alt"></i></span>
                            <input name="address" value="{{$user->address}}" type="text">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Zip Code')}}</span>
                            <span class="icon"><i class="fa fa-map-marker-alt"></i></span>
                            <input name="zip_code" value="{{$user->zip_code}}" type="text">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('City')}}</span>
                            <span class="icon"><i class="fa fa-map-marker-alt"></i></span>
                            <input name="city" value="{{$user->city}}" type="text">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="single-input-inner style-border">
                            <span class="input-group-text">{{__('Country')}}</span>
                            <span class="icon"><i class="fa fa-map-marker-alt"></i></span>
                            <input id="myInput" name="country" value="{{$user->country}}" type="text" autocomplete="off">
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="text-center mb-3">
                            <button class="btn btn-base w-100" type="submit">{{__('Update Profile')}}</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{asset('public/frontend/js/countryWiseCity.js')}}"></script>
@endsection