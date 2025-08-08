@extends('frontend.layouts.master')
@section('content')
<div class="blog-area blog-details-cus bg-navy-2 pd-top-120 pd-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-details-page-content pb-0">
                    <div class="single-blog-inner">
                        <div class="thumb">
                            <img class="news_fontimg_size" src="{{asset('public/images/blog/'.@$news->image)}}" alt="img">
                        </div>
                        <div class="details">
                            <ul class="blog-meta">
                                <li><i class="fa fa-user"></i> {{__('Admin')}}</li>
                                <li><i class="fa fa-clock"></i>{{@$news->created_at->format('d M Y')}}</li>
                                <li><i class="fa fa-clock"></i>{{@$news->created_at->diffForHumans()}}</li>
                            </ul>
                            <h3 class="title text-white">{{__(@$news->title)}}</h3>
                            <p>{!! __(@$news->description) !!}</p>
                            <div class="blog-share-area">
                                <h4 class="text-white mb-0">{{__('Share post')}}</h4>
                                <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://plus.google.com/share?url={{urlencode(url()->current()) }}" target="_blank"><i class="fab fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-comment">
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1421567158073949";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-comments" data-href="{{ url()->current() }}" data-width="100%" data-numposts="5"></div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="td-sidebar">
                    <div class="widget widget_search">    
                        <form type="get" action="{{ route('search.title') }}" class="search-form">
                            <div class="form-group">
                                <input name="title" type="text" placeholder="{{__('Search')}}">
                            </div>
                            <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div> 
                    <div class="widget widget-recent-post">
                        <h4 class="widget-title">{{__('Recent Post')}}</h4>
                        <ul>
                            @foreach ($recent_post as $data)
                            <li>
                                <div class="media">
                                    <div class="media-left">
                                        <img class="news_img_size" src="{{ asset('public/images/blog/'.$data->image)}}" alt="img">
                                    </div>
                                    <div class="media-body align-self-center">
                                        <h6 class="title"><a href="{{route('frontend.newsDetails',[$data->slug, $data->id])}}">{{$data->title}} </a></h6>
                                        <div class="post-info">{{$data->created_at->format('d M Y')}}</div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    {!! print_advertise('banner', 'small-square', 1) !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection