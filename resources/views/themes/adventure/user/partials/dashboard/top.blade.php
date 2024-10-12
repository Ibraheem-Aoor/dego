
<!-- Tab mobile view carousel start -->
<div class="tab-mobile-view-carousel-section mb-30 d-lg-none">
    <div class="row">
        <div class="col-12">
            <div class="owl-carousel owl-theme carousel-1">
                <div class="item">
                    <div class="box-card">
                        <div class="box-card-header">
                            <h5 class="box-card-title">
                                <i class="fa-light fa-calendar-days"></i>
                                @lang('Total Booked Tour')
                            </h5>
                        </div>
                        <div class="box-card-body">
                            <h4 class="mb-0">{{ $totalBooking ?? 0 }}</h4>
                            <div class="statistics">
                                <div class="time">@lang('All Time')</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box-card vivid-orange-card">
                        <div class="box-card-header">
                            <h5 class="box-card-title">
                                <i class="fa-light fa-money-bill"></i>
                                @lang('Total Transaction')
                            </h5>
                        </div>
                        <div class="box-card-body">
                            <h4 class="mb-0">{{ $totalTransaction ?? 0 }}</h4>
                            <div class="statistics">
                                <div class="time">@lang('All Time')</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box-card light-blue-card">
                        <div class="box-card-header">
                            <h5 class="box-card-title">
                                <i class="fa-light fa-presentation-screen"></i>
                                @lang('Total Support Ticket')
                            </h5>
                        </div>
                        <div class="box-card-body">
                            <h4 class="mb-0">{{ $totalTicket ?? 0 }}</h4>
                            <div class="statistics">
                                <div class="time">@lang('All Time')</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box-card lime-green-card">
                        <div class="box-card-header">
                            <h5 class="box-card-title"><i class="fa-light fa-wallet"></i>
                                @lang('Total Paid Amount')
                            </h5>
                        </div>
                        <div class="box-card-body">
                            <h4 class="mb-0">{{ currencyPosition($totalBookingPrice) }}</h4>
                            <div class="statistics">
                                <div class="time">@lang('All Time')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tab mobile view carousel end -->

<!-- Dashboard card start -->
<div class="col-12 d-none d-lg-block">
    <div class="row g-4">
        <div class="col-xxl-3 col-sm-6">
            <div class="box-card">
                <div class="box-card-header">
                    <h5 class="box-card-title">
                        <i class="fa-light fa-calendar-days"></i>
                        @lang('Total Booked Tour')
                    </h5>
                </div>
                <div class="box-card-body">
                    <h4 class="mb-0">{{ $totalBooking ?? 0 }}</h4>
                    <div class="statistics">
                        <div class="time">@lang('All Time')</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="box-card vivid-orange-card">
                <div class="box-card-header">
                    <h5 class="box-card-title">
                        <i class="fa-light fa-money-bill"></i>
                        @lang('Total Transaction')
                    </h5>
                </div>
                <div class="box-card-body">
                    <h4 class="mb-0">{{ $totalTransaction ?? 0 }}</h4>
                    <div class="statistics">
                        <div class="time">@lang('All Time')</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="box-card light-blue-card">
                <div class="box-card-header">
                    <h5 class="box-card-title">
                        <i class="fa-light fa-presentation-screen"></i>
                        @lang('Total Support Ticket')
                    </h5>
                </div>
                <div class="box-card-body">
                    <h4 class="mb-0">{{ $totalTicket ?? 0 }}</h4>
                    <div class="statistics">
                        <div class="time">@lang('All Time')</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="box-card lime-green-card">
                <div class="box-card-header">
                    <h5 class="box-card-title"><i class="fa-light fa-wallet"></i>
                        @lang('Total Paid Amount')
                    </h5>
                </div>
                <div class="box-card-body">
                    <h4 class="mb-0">{{ currencyPosition($totalBookingPrice) }}</h4>
                    <div class="statistics">
                        <div class="time">@lang('All Time')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard card start -->

