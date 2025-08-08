<link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/nice-select.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/owl.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/magnific.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/responsive.css')}}">
<link rel="stylesheet" href="{{asset('public/backend/bootoast/toastr.css')}}">

<link rel="stylesheet" href="{{asset('public/frontend/css/frontend_custom.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/custom.css')}}">
<link href="{{asset('public/frontend/css/color.php?color='.$general->color_code)}}" rel="stylesheet">

<script>
    function createCountDown(elementId, sec) {
        var tms = sec;
        var x = setInterval(function() {
            var distance = tms*1000;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById(elementId).innerHTML =days+"D  "+ hours + "h "+ minutes + "m " + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
            }
            tms--;
        }, 1000);
    }
</script>

