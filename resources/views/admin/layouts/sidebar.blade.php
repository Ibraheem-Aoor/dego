<!-- Navbar Vertical -->
<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-vertical-aside-initialized
    {{in_array(session()->get('themeMode'), [null, 'auto'] )?  'navbar-dark bg-dark ' : 'navbar-light bg-white'}}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ $basicControl->site_title }}">
                <img class="navbar-brand-logo navbar-brand-logo-auto"
                     src="{{ getFile(in_array(session()->get('themeMode'),['auto',null])?$basicControl->admin_dark_mode_logo_driver : $basicControl->admin_logo_driver, in_array(session()->get('themeMode'),['auto',null])?$basicControl->admin_dark_mode_logo:$basicControl->admin_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">

                <img class="navbar-brand-logo"
                     src="{{ getFile($basicControl->admin_dark_mode_logo_driver, $basicControl->admin_dark_mode_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="dark">

                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="Logo"
                     data-hs-theme-appearance="dark">
            </a>
            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                   data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                   data-bs-toggle="tooltip"
                   data-bs-placement="right"
                   title="Collapse">
                </i>
                <i
                    class="bi-arrow-bar-right navbar-toggler-full-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Expand"
                ></i>
            </button>
            <!-- End Navbar Vertical Toggle -->


            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.dashboard']) }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">@lang("Dashboard")</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.all.destination', 'admin.destination.add','admin.destination.edit*'], 3) }}"
                           href="{{ route('admin.all.destination') }}" data-placement="left">
                            <i class="bi-map nav-icon"></i>
                            <span class="nav-link-title">@lang('Destinations')</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.all.package.category', 'admin.package.category.add','admin.package.category.edit', 'admin.all.package', 'admin.package.add','admin.package.edit*'], 3) }}"
                           href="#navbarVerticalPackageMenu"
                           role="button" data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalPackageMenu" aria-expanded="false"
                           aria-controls="navbarVerticalPackageMenu">
                            <i class="bi bi-boxes nav-icon"></i>
                            <span class="nav-link-title">@lang('Manage Package')</span>
                        </a>
                        <div id="navbarVerticalPackageMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.all.package.category', 'admin.package.category.add','admin.package.category.edit', 'admin.all.package', 'admin.package.add','admin.package.edit*'], 2) }}"
                             data-bs-parent="#navbarVerticalPackageMenu">
                            <a class="nav-link {{ menuActive(['admin.all.package.category', 'admin.package.category.add','admin.package.category.edit']) }}"
                               href="{{ route('admin.all.package.category') }}">@lang('Package Category')</a>

                            <a class="nav-link {{ menuActive(['admin.all.package', 'admin.package.add','admin.package.edit*']) }}"
                               href="{{ route('admin.all.package') }}">@lang('Packages')</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.all.booking','admin.all.booking.search','admin.booking.edit'], 3) }}"
                           href="#navbarVerticalBookingMenu"
                           role="button" data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalBookingMenu" aria-expanded="false"
                           aria-controls="navbarVerticalBookingMenu">
                            <i class="bi bi-boxes nav-icon"></i>
                            <span class="nav-link-title">@lang('Tour Bookings')</span>
                        </a>
                        <div id="navbarVerticalBookingMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.all.booking','admin.all.booking.search','admin.booking.edit'], 2) }}"
                             data-bs-parent="#navbarVerticalBookingMenu">
                            <a class="nav-link {{ request()->is('admin/all-booking/all') ? 'active' : '' }}"
                               href="{{ route('admin.all.booking', ['status' => 'all']) }}">@lang('All Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/pending') ? 'active' : '' }}"
                               href="{{ route('admin.all.booking', ['status' => 'pending']) }}">@lang('Pending Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/completed') ? 'active' : '' }}"
                               href="{{ route('admin.all.booking', ['status' => 'completed']) }}">@lang('Completed Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/refunded') ? 'active' : '' }}"
                               href="{{ route('admin.all.booking', ['status' => 'refunded']) }}">@lang('Refunded Tour')</a>

                            <a class="nav-link {{ request()->is('admin/all-booking/expired') ? 'active' : '' }}"
                               href="{{ route('admin.all.booking', ['status' => 'expired']) }}">@lang('Expired Tour')</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.all.coupon','admin.coupon.add','admin.coupon.edit*'], 3) }}"
                           href="{{ route('admin.all.coupon') }}" data-placement="left">
                            <i class="fa-light fa-ticket nav-icon"></i>
                            <span class="nav-link-title">@lang('Coupon')</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.review.list'], 3) }}"
                           href="{{ route('admin.review.list') }}" data-placement="left">
                            <i class="bi bi-emoji-smile nav-icon"></i>
                            <span class="nav-link-title">@lang('Review')</span>
                        </a>
                    </div>


                    <span class="dropdown-header mt-4">@lang('All Transactions')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.transaction']) }}"
                           href="{{ route('admin.transaction') }}" data-placement="left">
                            <i class="bi bi-send nav-icon"></i>
                            <span class="nav-link-title">@lang("Transaction List")</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.payment.log']) }}"
                           href="{{ route('admin.payment.log') }}" data-placement="left">
                            <i class="bi bi-credit-card-2-front nav-icon"></i>
                            <span class="nav-link-title">@lang("Payment Log")</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.payment.pending']) }}"
                           href="{{ route('admin.payment.pending') }}" data-placement="left">
                            <i class="bi bi-cash nav-icon"></i>
                            <span class="nav-link-title">@lang("Payment Request")</span>
                        </a>
                    </div>

                    <span class="dropdown-header mt-4"> @lang("Support Ticket Panel ")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.ticket', 'admin.ticket.search', 'admin.ticket.view'], 3) }}"
                           href="#navbarVerticalTicketMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalTicketMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalTicketMenu">
                            <i class="fa-light fa-headset nav-icon"></i>
                            <span class="nav-link-title">@lang("Support Ticket ")</span>
                        </a>
                        <div id="navbarVerticalTicketMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.ticket','admin.ticket.search', 'admin.ticket.view'], 2) }}"
                             data-bs-parent="#navbarVerticalTicketMenu">
                            <a class="nav-link {{ request()->is('admin/tickets/all') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'all') }}">@lang("All Tickets")
                            </a>
                            <a class="nav-link {{ request()->is('admin/tickets/answered') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'answered') }}">@lang("Answered Ticket")</a>
                            <a class="nav-link {{ request()->is('admin/tickets/replied') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'replied') }}">@lang("Replied Ticket")</a>
                            <a class="nav-link {{ request()->is('admin/tickets/closed') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'closed') }}">@lang("Closed Ticket")</a>
                        </div>
                    </div>


                    <span class="dropdown-header mt-4"> @lang('Kyc Management')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.kyc.form.list','admin.kyc.edit','admin.kyc.create']) }}"
                           href="{{ route('admin.kyc.form.list') }}" data-placement="left">
                            <i class="bi-stickies nav-icon"></i>
                            <span class="nav-link-title">@lang('KYC Setting')</span>
                        </a>
                    </div>

                    <div class="nav-item" {{ menuActive(['admin.kyc.list*','admin.kyc.view'], 3) }}>
                        <a class="nav-link dropdown-toggle collapsed" href="#navbarVerticalKycRequestMenu"
                           role="button"
                           data-bs-toggle="collapse" data-bs-target="#navbarVerticalKycRequestMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalKycRequestMenu">
                            <i class="bi bi-person-lines-fill nav-icon"></i>
                            <span class="nav-link-title">@lang("KYC Request")</span>
                        </a>
                        <div id="navbarVerticalKycRequestMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.kyc.list*','admin.kyc.view'], 2) }}"
                             data-bs-parent="#navbarVerticalKycRequestMenu">

                            <a class="nav-link {{ Request::is('admin/kyc/pending') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'pending') }}">
                                @lang('Pending KYC')
                            </a>
                            <a class="nav-link {{ Request::is('admin/kyc/approve') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'approve') }}">
                                @lang('Approved KYC')
                            </a>
                            <a class="nav-link {{ Request::is('admin/kyc/rejected') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'rejected') }}">
                                @lang('Rejected KYC')
                            </a>
                        </div>
                    </div>

                    {{-- User Panel --}}
                    <span class="dropdown-header mt-4"> @lang("User Panel")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>

                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.users'], 3) }}"
                           href="#navbarVerticalUserPanelMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalUserPanelMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalUserPanelMenu">
                            <i class="bi-people nav-icon"></i>
                            <span class="nav-link-title">@lang('User Management')</span>
                        </a>
                        <div id="navbarVerticalUserPanelMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.mail.all.user','admin.users','admin.users.add','admin.user.edit',
                                                                        'admin.user.view.profile','admin.user.transaction','admin.user.payment',
                                                                        'admin.user.payout','admin.user.kyc.list','admin.send.email'], 2) }}"
                             data-bs-parent="#navbarVerticalUserPanelMenu">

                            <a class="nav-link {{ menuActive(['admin.users']) }}" href="{{ route('admin.users') }}">
                                @lang('All User')
                            </a>

                            <a class="nav-link {{ menuActive(['admin.mail.all.user']) }}"
                               href="{{ route("admin.mail.all.user") }}">@lang('Mail To Users')</a>
                        </div>
                    </div>
                    {{-- Agent Panel --}}
                    <span class="dropdown-header mt-4"> @lang("Agent Panel")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>

                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.agents.index'], 3) }}"
                           href="#navbarVerticalAgentPanelMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalAgentPanelMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalAgentPanelMenu">
                            <i class="bi-people nav-icon"></i>
                            <span class="nav-link-title">@lang('Agent Management')</span>
                        </a>
                        <div id="navbarVerticalAgentPanelMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.agents.index','admin.agents.add','admin.agents.edit',
                                                                        'admin.agents.view.profile',
                                                                        ], 2) }}"
                             data-bs-parent="#navbarVerticalAgentPanelMenu">

                            <a class="nav-link {{ menuActive(['admin.agents.index']) }}" href="{{ route('admin.agents.index') }}">
                                @lang('All Agents')
                            </a>

                            <a class="nav-link {{ menuActive(['admin.mail.all.user']) }}"
                               href="{{ route("admin.mail.all.user") }}">@lang('Mail To Agents')</a>
                        </div>
                    </div>

                    <span class="dropdown-header mt-4">@lang("Others Settings")</span>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.subscriber.list']) }}"
                           href="{{ route('admin.subscriber.list') }}"><i class="fas fa-users nav-icon"></i>@lang('Subscriber List')</a>

                        <a class="nav-link {{ menuActive(['admin.all.country','admin.country.add','admin.country.edit*','admin.country.all.state','admin.country.state.edit*','admin.country.add.state','admin.country.state.add.city','admin.country.state.city.edit*','admin.country.state.all.city']) }}"
                           href="{{ route('admin.all.country') }}"><i class="fas fa-flag nav-icon"></i>@lang('Countries')</a>
                    </div>

                    <span class="dropdown-header mt-4"> @lang('SETTINGS PANEL')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>


                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(controlPanelRoutes()) }}"
                           href="{{ route('admin.settings') }}" data-placement="left">
                            <i class="bi bi-gear nav-icon"></i>
                            <span class="nav-link-title">@lang('Control Panel')</span>
                        </a>
                    </div>


                    <div
                        class="nav-item {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods', 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit'], 3) }}">
                        <a class="nav-link dropdown-toggle"
                           href="#navbarVerticalGatewayMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalGatewayMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalGatewayMenu">
                            <i class="bi-briefcase nav-icon"></i>
                            <span class="nav-link-title">@lang('Payment Setting')</span>
                        </a>
                        <div id="navbarVerticalGatewayMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods', 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit'], 2) }}"
                             data-bs-parent="#navbarVerticalGatewayMenu">

                            <a class="nav-link {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods',]) }}"
                               href="{{ route('admin.payment.methods') }}">@lang('Payment Gateway')</a>

                            <a class="nav-link {{ menuActive([ 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit']) }}"
                               href="{{ route('admin.deposit.manual.index') }}">@lang('Manual Gateway')</a>
                        </div>
                    </div>

                    <span class="dropdown-header mt-4">@lang("Themes Settings")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div id="navbarVerticalThemeMenu">

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.template.all']) }}"
                               href="{{ route('admin.template.all') }}"
                               data-placement="left">
                                <i class="fa-light fa-check-square nav-icon"></i>
                                <span class="nav-link-title">@lang('Choose Theme')</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.home.style']) }}"
                               href="{{ route('admin.home.style') }}"
                               data-placement="left">
                                <i class="fa-light fa-house nav-icon"></i>
                                <span class="nav-link-title">@lang('Home Styles')</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.page.index','admin.create.page','admin.edit.page']) }}"
                               href="{{ route('admin.page.index', basicControl()->theme ?? 'relaxation') }}"
                               data-placement="left">
                                <i class="fa-light fa-list nav-icon"></i>
                                <span class="nav-link-title">@lang('Pages')</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.manage.menu']) }}"
                               href="{{ route('admin.manage.menu') }}" data-placement="left">
                                <i class="bi-folder2-open nav-icon"></i>
                                <span class="nav-link-title">@lang('Manage Menu')</span>
                            </a>
                        </div>
                    </div>

                    @php
                        $segments = request()->segments();
                        $last  = end($segments);

                        $contents = config('contents');
                        $filteredContents = [];

                        foreach ($contents as $key => $value) {
                            if (isset($value['theme']) && ($value['theme'] === $basicControl->theme || $value['theme'] === 'all')) {
                                $filteredContents[$key] = $value;
                            }
                        }
                    @endphp
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 3) }}"
                           href="#navbarVerticalContentsMenu"
                           role="button" data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalContentsMenu" aria-expanded="false"
                           aria-controls="navbarVerticalContentsMenu">
                            <i class="fa-light fa-pen nav-icon"></i>
                            <span class="nav-link-title">@lang('Manage Content')</span>
                        </a>
                        <div id="navbarVerticalContentsMenu"
                             class="content-manage nav-collapse collapse {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 2) }} "
                             data-bs-parent="#navbarVerticalContentsMenu">
                            @foreach(array_diff(array_keys($filteredContents), ['message','content_media']) as $name)
                                @php
                                    $contentImage = config('contents.' . $name . '.image');
                                @endphp
                                <div class="contentAll d-flex justify-content-between">
                                    <a class="nav-link contentTitle {{($last == $name) ? 'active' : '' }}"
                                       href="{{ route('admin.manage.content', $name) }}">@lang(stringToTitle(str_replace('relaxation','', $name)))</a>
                                    <button class="btn btn-white btn-sm sidebarContentImage contentImage" data-image="{{ json_encode($contentImage) }}"
                                            data-bs-toggle="tooltip" title="Section Style">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit', 'admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*'], 3) }}"
                           href="#navbarVerticalBlogMenu"
                           role="button" data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalBlogMenu" aria-expanded="false"
                           aria-controls="navbarVerticalBlogMenu">
                            <i class="fa-light fa-newspaper nav-icon"></i>
                            <span class="nav-link-title">@lang('Manage Blog')</span>
                        </a>
                        <div id="navbarVerticalBlogMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit', 'admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*'], 2) }}"
                             data-bs-parent="#navbarVerticalBlogMenu">
                            <a class="nav-link {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit']) }}"
                               href="{{ route('admin.blog-category.index') }}">@lang('Blog Category')</a>

                            <a class="nav-link {{ menuActive(['admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*']) }}"
                               href="{{ route('admin.blogs.index') }}">@lang('Blog')</a>
                        </div>
                    </div>


                    @foreach(collect(config('generalsettings.settings')) as $key => $setting)
                        <div class="nav-item d-none">
                            <a class="nav-link {{ isMenuActive($setting['route']) }}"
                               href="{{ getRoute($setting['route'], $setting['route_segment'] ?? null) }}">
                                <i class="{{$setting['icon']}} nav-icon"></i>
                                <span class="nav-link-title">{{ __(getTitle($key.' '.'Settings')) }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">
                        <li class="navbar-vertical-footer-list-item">
                            <span class="dropdown-header">@lang('Version 1.0')</span>
                        </li>
                        <li class="navbar-vertical-footer-list-item">
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle"
                                        id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        data-bs-dropdown-animation></button>
                                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless"
                                     aria-labelledby="selectThemeDropdown">
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-moon-stars"
                                       data-value="auto">
                                        <i class="bi-moon-stars me-2"></i>
                                        <span class="text-truncate"
                                              title="Auto (system default)">@lang("Default")</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-brightness-high"
                                       data-value="default">
                                        <i class="bi-brightness-high me-2"></i>
                                        <span class="text-truncate"
                                              title="Default (light mode)">@lang("Light Mode")</span>
                                    </a>
                                    <a class="dropdown-item active" href="javascript:void(0)" data-icon="bi-moon"
                                       data-value="dark">
                                        <i class="bi-moon me-2"></i>
                                        <span class="text-truncate" title="Dark">@lang("Dark Mode")</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
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

        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('#navbarVerticalBookingMenu .nav-link');
            navLinks.forEach(link => {
                if (link.classList.contains('active')) {
                    const collapseElement = document.querySelector('#navbarVerticalBookingMenu');
                    if (collapseElement) {
                        new bootstrap.Collapse(collapseElement, { toggle: false });
                        collapseElement.classList.add('show');
                    }
                }
            });
        });
    </script>
@endpush




