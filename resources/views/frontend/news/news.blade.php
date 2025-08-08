@extends('frontend.layouts.master')
@section('content')
<div class="blog-area blog-area-cust bg-navy-2 pd-top-120 pd-bottom-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-11">
                <div class="section-title style-white text-center">
                    <h2 class="title">{{__('LATEST NEWS')}}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($news as $data)
            <div class="col-lg-4 col-md-6">
                <div class="single-blog-inner-2">
                    <div class="thumb">
                        <img src="{{asset('public/images/blog/'.$data->image)}}" alt="img">
                    </div>
                    <div class="details">
                        <h5><a href="{{route('frontend.newsDetails',[$data->slug, $data->id])}}">{{__($data->title)}}</a></h5>
                        <ul class="meta">
                            <li class="user"><i class="far fa-user"></i> {{__('Admin')}}</li>
                            <li class="date"><i class="far fa-clock"></i> {{$data->created_at->diffForHumans()}}</li>
                        </ul>
                        <p class="content">{{ __(short_text($data->description, 10)) }}</p>
                        <a class="read-more-text" href="{{route('frontend.newsDetails',[$data->slug, $data->id])}}">{{__('Read More')}} <i class="fa fa-angle-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="row justify-content-center">
                <div class="pagination flex-wrap pagination-rounded-flat pagination-success">
                    {{$news->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection