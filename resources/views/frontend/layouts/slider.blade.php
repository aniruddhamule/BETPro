<div class="banner-area">
    <div class="banner-slider owl-carousel">
        @foreach ($slider as $data)
        <div class="item">
            <img src="{{asset('public/images/slider/'.$data->image)}}" alt="img">
        </div>
        @endforeach
    </div>
</div>