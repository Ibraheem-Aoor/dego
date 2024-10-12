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
    <header class="header fadeInDown animated fixed-top">
        <div class="header-top-section">
            @include(template(). 'sections.header_top')
        </div>

        @php
            $class = "";
                if(url('/') == url()->current() && request()->home_version != 'home_102'){
                  if(last(request()->segments()) == 'home_103' || last(request()->segments()) == 'home_101' || basicControl()->home_style =='home_103' || basicControl()->home_style =='home_101'){
                      $class = "different";
                  }
                }
                if(last(request()->segments()) == 'home_103' || last(request()->segments()) == 'home_101'){
                   $class = "different";
                }
        @endphp


        <nav class="navbar navbar-expand-lg {{$class}}">
            <div class="container position-relative">
                <a class="navbar-brand-adventure navbar-brand logo" href="{{ route('page','/') }}">
                    <img id="sitelogo" src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}"
                         alt="Site Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <i class="fa-light fa-list"></i>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                     aria-labelledby="offcanvasNavbar">
                    <div class="offcanvas-header">
                        <a class="navbar-brand" href="{{ route('page','/') }}"><img class="logo"
                                                                                    src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}"
                                                                                    alt="Site Logo"></a>
                        <button type="button" class="cmn-btn-close btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"><i class="fa-light fa-arrow-right"></i></button>
                    </div>
                    <div class="offcanvas-body align-items-center justify-content-between">
                        {!! renderHeaderMenu(getHeaderMenuData()) !!}
                    </div>
                </div>
                <div class="nav-right">
                    <ul class="custom-nav">
                        @guest
                            @if(Route::currentRouteName() != 'login')
                                <li class="nav-item">
                                    <a class="nav-link cmn-btn" href="{{ route('login') }}">
                                        <i class="login-icon fa-regular fa-right-to-bracket"></i>
                                        <span class="d-none d-md-block">@lang('Login')</span>
                                    </a>
                                </li>
                            @endif
                        @endguest
                        @auth()
                            <li class="nav-item">
                                <div class="profile-box">
                                    <div class="profile">
                                        <img src="{{ getFile(auth()->user()->image_driver,auth()->user()->image ) }}"
                                             class="img-fluid" alt="{{ auth()->user()->firstname . auth()->user()->lastname }}">
                                    </div>
                                    <ul class="user-dropdown">
                                        <li>
                                            <a href="{{ route('user.dashboard') }}"> <i
                                                        class="fal fa-grid"></i> @lang('Dashboard') </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.profile') }}"> <i
                                                        class="fal fa-user"></i> @lang('View Profile') </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.ticket.list') }}"> <i
                                                        class="fal fa-user-headset"></i> @lang('Support') </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fal fa-sign-out-alt"></i> @lang('Sign Out') </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Nav section end -->
    </header>
    @push('script')
        <script>
            var fixed_top = $(".navbar-brand-adventure ");
            $(window).on("scroll", function () {
                if ($(window).scrollTop() > 100) {
                    fixed_top.addClass("show");
                    document.getElementById('sitelogo').src = "{{ getFile(basicControl()->admin_dark_mode_logo_driver, basicControl()->admin_dark_mode_logo) }}"
                } else {
                    document.getElementById('sitelogo').src = "{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}"
                    fixed_top.removeClass("show");
                }
            });
        </script>
    @endpush
@endif
