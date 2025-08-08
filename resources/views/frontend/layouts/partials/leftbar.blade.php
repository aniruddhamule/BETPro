<div class="col-xl-2 col-lg-3 d-lg-block d-none">
    <div class="main-sitebar">
        <div class="dropdown-widget">
            <ul>
                <li class="list-heading"><a href="javascript:void(0)"><img src="{{asset('public/frontend/img/flag/0.png')}}" alt="img"> {{__('Categories')}}</a></li>
                @foreach ($category as $key => $data)
                <li>
                    <a data-bs-toggle="collapse"
                    href="#collapse{{$key+1}}"
                    role="button"
                    aria-expanded="true"
                    aria-controls="collapseExample">
                    <i class="fa fa-{{$data->icon}}" aria-hidden="true"></i> {{__($data->name)}} ({{$data->event()->whereStatus(1)->count()}})
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <div class="collapse" id="collapse{{$key+1}}">
                        <ul>
                            @foreach($data->event()->where('status',1)->get() as $event)
                             <li>
                                <a href="{{route('ui.tournament',[$event->cat->slug,$event->slug])}}">
                                {{$event->name}}</a>
                             </li>
                             @endforeach
                            
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="dropdown-widget">
            <ul>
                <li class="list-heading"><a href="javascript:void(0)"><img src="{{asset('public/frontend/img/flag/0.png')}}" alt="img"> {{__('Tournaments')}}</a></li>
                @foreach ($tournaments as $data)
                    <li><a href="{{route('ui.tournament',[$data->cat->slug,$data->slug])}}"><i class="{{$data->cat->icon}}"></i> {{__($data->name)}}</a></li>
                @endforeach
            </ul>
        </div> 
                               
    </div>
</div>