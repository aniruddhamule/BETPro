{{-- 
@if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies && $general->cookie_status == 1)

    <div id="bandeau_cookie" class=" alert alert-secondary alert-dismissible fade show js-cookie-consent cookie-consent text-center" role="alert">
        <div class="row">
            <div class="col-md-12 col-xs-12 cookie_spacer">
                <span class="cookie_text"><strong> {!! trans($general->cookie_description) !!}</strong> </span>
            </div>
        </div>
        <div class="col-md-12 col-xs-12 container_cookie-btn">
            <button id="acceptCookies" class="js-cookie-consent-agree cookie-consent__agree btn1 btn-outline-success btn--sm">
                {{ trans('Agree') }}
            </button>
            <button id="personnalize_my_cookie" class="btn1 btn-outline-danger btn--sm" data-bs-dismiss="alert">
                {{ trans('Decline') }}
            </button>
        </div>
    </div>

    <script>

        window.laravelCookieConsent = (function () {

            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');

                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/{{ config('session.secure') ? ';secure' : null }}'
                    + '{{ config('session.same_site') ? ';samesite='.config('session.same_site') : null }}';
            }

            if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            const buttons = document.getElementsByClassName('js-cookie-consent-agree');

            for (let i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif --}}
