<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('frontend.layouts.partials.seo')
    <title>{{ __(@$general->web_name) }}</title>
    <link rel="shortcut icon" href="{{ asset('public/images/logo/favicon.png') }}" type="image/png">
    @include('frontend.layouts.partials.style')
    @yield('css')
</head>

<body class="bg-black">

    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.partials.nav')

    @yield('content')

    @include('frontend.layouts.partials.footer')

    @include('frontend.layouts.partials.script')
    @include('frontend.layouts.partials.messages')
    @yield('script')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('change', '#langSel', function() {
            var code = $(this).val();
            window.location.href = "{{ url('/') }}/change-lang/" + code;
        });
    </script>

</body>

</html>
