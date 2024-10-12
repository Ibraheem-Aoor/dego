@php
    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp
@if (
    !in_array($routeName, [
        'login',
        'register',
        'password.confirm',
        'password.email',
        'password.request',
        'password.reset',
        'user.check',
    ]))
    @php
        $class = "";
        $logo = getFile(basicControl()->logo_driver, basicControl()->logo);

            if(url('/') == url()->current()){
              if(last(request()->segments()) == 'home_201' || basicControl()->home_style =='home_201'){
                $class = "header-style-one";
                 $logo = getFile(basicControl()->logo_driver, basicControl()->logo);
              }
            }
            if(url('/') == url()->current()){
              if(last(request()->segments()) == 'home_202' || basicControl()->home_style =='home_202'){
                $class = "header-style-two";
                $logo = getFile(basicControl()->admin_dark_mode_logo_driver, basicControl()->admin_dark_mode_logo);
              }
            }
            if(last(request()->segments()) == 'home_201' || request()->home_version == 'home_201'){
               $class = "header-style-one";
               $logo = getFile(basicControl()->logo_driver, basicControl()->logo);
            }
            if(last(request()->segments()) == 'home_202' || request()->home_version == 'home_202'){
               $class = "header-style-two";
               $logo = getFile(basicControl()->admin_dark_mode_logo_driver, basicControl()->admin_dark_mode_logo);
            }
    @endphp

    <header class="main-header {{ $class }}">
        <div class="header-lower">
            <div class="custom-container">
                <div class="inner-container d-flex align-items-center justify-content-between">

                    <div class="left-column">
                        <div class="logo-box">
                            <div class="logo"><a href="{{ route('page', '/') }}"><img
                                        src="{{$logo}}"
                                        alt="logo"></a></div>
                        </div>
                    </div>
                    <div class="middle-column d-flex align-items-center">
                        <div class="nav-outer">
                            <div class="dashboardIconDiv float-end d-block d-lg-none pe-1">
                                <a href="{{ route('user.dashboard') }}" ><i class="fa-regular fa-grid dashboardIcon {{ (last(request()->segments()) == 'home_202' || basicControl()->home_style =='home_202' || request()->home_version == 'home_202') ? 'white-icon' : '' }}" ></i>
                                    <span></span></a>
                            </div>
                            <div class="mobile-nav-toggler"><img src="{{ asset($themeTrue.'img/icons/icon-bar.png') }}"
                                                                 alt="icon" class="{{ (last(request()->segments()) == 'home_202' || basicControl()->home_style =='home_202' || request()->home_version == 'home_202') ? 'white-icon' : '' }}"></div>
                            <nav class="main-menu navbar-expand-md navbar-light">
                                <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    {!! renderHeaderMenuTwo(getHeaderMenuData()) !!}
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="right-column d-flex align-items-center">
                        <div class="header-right-inner">
                            <div class="language">
                                <div class="language-icon">
                                    <i class="fa-thin fa-globe"></i>
                                    <ul>
                                        @foreach($language as $item)
                                            <li>
                                            <span>
                                                <a href="{{ route('language', $item->short_name) }}"
                                                   class="language {{ session('lang') == $item->short_name ? 'lang_active' : '' }}">
                                                    <img class="languageIcon"
                                                         src="{{ getFile($item->flag_driver, $item->flag) }}"/>
                                                    <span>{{ $item->name }}</span>
                                                </a>
                                            </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @auth
                                <div class="sign-up">
                                    <div class="sign-up-border"></div>
                                    <div class="button-2">
                                        <a href="{{ route('user.dashboard') }}" class="btn-2">@lang('Dashboard')
                                            <span></span></a>
                                    </div>
                                </div>
                            @endauth
                            @guest
                                <div class="sign-up">
                                    <div class="sign-up-border"></div>
                                    <div class="button-2">
                                        <a href="{{ route('register') }}" class="btn-2">@lang('Sign Up')
                                            <span></span></a>
                                    </div>
                                    <div class="button-1">
                                        <a href="{{ route('login') }}" class="btn-1">@lang('Sign In') <span></span></a>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Lower -->


        <!-- sticky header -->
        <div class="sticky-header">
            <div class="header-upper">
                <div class="container">
                    <div class="inner-container d-flex align-items-center justify-content-between">
                        <div class="left-column d-flex align-items-center">
                            <div class="logo-box">
                                <div class="logo">
                                    <a href="{{ route('page','/') }}">
                                        <img
                                            src="{{$logo}}"
                                            alt="logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="nav-outer">
                            <div class="dashboardIconDiv float-end d-block d-lg-none pe-1">
                                <a href="{{ route('user.dashboard') }}" ><i class="fa-regular fa-grid dashboardIcon {{ (last(request()->segments()) == 'home_202' || basicControl()->home_style =='home_202' || request()->home_version == 'home_202') ? 'white-icon' : '' }}" ></i>
                                    <span></span></a>
                            </div>
                            <div class="mobile-nav-toggler"><img class="{{ (last(request()->segments()) == 'home_202' || basicControl()->home_style =='home_202' || request()->home_version == 'home_202') ? 'white-icon' : '' }}" src="{{ asset($themeTrue.'img/icons/icon-bar.png') }}"
                                                                 alt="icon"></div>
                            <nav class="main-menu navbar-expand-md navbar-light">
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sticky header -->


        <!-- mobile menu -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="fal fa-times"></span></div>
            <nav class="menu-box">
                <div class="nav-logo"><a href="{{ route('page','/') }}"><img
                            src="{{getFile(basicControl()->admin_dark_mode_logo_driver, basicControl()->admin_dark_mode_logo)}}" alt="logo"></a></div>
                <div class="menu-outer">
                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <!--Social Links-->

                <div class="social-links">
                    <ul class="clearfix">
                        <li><a href="{{ @$header_top['single']['twitter'] }}"><span class="fab fa-twitter"></span></a>
                        </li>
                        <li><a href="{{ @$header_top['single']['facebook'] }}"><span
                                    class="fab fa-facebook-square"></span></a>
                        </li>
                        <li><a href="{{ @$header_top['single']['linkedin'] }}"><span class="fab fa-linkedin-in"></span></a>
                        </li>
                        <li><a href="{{ @$header_top['single']['instagram'] }}"><span
                                    class="fab fa-instagram"></span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="nav-overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div>
    </header>

@endif
