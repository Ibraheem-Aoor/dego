<div class="cookies-alert" id="cookiesAlert">
    <img src="{{ getFile(basicControl()->cookie_image_driver,basicControl()->cookie_image ) }}" height="50" width="50"
         alt="{{ basicControl()->site_title }} cookies">
    <h4 class="mt-2">@lang(basicControl()->cookie_heading)</h4>
    <span class="d-block mt-2">@lang(basicControl()->cookie_description)
        <br>
        <a href="{{ url('/cookie-policy') }}" class="link">{{ basicControl()->cookie_button }}</a>
    </span>
    <a href="javascript:void(0);" class="mt-3 cmn-btn justify-content-center" type="button" onclick="acceptCookiePolicy()">@lang('Accept')</a>
    <a href="javascript:void(0);" class="mt-2 cmn-btn3" type="button" onclick="closeCookieBanner()">Close</a>
</div>

