<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ getFile(basicControl()->favicon_driver, basicControl()->favicon) }}" rel="icon">


    <title>@lang(basicControl()->site_title) | @if(isset($pageSeo['page_title']))
            @lang($pageSeo['page_title'])
        @else
            @yield('title')
        @endif</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fontawesome.min.css') }}">
    <!-- Bootstrap 5 Css link -->
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/bootstrap.min.css') }}">
    <!-- Owl carousel Css link -->
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/owl.theme.default.min.css') }}">
    <!-- Swiper Css link -->
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/swiper-bundle.min.css') }}">
    <!-- select2 Css link -->
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/select2.min.css') }}">


    <!-- Style Css link -->
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/dashboard.css') }}">
    @stack('style')
</head>
<body onload="preloder_function()" class="">
<ul class="nav bottom-nav fixed-bottom d-lg-none">
    <li class="nav-item">
        <a onclick="toggleSideMenu()" class="nav-link toggle-sidebar {{ Route::currentRouteName() == 'user.sidebar' ? 'active' : '' }}" aria-current="page">
            <i class="fa-light fa-list"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'user.fund.index' ? 'active' : '' }}" href="{{ route('user.fund.index') }}">
            <i class="fa-light fa-planet-ringed"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'user.dashboard' ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
            <i class="fa-regular fa-house"></i>
        </a>
    </li>
    <li class="nav-item">
        <a onclick="searchBar()" class="nav-link search-bar-toggle" href="#">
            <i class="fa-regular fa-magnifying-glass"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'user.ticket.list' ? 'active' : '' }}" href="{{ route('user.ticket.list') }}">
            <i class="fa-light fa-user"></i>
        </a>
    </li>
</ul>

<div class="dashboard-wrapper">
    @include($theme. 'partials.user_dashboard_sidebar')
    <div id="content">
        <div class="overlay">
            @include($theme. 'partials.user_dashboard_header')
            @yield('content')
            @include($theme. 'partials.user_dashboard_footer')
        </div>
    </div>
</div>

<!-- Jquery Js link -->
<script src="{{ asset($themeTrue.'js/jquery-3.6.1.min.js') }}"></script>
<!-- Bootstrap Js link -->
<script src="{{ asset($themeTrue.'js/bootstrap.bundle.min.js') }}"></script>
<!-- select2_Js_link -->
<script src="{{ asset($themeTrue.'js/select2.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<!-- Owl carousel Js link -->
<script src="{{ asset($themeTrue.'js/owl.carousel.min.js') }}"></script>
<!-- Main Js slink -->
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>

<script src="{{ asset($themeTrue.'js/dashboard.js') }}"></script>


@stack('script')

<script>
    const hideSidebar = () => {
        document.getElementById("formWrapper").classList.remove("active");
        document.getElementById("formWrapper2").classList.remove("active");
    };

    // tab
    const tabs = document.getElementsByClassName("tab");
    const contents = document.getElementsByClassName("content");
    for (const element of tabs) {
        const tabId = element.getAttribute("tab-id");
        const content = document.getElementById(tabId);
        element.addEventListener("click", () => {
            for (const t of tabs) {
                t.classList.remove("active");
            }
            for (const c of contents) {
                c.classList.remove("active");
            }
            element.classList.add("active");
            content.classList.add("active");
        });
    }


    Notiflix.Loading.standard("{{trans('loading...')}}");
    window.onload = function() {
        Notiflix.Loading.remove();
    };
</script>
@include('partials.notify')
@include('plugins')
</body>
</html>





