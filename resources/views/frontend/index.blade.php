@extends('frontend.layouts.master')
@section('content')

<div class="main-body-area">
    <div class="row">
        @include('frontend.layouts.partials.leftbar')
        <div class="col-xl-8 col-lg-6">
            @include('frontend.layouts.slider')
            @include('frontend.layouts.partials.navbar')
            @include('partials.bet_modal')
        </div>
        @include('frontend.layouts.partials.rightbar')
        
    </div>
</div>

<div class="client-area">
    <div class="container">
        <h3 class="main-title mb-5 text-center">{{__('Our Payment Methods')}}</h3>
        <div class="client-slider owl-carousel">
            @foreach ($gateways as $data)
                <div class="thumb text-center">
                    <img src="{{asset('public/images/gateway/'.$data->image)}}" alt="img">
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection