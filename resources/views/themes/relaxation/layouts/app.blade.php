<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}" name="description">
    <meta content="{{ is_array(@$pageSeo['meta_keywords']) ? implode(', ', @$pageSeo['meta_keywords']) : @$pageSeo['meta_keywords'] }}"
          name="keywords">
    <meta name="theme-color" content="{{ basicControl()->primary_color }}">
    <meta name="author" content="{{basicControl()->site_title}}">
    <meta name="robots" content="{{ isset($pageSeo['meta_robots']) ? $pageSeo['meta_robots'] : '' }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ isset(basicControl()->site_title) ? basicControl()->site_title : '' }}">
    <meta property="og:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta property="og:description" content="{{ isset($pageSeo['og_description']) ? $pageSeo['og_description'] : '' }}">
    <meta property="og:image" content="{{ getFile(@$pageSeo['meta_image_driver'], @$pageSeo['meta_image']) }}">

    <meta name="twitter:card" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:description" content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}">
    <meta name="twitter:image" content="{{ getFile(@$pageSeo['meta_image_driver'], @$pageSeo['meta_image']) }}">

    <meta name="is-authenticated" content="{{ auth()->check() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{basicControl()->site_title}} @if(isset($pageSeo['page_title']))
            | {{str_replace(basicControl()->site_title, ' ',$pageSeo['page_title'])}}
        @else
            | @yield('title')
        @endif</title>

    <link href="{{ getFile(basicControl()->favicon_driver, basicControl()->favicon) }}" rel="icon">


    <link href="{{ asset($themeTrue . 'css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/ion.rangeSlider.min.css') }}">
    <link href="{{ asset($themeTrue . 'css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">

    @include($theme.'partials.preloader')
    @include($theme.'partials.header')
    @include($theme.'partials.search')

    @if(!request()->is('/') && !request()->is('/'))
        @if(isset($pageDetails->page->breadcrumb_image) && optional($pageDetails->page)->breadcrumb_status == 1)
            <section class="common-banner">
                <div class="bg-layer"
                     style="background: url({{getFile($pageDetails->page->breadcrumb_image_driver,$pageDetails->page->breadcrumb_image)}});"></div>
                <div class="common-banner-content">
                    <div class="common-banner-content-inner">
                        <h1>@lang($pageDetails->name)</h1>
                        <div class="common-banner-link">
                            <a href="{{ route('page','/') }}">@lang('Home')</a>
                            <i class="fa-light fa-angle-right"></i>
                            <p>@lang($pageDetails->name)</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @yield('content')
    <div class="prgoress_indicator">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
        <i class="fa-duotone fa-arrow-up"></i>
    </div>
</div>


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<script src="{{ asset($themeTrue.'js/jquery-3.6.1.min.js')}}"></script>
<script src="{{ asset($themeTrue.'js/swiper-bundle.min.js')}}"></script>
<script src="{{ asset($themeTrue.'js/qrjs2.min.js')}}"></script>
<script src="{{ asset($themeTrue.'js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset($themeTrue.'js/jquery.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/bootstrap.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/fancybox.umd.js') }}"></script>
<script src="{{ asset($themeTrue.'js/select2.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/appear.js') }}"></script>
<script src="{{ asset($themeTrue.'js/wow.js') }}"></script>
<script src="{{ asset($themeTrue.'js/owl.js') }}"></script>
<script src="{{ asset($themeTrue.'js/TweenMax.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/odometer.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/swiper.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/parallax-scroll.js') }}"></script>
<script src="{{ asset($themeTrue.'js/jarallax.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/jquery.paroller.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/flatpickr-min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset($themeTrue.'js/socialSharing.js') }}"></script>
<script src="{{ asset($themeTrue.'js/ion.rangeSlider.min.js')}}"></script>
<script src="{{ asset($themeTrue.'js/script.js') }}"></script>


<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@include('partials.notify')

@stack('script')
@stack('style')
@if(basicControl()->cookie_status == 1 && auth()->guard('web'))
    <script>
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + value + expires + "; path=/";
        }

        function hasAcceptedCookiePolicy() {
            return document.cookie.indexOf("cookie_policy_accepted=true") !== -1;
        }

        function acceptCookiePolicy() {
            setCookie("cookie_policy_accepted", "true", 365);
            document.getElementById("cookiesAlert").style.display = "none";
        }

        function closeCookieBanner() {
            document.getElementById("cookiesAlert").style.display = "none";
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (!hasAcceptedCookiePolicy()) {
                document.getElementById("cookiesAlert").style.display = "block";
            }
        });
    </script>

    @include(template().'partials.cookie')
@endif
@include('plugins')
</body>

</html>







