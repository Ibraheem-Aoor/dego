<div class="cookies-alert" id="cookiesAlert">
    <img src="{{ getFile(basicControl()->cookie_image_driver,basicControl()->cookie_image ) }}" height="50" width="50"
         alt="{{ basicControl()->site_title }} cookies">
    <h4>@lang(basicControl()->cookie_heading)</h4>
    <span class="d-block">@lang(basicControl()->cookie_description)
        <br>
        <a href="{{ url('/cookie-policy') }}" class="btn">@lang(basicControl()->cookie_button)</a>
    </span>
    <a href="javascript:void(0);" class="mt-3 btn-1 justify-content-center" type="button" onclick="acceptCookiePolicy()">@lang('Accept') <span></span></a>
    <a href="javascript:void(0);" class="mt-2 btn-2" type="button" onclick="closeCookieBanner()">@lang('Close') <span></span></a>
</div>

