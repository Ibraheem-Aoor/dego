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
                            <img src="{{ getFile($object->car->thumb_driver, $object->car->thumb) }}" alt="{{ $object->car->name }}">
                        </div>
                        <div class="content-area">
                            <h5 class="title">{{ $object->car->name }}</h5>
                            <span class="location"><i
                                    class="fa-regular fa-car"></i>{{ $object->car->type }}</span>
                            <span class="location"><i
                                    class="fa-regular fa-cube"></i>{{ $object->car->model }}</span>
                            <span class="location"><i
                                    class="fa-regular fa-users"></i>{{ $object->car->max_passengers }}</span>
                        </div>
                    </div>
                    <ul class="cmn-list pt-3">
                        <li class="item">
                            <h6>@lang('Price')</h6>
                            <h6>{{ currencyPosition($instant->total_price) }}</h6>
                        </li>
                        <li class="item">
                            <h6>@lang('Booking date')</h6>
                            <h6><span class="updated-date">{{ $instant->date }}</span></h6>
                        </li>
                        <div class="item mb-15 schedule d-none">
                            <h6 class="title">@lang('Update Date')</h6>
                            <div class="schedule-form">
                                <input name="date" type="text" id="myID" class="form-control"
                                    value="{{ $instant->date }}" />
                            </div>
                        </div>
                    </ul>
                    <div class="checkout-summary">
                        <div class="widget-title">
                            <h4 class="title discount">@lang('Price Summary')</h4>
                        </div>
                        <div class="cart-total">
                            <ul>
                                <li class="d-flex justify-content-between">
                                    <span>@lang('Total Amount')</span>
                                    <span>{{ currencyPosition($instant->total_price) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
