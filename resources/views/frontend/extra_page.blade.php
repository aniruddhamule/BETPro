@extends('frontend.layouts.master')
@section('content')
<div class="about-area-3 bg-navy-2 pd-top-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-title style-white mb-0 text-center text-lg-start">
                    @isset($policy)
                    <h2 class="title mb-3 pb-2">{{__($policy->title)}}</h2>
                    <p class="mb-4">{{__($policy->description)}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection