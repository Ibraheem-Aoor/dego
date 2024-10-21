<div class="col-lg-4 order-2 order-lg-2">
    <div class="booking-submission-section">
        <div class="sidebar-widget-area">
            <div class="card sidePartials">
                <div class="card-header">
                    <h4>@lang('Car Booking Info')</h4>
                </div>
                <div class="card-body">
                    <div class="section-header">
                        <div class="image-area">
                            <img src="{{ getFile($object->thumb_driver, $object->thumb) }}" alt="{{ $object->title }}">
                        </div>
                        <div class="content-area">
                            <h5 class="title">{{ $object->name }}</h5>
                            <span class="location"><i
                                    class="fa-regular fa-car"></i>{{ $object->transmission_type . ', ' . $object->engine_type }}</span>
                        </div>
                    </div>
                    <ul class="cmn-list pt-3">
                        <li class="item">
                            <h6>@lang('Price')</h6>
                            <h6>{{ currencyPosition($object->rent_price) }}</h6>
                        </li>
                        <li class="item">
                            <h6>@lang('Departure date')</h6>
                            <h6><span class="updated-date">{{ $booking_dates_label }}</span> <a href="#"
                                    class="edit-btn"><i class="fa-regular fa-edit"></i></a></h6>
                        </li>
                        <div class="item mb-15 schedule d-none">
                            <h6 class="title">@lang('Update Date')</h6>
                            <div class="schedule-form">
                                <input name="date" type="text" id="myID" class="form-control"
                                    value="{{ $user->booking_dates }}" />
                            </div>
                        </div>
                        <li class="item">
                            <h6>@lang('Duration')</h6>
                            <h6>{{ $days_count }}</h6>
                        </li>
                    </ul>
                    <div class="checkout-summary">
                        <div class="widget-title">
                            <h4 class="title discount">@lang('Price Summary')</h4>
                        </div>
                        <div class="cart-total">
                            <ul>
                                <li class="d-flex justify-content-between">
                                    <span>@lang('Total Amount')</span>
                                    <span>{{ currencyPosition($object->rent_price * $days_count) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
