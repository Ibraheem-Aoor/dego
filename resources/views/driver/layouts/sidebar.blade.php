<!-- Navbar Vertical -->
<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-vertical-aside-initialized
    {{ in_array(session()->get('themeMode'), [null, 'auto']) ? 'navbar-dark bg-dark ' : 'navbar-light bg-white' }}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            DRIVER DASHBAOR
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ $basicControl->site_title }}">
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
                        <a class="nav-link {{ menuActive(['admin.dashboard']) }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">@lang('Dashboard')</span>
                        </a>
                    </div>
                    {{-- Company Panel --}}
                    <span class="dropdown-header mt-4"> @lang('Company Panel')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>

                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['agent.company.index'], 3) }}"
                            href="#navbarVerticalUserPanelMenu" role="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarVerticalUserPanelMenu" aria-expanded="false"
                            aria-controls="navbarVerticalUserPanelMenu">
                            <i class="bi-people nav-icon"></i>
                            <span class="nav-link-title">@lang('Company Management')</span>
                        </a>
                        <div id="navbarVerticalUserPanelMenu"
                            class="nav-collapse collapse {{ menuActive(['agent.company.index', 'agent.company.add', 'agent.company.edit', 'agent.company.view.profile' , 'agent.company.mail.all'], 2) }}"
                            data-bs-parent="#navbarVerticalUserPanelMenu">

                            <a class="nav-link {{ menuActive(['agent.company.index']) }}"
                                href="{{ route('agent.company.index') }}">
                                @lang('All Companies')
                            </a>

                            <a class="nav-link {{ menuActive(['agent.company.mail.all']) }}"
                                href="{{ route('agent.company.mail.all') }}">@lang('Mail To Companies')</a>
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
