@extends('frontend.layouts.master')
@section('content')
<div class="about-area-3 bg-navy-2 pd-top-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-md-6">
                <div class="thumb mb-3 mb-lg-0">
                    <img src="{{asset('public/images/about/about_image.png')}}" alt="img">
                </div>  
            </div>
            <div class="col-lg-6 offset-xl-1 align-self-center">
                <div class="section-title style-white mb-0 text-center text-lg-start">
                    <h2 class="title mb-3 pb-2">{{__($general->about_title)}}</h2>
                    <p class="mb-4">{{__($general->about_description)}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection