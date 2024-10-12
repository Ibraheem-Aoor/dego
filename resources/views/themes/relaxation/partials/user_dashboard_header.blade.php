<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <div class="logo-container">
            <a href="{{ route('page','/') }}" class="logo d-flex align-items-center">
                <img src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="@lang('Website Logo')">
            </a>
        </div>
        <button onclick="toggleSideMenu()" class="toggle-sidebar-btn d-none d-lg-block"><i class="fa-light fa-list"></i>
        </button>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center">
            <input type="search" class="form-control global-search" name="query" placeholder="@lang('Search')"
                   title="@lang('Enter search keyword')">
            <button class="search-btn" type="button" title="Search"><i
                        class="fa-regular fa-magnifying-glass"></i></button>
            <div class="search-backdrop d-none"></div>
            <div class="search-result d-none">
                <div class="search-header">
                    @lang('Result')
                </div>
                <div class="content"></div>
            </div>
        </form>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item d-none d-lg-block d-xl-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#">
                    <i class="fa-regular fa-magnifying-glass"></i>
                </a>
            </li><!-- End Search Icon-->


            <li class="nav-item dropdown" id="pushNotificationArea">
                <a class="nav-link nav-icon mt-2" href="#" data-bs-toggle="dropdown">
                    <i class="fa-light fa-bell"></i>
                    <span class="badge bg-primary badge-number" v-cloak>@{{ items.length }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notification-dropdown">
                    <ul class="notifications">
                        <li class="dropdown-header" v-if ="items.length > 0">
                            <h6>{{ trans('You have') }} <span
                                    v-cloak>@{{ items.length }}</span> {{ trans('new notifications') }}</h6>
                        </li>

                        <li class="notification-item" v-for="(item, index) in items" :key="index"
                            @click.prevent="readAt(item.id, item.description.link)">
                            <a href="javascript:void(0)">
                                <i class="fa-light fa-bell text-warning"></i>
                                <div>
                                    <p class="text-highlight-dark" v-cloak v-html="item.description.text"></p>
                                    <p v-cloak>@{{ item.formatted_date }}</p>
                                </div>
                            </a>
                        </li>

                        <li v-if="items.length == 0"
                            class="btn-view_notification text-center">@lang('You have no notifications')</li>
                        <hr class="dropdown-divider" v-if="items.length == 0">


                    </ul>
                    <div class="dropdown-footer">
                        <a class="btn-clear" href="javascript:void(0)" v-if="items.length > 0"
                           @click.prevent="readAll">@lang('Clear all notification')</a>
                    </div>
                </div>
            </li>


            <li class="nav-item dropdown">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ getFile(auth()->user()->image_driver, auth()->user()->image) }}" alt="{{ auth()->user()->firstname . ' '.auth()->user()->lastname }}"
                         class="rounded-circle">
                    <span
                        class="d-none d-lg-block dropdown-toggle ps-2">{{ auth()->user()->firstname . ' '.auth()->user()->lastname }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header d-flex justify-content-center text-start">
                        <div class="profile-thum">
                            <img src="{{ getFile(auth()->user()->image_driver, auth()->user()->image) }}" alt="{{ auth()->user()->firstname . ' '.auth()->user()->lastname }}">
                        </div>
                        <div class="profile-content">
                            <h6>{{ auth()->user()->firstname . ' '.auth()->user()->lastname  }}</h6>
                            <span>@lang('@'.auth()->user()->username)</span>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                            <i class="fa-light fa-user"></i>
                            <span>@lang('My Profile')</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('user.twostep.security') }}">
                            <i class="fa-light fa-key"></i>
                            <span>@lang('2FA Verification')</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('page','faqs') }}">
                            <i class="fa-light fa-circle-question"></i>
                            <span>@lang('Need Help?')</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-light fa-right-from-bracket"></i>
                            <span>@lang('Sign Out')</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

</header>

@push('script')
    <script>
        'use strict';
        let pushNotificationArea = new Vue({
            el: "#pushNotificationArea",
            data: {
                items: [],
            },
            beforeMount() {
                this.getNotifications();
                this.pushNewItem();
            },
            methods: {
                getNotifications() {
                    let app = this;
                    axios.get("{{ route('user.push.notification.show') }}")
                        .then(function (res) {
                            app.items = res.data;
                        })
                },
                readAt(id, link) {
                    let app = this;
                    let url = "{{ route('user.push.notification.readAt', 0) }}";
                    url = url.replace(/.$/, id);
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.getNotifications();
                                if (link !== '#') {
                                    window.location.href = link
                                }
                            }
                        })
                },
                readAll() {
                    let app = this;
                    let url = "{{ route('user.push.notification.readAll') }}";
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.items = [];
                            }
                        })
                },
                pushNewItem() {
                    let app = this;
                    Pusher.logToConsole = false;
                    let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                        encrypted: true,
                        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                    });
                    let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                    channel.bind('App\\Events\\UserNotification', function (data) {
                        app.items.unshift(data.message);
                    });
                    channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                        app.getNotifications();
                    });
                }
            }
        });
    </script>
    <script>
        'use strict';
        // for search
        $(document).on('input', '.global-search', function () {
            var search = $(this).val().toLowerCase();
            console.log(search);
            if (search.length == 0) {
                $('.search-result').find('.content').html('');
                $(this).siblings('.search-backdrop').addClass('d-none');
                $(this).siblings('.search-result').addClass('d-none');
                return false;
            }

            $('.search-result').find('.content').html('');
            $(this).siblings('.search-backdrop').removeClass('d-none');
            $(this).siblings('.search-result').removeClass('d-none');

            var match = $('.sidebar-nav li').filter(function (idx, element) {
                if (!$(element).find('a').hasClass('has-dropdown') && !$(element).hasClass('menu-header'))
                    return $(element).text().trim().toLowerCase().indexOf(search) >= 0 ? element : null;
            }).sort();

            if (match.length == 0) {
                $('.search-result').find('.content').append(`<div class="search-item"><a href="javascript:void(0)">@lang('No result found')</a></div>`);
                return false;
            }

            match.each(function (index, element) {
                var item_text = $(element).text().replace(/(\d+)/g, '').trim();
                var item_url = $(element).find('a').attr('href');
                if (item_url != '#') {
                    $('.search-result').find('.content').append(`<div class="search-item"><a href="${item_url}">${item_text}</a></div>`);
                }
            });
        });
    </script>
@endpush
