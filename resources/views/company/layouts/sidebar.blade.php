<!-- Navbar Vertical -->
<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-vertical-aside-initialized
    {{ in_array(session()->get('themeMode'), [null, 'auto']) ? 'navbar-dark bg-dark ' : 'navbar-light bg-white' }}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('company.dashboard') }}" aria-label="{{ $basicControl->site_title }}">
                <img class="navbar-brand-logo navbar-brand-logo-auto"
                    src="{{ getFile(in_array(session()->get('themeMode'), ['auto', null]) ? $basicControl->admin_dark_mode_logo_driver : $basicControl->admin_logo_driver, in_array(session()->get('themeMode'), ['auto', null]) ? $basicControl->admin_dark_mode_logo : $basicControl->admin_logo, true) }}"
                    alt="{{ $basicControl->site_title }} Logo" data-hs-theme-appearance="default">

                <img class="navbar-brand-logo"
                    src="{{ getFile($basicControl->admin_dark_mode_logo_driver, $basicControl->admin_dark_mode_logo, true) }}"
                    alt="{{ $basicControl->site_title }} Logo" data-hs-theme-appearance="dark">

                <img class="navbar-brand-logo-mini"
                    src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                    alt="{{ $basicControl->site_title }} Logo" data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini"
                    src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}" alt="Logo"
                    data-hs-theme-appearance="dark">
            </a>
            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse">
                </i>
                <i class="bi-arrow-bar-right navbar-toggler-full-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
            </button>
            <!-- End Navbar Vertical Toggle -->


            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['company.dashboard']) }}"
                            href="{{ route('company.dashboard') }}">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">@lang('Dashboard')</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['company.all.destination', 'company.destination.add', 'company.destination.edit*'], 3) }}"
                            href="{{ route('company.all.destination') }}" data-placement="left">
                            <i class="bi-map nav-icon"></i>
                            <span class="nav-link-title">@lang('Destinations')</span>
                        </a>
                    </div>
                    {{-- Manage  Packages --}}
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['company.all.package.category', 'admin.package.category.add', 'admin.package.category.edit', 'admin.all.package', 'admin.package.add', 'admin.package.edit*'], 3) }}"
                            href="#navbarVerticalPackageMenu" role="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarVerticalPackageMenu" aria-expanded="false"
                            aria-controls="navbarVerticalPackageMenu">
                            <i class="bi bi-boxes nav-icon"></i>
                            <span class="nav-link-title">@lang('Manage Package')</span>
                        </a>
                        <div id="navbarVerticalPackageMenu"
                            class="nav-collapse collapse {{ menuActive(['company.all.package.category', 'admin.package.category.add', 'admin.package.category.edit', 'admin.all.package', 'admin.package.add', 'admin.package.edit*'], 2) }}"
                            data-bs-parent="#navbarVerticalPackageMenu">
                            <a class="nav-link d-none {{ menuActive(['company.all.package.category', 'company.package.category.add', 'company.package.category.edit']) }}"
                                href="{{ route('company.all.package.category') }}">@lang('Package Category')</a>

                            <a class="nav-link {{ menuActive(['company.all.package', 'company.package.add', 'company.package.edit*']) }}"
                                href="{{ route('company.all.package') }}">@lang('Packages')</a>
                        </div>
                    </div>
                    {{-- Manage Bookings --}}
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['company.all.booking', 'admin.all.booking.search', 'admin.booking.edit'], 3) }}"
                            href="#navbarVerticalBookingMenu" role="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarVerticalBookingMenu" aria-expanded="false"
                            aria-controls="navbarVerticalBookingMenu">
                            <i class="bi bi-boxes nav-icon"></i>
                            <span class="nav-link-title">@lang('Tour Bookings')</span>
                        </a>
                        <div id="navbarVerticalBookingMenu"
                            class="nav-collapse collapse {{ menuActive(['company.all.booking', 'admin.all.booking.search', 'admin.booking.edit'], 2) }}"
                            data-bs-parent="#navbarVerticalBookingMenu">
                            <a class="nav-link {{ request()->is('admin/all-booking/all') ? 'active' : '' }}"
                                href="{{ route('company.all.booking', ['status' => 'all']) }}">@lang('All Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/pending') ? 'active' : '' }}"
                                href="{{ route('company.all.booking', ['status' => 'pending']) }}">@lang('Pending Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/completed') ? 'active' : '' }}"
                                href="{{ route('company.all.booking', ['status' => 'completed']) }}">@lang('Completed Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/refunded') ? 'active' : '' }}"
                                href="{{ route('company.all.booking', ['status' => 'refunded']) }}">@lang('Refunded Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/expired') ? 'active' : '' }}"
                                href="{{ route('company.all.booking', ['status' => 'expired']) }}">@lang('Expired Tour')</a>
                        </div>
                    </div>
                    {{-- Manage Cars --}}
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['company.car.list' , 'company.car.add', 'company.car.edit'], 3) }}"
                            href="#navbarVerticalCarMenu" role="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarVerticalCarMenu" aria-expanded="false"
                            aria-controls="navbarVerticalCarMenu">
                            <i class="bi bi-boxes nav-icon"></i>
                            <span class="nav-link-title">@lang('Manage Cars')</span>
                        </a>
                        <div id="navbarVerticalCarMenu"
                            class="nav-collapse collapse {{ menuActive(['company.car.list' , 'company.car.add', 'company.car.edit'], 2) }}"
                            data-bs-parent="#navbarVerticalCarMenu">
                            <a class="nav-link {{ menuActive(['company.car.list' , 'company.car.add', 'company.car.edit']) }}"
                                href="{{ route('company.car.list') }}">@lang('All Cars')</a>

                            <a class="nav-link {{ menuActive(['company.all.package', 'company.package.add', 'company.package.edit*']) }}"
                                href="{{ route('company.all.package') }}">@lang('Packages')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</aside>
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/global/css/magnific-popup.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/jquery.magnific-popup.min.js') }}" defer></script>
    <script defer>
        'use strict';
        const baseUrl = "{{ asset('') }}";

        function initializeMagnificPopup(imageSelector1, imageSelector2) {
            document.addEventListener('DOMContentLoaded', function() {
                const selectors = [imageSelector1, imageSelector2];

                selectors.forEach(selector => {
                    $(selector).on('click', function() {
                        let imageData = $(this).data('image');

                        console.log(imageData);

                        let items = Object.keys(imageData).map(function(key) {
                            return {
                                src: baseUrl + imageData[key],
                                type: 'image',
                                title: key
                            };
                        });

                        $.magnificPopup.open({
                            items: items,
                            gallery: {
                                enabled: true
                            },
                            type: 'image',
                            image: {
                                titleSrc: function(item) {
                                    return `<div class="mfp-title-overlay"><h5>${item.title}</h5></div>`;
                                }
                            }
                        });
                    });
                });
            });
        }

        initializeMagnificPopup('.contentImageInside', '.sidebarContentImage');

        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('#navbarVerticalBookingMenu .nav-link');
            navLinks.forEach(link => {
                if (link.classList.contains('active')) {
                    const collapseElement = document.querySelector('#navbarVerticalBookingMenu');
                    if (collapseElement) {
                        new bootstrap.Collapse(collapseElement, {
                            toggle: false
                        });
                        collapseElement.classList.add('show');
                    }
                }
            });
        });
    </script>
@endpush
