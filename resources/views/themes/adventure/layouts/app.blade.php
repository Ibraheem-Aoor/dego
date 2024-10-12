<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@lang(basicControl()->site_title) | @if(isset($pageSeo['page_title']))
            {{$pageSeo['page_title']}}
        @else
            @yield('title')
        @endif
    </title>

    <meta content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}" name="description">
    <meta content="{{ is_array(@$pageSeo['meta_keywords']) ? implode(', ', @$pageSeo['meta_keywords']) : @$pageSeo['meta_keywords'] }}"
        name="keywords">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="{{ basicControl()->primary_color }}">
    <meta name="author" content="Bug Finder">

    <meta name="robots" content="{{ isset($pageSeo['meta_robots']) ? $pageSeo['meta_robots'] : '' }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ isset(basicControl()->site_title) ? basicControl()->site_title : '' }}">
    <meta property="og:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta property="og:description" content="{{ isset($pageSeo['og_description']) ? $pageSeo['og_description'] : '' }}">
    <meta property="og:image" content="{{ getFile(@$pageSeo['meta_image_driver'], @$pageSeo['meta_image']) }}">

    <meta name="twitter:card" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:description"
          content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}">
    <meta name="twitter:image" content="{{ getFile(@$pageSeo['meta_image_driver'], @$pageSeo['meta_image']) }}">

    <meta name="is-authenticated" content="{{ auth()->check() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ getFile(basicControl()->favicon_driver, basicControl()->favicon) }}" rel="icon">

    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/style.css') }}">
</head>
<body>

@include($theme.'partials.header')
@if(!request()->is('/') && !request()->is('/'))
    @if(isset($pageDetails->page->breadcrumb_image) && $pageDetails->page->breadcrumb_status == 1)
        <div class="banner-area"
             style="background-image:linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{getFile($pageDetails->page->breadcrumb_image_driver,$pageDetails->page->breadcrumb_image)}});">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb-area">
                            <h3>@lang($pageDetails->name)</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('page','/') }}">@lang('Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@lang($pageDetails->name)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
<main id="main">
    @yield('content')
</main>


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Jquery_Js_link -->
<script src="{{ asset($themeTrue.'js/jquery-3.6.1.min.js')}}"></script>

<!-- Bootstrap_Js_link -->
<script src="{{ asset($themeTrue.'js/bootstrap.bundle.min.js')}}"></script>
<!-- Owl_carausel_Js_link -->
<script src="{{ asset($themeTrue.'js/owl.carousel.min.js')}}"></script>
<!-- Swiper_Js_link -->
<script src="{{ asset($themeTrue.'js/swiper-bundle.min.js')}}"></script>
<!-- Qr_Js_link -->
<script src="{{ asset($themeTrue.'js/qrjs2.min.js')}}"></script>
<!-- select2_Js_link -->
<script src="{{ asset($themeTrue.'js/select2.min.js')}}"></script>
<!-- Bootstrap Datepicker Js_link -->
<script src="{{ asset($themeTrue.'js/bootstrap-datepicker.min.js')}}"></script>
<!-- intlTelInput Css link -->

<!-- rangeSlider Js link -->
<script src="{{ asset($themeTrue.'js/ion.rangeSlider.min.js')}}"></script>


<!-- Main_Js_link -->
<script src="{{ asset($themeTrue.'js/main.js')}}"></script>


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
<script>
    Notiflix.Loading.standard("{{trans('loading...')}}");
    window.onload = function () {
        Notiflix.Loading.remove();
    };
</script>
</body>

</html>







