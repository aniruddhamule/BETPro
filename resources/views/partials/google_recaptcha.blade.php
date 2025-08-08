@php
	$googleCaptcha = googleRecaptcha();
@endphp
@if($googleCaptcha)
<div class="form_input d-flex justify-content-center">
    <div class="g-recaptcha" data-sitekey="{{$googleCaptcha}}"></div>
</div>
@endif