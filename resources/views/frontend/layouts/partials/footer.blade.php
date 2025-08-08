<footer class="footer-area bg-black-3 pd-top-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="widget widget_about">
                    <div class="thumb">
                        <img src="{{ asset('public/images/logo/logo.png') }}" alt="img">
                    </div>
                    <div class="details">
                        <p>{{ __($general->footer_text) }}</p>
                        <ul class="social-media">
                            @foreach ($social as $data)
                                <li>
                                    <a class="{{ $data->icon }}" href="{{ $data->link }}">
                                        <i class="fab fa-{{ $data->icon }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 ps-xl-5">
                <div class="widget widget_nav_menu">
                    <h4 class="widget-title">{{ __('Company Policy') }}</h4>
                    <ul>
                        @foreach ($extra_page as $data)
                            <li><a href="{{ route('frontend.policyIndex', [$data->slug]) }}">{{ __($data->title) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 ps-xl-5">
                <div class="widget widget_nav_menu">
                    <h4 class="widget-title">{{ __('Useful Links') }}</h4>
                    <ul>
                        <li><a href="{{ route('frontend.about.index') }}">{{ __('About Us') }}</a></li>
                        <li><a href="{{ route('frontend.news.index') }}">{{ __('News') }}</a></li>
                        @if ($section_btn->contact_switch == 1)
                            <li><a href="{{ route('frontend.contact.index') }}">{{ __('Contact Us') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-recent-post">
                    <h4 class="widget-title">{{ __('Contact us') }}</h4>
                    <div class="widget widget_contact">
                        <ul class="details">
                            <li>
                                <div class="media">
                                    <div class="media-body">
                                        {{__('Address')}}:
                                        <p class="mt-1 mb-0">{{$general->contact_address}}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <div class="media-body">
                                        {{__('Email')}}:
                                        <p class="mt-1 mb-0">{{$general->contact_email}}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <div class="media-body">
                                        {{__('Call Us')}}:
                                        <p class="mt-1 mb-0">{{$general->contact_phone}}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-bottom text-center">
            <p>{{ $general->copyright_text }}</p>
        </div>
    </div>
</footer>

<div class="back-to-top">
    <span class="back-top"><i class="fa fa-angle-up"></i></span>
</div>
