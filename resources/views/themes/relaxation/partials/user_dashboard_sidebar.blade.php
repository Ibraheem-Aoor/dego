<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ menuActive(['user.dashboard']) }}" href="{{ route('user.dashboard') }}">
                <i class="fa-regular fa-grid"></i>
                <span class="text-capitalize">@lang('dashboard')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ menuActive(['user.booking.list']) }}" href="{{ route("user.booking.list") }}">
                <i class="fal fa-list"></i>
                <span>@lang('Tour History')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ menuActive(['user.car_booking.list']) }}" href="{{ route("user.car_booking.list") }}">
                <i class="fal fa-list"></i>
                <span>@lang('Car Booking History')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ menuActive(['user.favourite.list']) }}" href="{{ route("user.favourite.list") }}">
                <i class="fal fa-heart"></i>
                <span>@lang('Favourite List')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ menuActive(['user.fund.index']) }}" href="{{ route('user.fund.index') }}">
                <i class="fa-light fa-money-bill"></i>
                <span>@lang('Payment Log')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{ menuActive(['user.ticket.list','user.ticket.create','user.ticket.reply','user.ticket.view']) }}" href="{{ route("user.ticket.list") }}">
                <i class="fal fa-user-headset"></i>
                <span>@lang('Support Ticket')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ menuActive(['user.kyc.settings']) }}" href="{{ route('user.kyc.settings') }}">
                <i class="fa-regular fa-address-card"></i>
                <span class="text-capitalize">@lang('Kyc Verification')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ menuActive(['user.notification.permission.list']) }}" href="{{ route('user.notification.permission.list') }}">
                <i class="fa-regular fa-envelope"></i>
                <span class="text-capitalize">@lang('Notification Permission')</span>
            </a>
        </li>
        <li class="nav-item">
            <div class="nav-link">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa-regular fa-sign-out-alt"></i> @lang('Sign Out') </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</aside>

