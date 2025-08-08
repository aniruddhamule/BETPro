@php
	$captcha = customCaptcha();
@endphp
@if($captcha)
<section class="contact_page_section">
        <div class="form_input @if(request()->routeIs('register')) @endif">
            @php echo $captcha @endphp
        </div>
        <div class="form_input @if(request()->routeIs('register')) @endif">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" required>
        </div>
</section>
@endif