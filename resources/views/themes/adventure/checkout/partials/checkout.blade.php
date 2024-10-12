<section class="checkout-page">
    <div class="container">
        <div class="checkout-form row g-4">

            <div class="col-lg-8 order-1 order-lg-1">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="contactDetails">
                            <div class="travelerDetails d-flex justify-content-between">
                                <h4><span class="numberStyleTwo">@lang('1')</span>@lang('Contact Details')</h4>
                                <a class="cmn-btn2" href="{{ route('user.checkout.form', [$package->slug,$instant->uid]) }}">@lang('Edit')</a>
                            </div>
                            <div class="contact-part">
                                <h5 class="userName">{{ $instant->fname .' '. $instant->lname }}</h5>
                                <p class="userInformation"><span>@lang('Email: ')</span>{{ $instant->email }}</p>
                                <p class="userInformation"><span>@lang('Phone: ')</span>{{ $instant->phone }}</p>
                            </div>
                        </div>
                        <div class="card checkout-form-card travelersInfo">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="title pb-2">
                                    <span class="numberStyleTwo">@lang('2')</span>
                                    <a class="btn-link" data-bs-toggle="collapse" href="#travelerInfoCollapse" role="button" aria-expanded="false" aria-controls="travelerInfoCollapse">
                                        @lang('Travelers Information')
                                        <i class="fa fa-chevron-down ms-2"></i>
                                    </a>
                                </h4>
                                <a class="cmn-btn2 editButton" href="{{ route('user.checkout.get.travel', [$instant->uid]) }}">@lang('Edit')</a>
                            </div>
                            <div id="travelerInfoCollapse" class="collapse">
                                <div class="card-body">
                                    <div class="row g-4">
                                        @php
                                            $adultInfo = $instant->adult_info;
                                            $childInfo = $instant->child_info;
                                            $infantInfo = $instant->infant_info;
                                        @endphp
                                        @if($instant->total_adult != 0)
                                            @for($i = 0; $i < $instant->total_adult; $i++)
                                                {!! renderDisabledTravellerFields($adultInfo, 'adult', $i) !!}
                                            @endfor
                                        @endif

                                        @if($instant->total_children != 0)
                                            @for($i = 0; $i < $instant->total_children; $i++)
                                                {!! renderDisabledTravellerFields($childInfo, 'child', $i) !!}
                                            @endfor
                                        @endif

                                        @if($instant->total_infant != 0)
                                            @for($i = 0; $i < $instant->total_infant; $i++)
                                                {!! renderDisabledTravellerFields($infantInfo, 'infant', $i) !!}
                                            @endfor
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 pt-3">
                        <form class="row g-4" id="checkoutForm" action="{{ route('user.make.payment') }}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <input name="booking" type="text" id="instant_save" value="{{$instant->id}}" hidden/>

                            <div class="payment-section">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <h4 class="title pb-2 text-center p-0"><span class="numberStyleOne text-center">3</span>@lang('Payment Information')</h4>
                                    </div>
                                    <div class="card-body pt-0">
                                        <ul class="payment-container-list mt-0">
                                            @foreach($gateway as $item)
                                                <li class="item">
                                                    <input class="form-check-input select-payment-method"
                                                           value="{{ $item->id }}" name="gateway_id"
                                                           type="radio"
                                                           id="{{ $item->name }}">
                                                    <label class="form-check-label" for="{{ $item->name }}">
                                                        <div class="image-area">
                                                            <img src="{{ getFile($item->driver, $item->image) }}"
                                                                 alt="{{ $item->name }}">
                                                        </div>
                                                        <div class="content-area">
                                                            <h5>{{ $item->name }}</h5>
                                                            <span>{{ $item->description }}</span>
                                                        </div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="card mb-3 mt-2 bookingPayment">
                                        <div class="card-body">
                                            <div class="row g-2">
                                                <div class="col-md-12">
                                                    <input type="number" class="form-control" name="amount"
                                                           id="amount"
                                                           placeholder="0.00" step="0.0000000001" value="{{ $instant->total_price }}" autocomplete="off" hidden=""/>
                                                </div>

                                                <div class="col-md-12 fiat-currency">
                                                    <label class="form-label">@lang("Supported Currency")</label>
                                                    <select class="cmn-select2 form-control" name="supported_currency" id="supported_currency">
                                                        <option value="" disabled selected>@lang("Select Currency")</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <div class="col-md-12 crypto-currency">

                                                </div>
                                            </div>
                                            <div class="transfer-details-section">
                                                <ul class="transfer-list show-deposit-summery">

                                                </ul>
                                                <div class="form-check ms-3 mt-3">
                                                    <input class="form-check-input agree-checked" type="checkbox" value=""
                                                           id="Yes, i have confirmed the order!" required>
                                                    <label class="form-check-label" for="Yes, i have confirmed the order!">
                                                        @lang("I agree to the") <a href="{{ route('page','terms-of-use') }}" class="link">@lang("terms and conditions.")</a>
                                                    </label>
                                                </div>
                                                <div class="payment-btn-group pt-2">
                                                    <button type="submit" class="cmn-btn rounded-1 confirmBtn">@lang("confirm and continue")
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-2 order-lg-2">
                <div class="booking-submission-section mt-4">
                    <div class="sidebar-widget-area">
                        <div class="widget-title">
                            <h4>@lang('Your booking')</h4>
                        </div>
                        <div class="section-header">
                            <div class="image-area">
                                <img src="{{ getFile($package->thumb_driver, $package->thumb) }}" alt="{{ $package->title }}">
                            </div>
                            <div class="content-area">
                                <h5 class="title">{{ $package->title }}</h5>
                                <span class="location"><i class="fa-regular fa-location-dot"></i>{{ optional($package->cityTake)->name.', '. optional($package->stateTake)->name.', '.optional($package->countryTake)->name }}</span>
                            </div>
                        </div>
                        <ul class="cmn-list">
                            <li class="item">
                                <h6>@lang('Tour type')</h6>
                                <h6>{{optional($package->category)->name }}</h6>
                            </li>
                            <li class="item">
                                <h6>@lang('Departure date')</h6>
                                <h6><span class="updated-date">{{ dateTime($instant->date) }}</span> <a href="#" class="highlight edit-btn"><i class="fa-regular fa-edit"></i></a></h6>
                            </li>
                            <div class="mb-15 schedule d-none">
                                <h6 class="title">@lang('Date')</h6>
                                <div class="schedule-form">
                                    <input name="date" type="text" id="myID" class="form-control" value="{{ $instant->date }}"/>
                                </div>
                            </div>
                            <li class="item">
                                <h6>@lang('Duration')</h6>
                                <h6>{{ $package->duration }}</h6>
                            </li>
                            <li class="item">
                                <h6>@lang('Number of Adult')</h6>
                                <h6>{{ $instant->total_adult }}</h6>
                            </li>
                            <li class="item">
                                <h6>@lang('Number of Children')</h6>
                                <h6>{{ $instant->total_children }}</h6>
                            </li>
                            <li class="item">
                                <h6>@lang('Number of Infant')</h6>
                                <h6>{{ $instant->total_infant }}</h6>
                            </li>
                        </ul>
                        <div class="coupon-code-area">
                            <div class="widget-title">
                                <h4 class="title">@lang('Coupon code')</h4>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="coupon-input" placeholder="Code here"
                                       aria-label="Recipient's username" name="coupon"
                                       aria-describedby="apply-coupon-btn">
                                <a href="#" class="cmn-btn2" id="apply-coupon-btn">@lang('Apply')</a>
                            </div>
                            <span class="discountMessage mx-2"></span>
                        </div>
                        <div class="checkout-summary">
                            <div class="widget-title">
                                <h4 class="title">@lang('Discount Summary')</h4>
                            </div>
                            <div class="cart-total">
                                <ul>
                                    <li class="d-flex justify-content-between">
                                        <span>@lang('Total Amount')</span>
                                        <span>{{ currencyPosition($instant->total_price + $instant->discount_amount) }}</span>
                                    </li>
                                    <hr>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-danger">@lang('Discount')</span>
                                        <span class="text-danger" id="totalDiscount">{{currencyPosition($instant->discount_amount ?? 0)}}</span>
                                    </li>
                                    <hr>
                                    <li class="d-flex justify-content-between">
                                        <span>@lang('Gross Total')</span>
                                        <span class="grossAmountShow" id="grossAmount">{{ currencyPosition($instant->total_gross) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('style')
    <style>
        .btn-link{
            color: black;
            text-decoration: none;
        }
    </style>
@endpush
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let collapseElement = document.getElementById('travelerInfoCollapse');
            let chevronIcon = document.querySelector('a[href="#travelerInfoCollapse"] i');

            collapseElement.addEventListener('shown.bs.collapse', function () {
                chevronIcon.classList.remove('fa-chevron-down');
                chevronIcon.classList.add('fa-chevron-up');
            });

            collapseElement.addEventListener('hidden.bs.collapse', function () {
                chevronIcon.classList.remove('fa-chevron-up');
                chevronIcon.classList.add('fa-chevron-down');
            });
        });
    </script>
@endpush

