<div class="inplay-slider-inner-area">
    <div class="inplay-area">
        <h4 class="p-3 pb-2"><img class="mr-3 me-3" src="{{asset('public/frontend/img/icon/2.svg')}}" alt="img">In Play</h4>
        <div class="inplay-slider-inner">
            <div class="inplay-slider owl-carousel">
                @forelse($gameCategories as $data)
                <div class="item">
                    <a class="image-hover-rotate" href="{{route('ui.category', $data->slug)}}">
                        <i class="fa fa-{{$data->icon}}" aria-hidden="true"></i>
                        <p>{{$data->name}}</p>
                    </a>
                </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="row p-3">
            <div class="col-xl-12">
                <ul>
                    <li><a href="{{route('frontend.allLiveMatch')}}">{{__('Live Matches')}}</a></li>
                    <li><a href="{{route('frontend.allUpComMatch')}}">{{__('Upcoming Matches')}}</a></li>
                    <li><a href="{{route('frontend.allFinished')}}">{{__('Finished Matches')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>