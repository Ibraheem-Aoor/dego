<section class="checkout-page">
    <div class="container">
        <div class="checkout-form row g-4">
            <div class="col-lg-8 order-1 order-lg-1">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="contactDetails pt-0 mt-5">
                            <div class="travelerDetails d-flex justify-content-between">
                                <p><span class="numberStyleTwo">@lang('1')</span>@lang('Contact Details')</p>
                                <a class="btn-1" href="{{ route('user.car.checkout.form', ['id' => encrypt($object->id), 'booking_id' => encrypt($instant->id) , 'date' => $date]) }}" id="editUserInfo">@lang('Edit')</a>
                            </div>
                            <div class="contact-part">
                                <h5 class="userName">{{ $instant->fname .' '. $instant->lname }}</h5>
                                <p class="userInformation"><span>@lang('Email: ')</span>{{ $instant->email }}</p>
                                <p class="userInformation"><span>@lang('Phone: ')</span>{{ $instant->phone }}</p>
                            </div>
                        </div>


                        <div class="card paymentCard">
                            <div class="col-12">
                                <form class="row g-4" id="checkoutForm" action="{{ route('user.make.payment') }}"
                                      method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input name="booking" type="text" id="booking" value="{{$instant->id}}" hidden/>

                                    <div class="payment-section">
                                        <div class="card-header d-flex">
                                            <h3 class="title pb-2"><span
                                                    class="numberStyleOne">@lang('3')</span>@lang('Payment Info')</h3>
                                        </div>
                                        <div class="card-body">
                                            <ul class="payment-container-list">
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

                                        <div class="card bookingPayment">
                                            <div class="card-body">
                                                <div class="row g-2">
                                                    <div class="col-md-12">
                                                        <input type="number" class="form-control" name="amount"
                                                               id="amount"
                                                               placeholder="0.00" step="0.0000000001" value="{{ $instant->total_price }}" autocomplete="off" hidden=""/>
                                                    </div>

                                                    <div class="col-md-12 fiat-currency">
                                                        <label class="form-label">@lang("Supported Currency")</label>
                                                        <select class="select2 form-control" name="supported_currency" id="supported_currency">
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
                                                    <div class="form-check ms-3">
                                                        <input class="form-check-input agree-checked" type="checkbox" value=""
                                                               id="Yes, i have confirmed the order!" required>
                                                        <label class="form-check-label" for="Yes, i have confirmed the order!">
                                                            @lang("I agree to the") <a href="{{ route('page','terms-and-conditions') }}" class="link">@lang("terms and conditions.")</a>
                                                        </label>
                                                    </div>
                                                    <div class="payment-btn-group">
                                                        <button type="submit" class="btn-1 rounded-1 confirmBtn">@lang("confirm and continue")
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-2 order-lg-2">
                <div class="booking-submission-section">
                    <div class="sidebar-widget-area">
                        <div class="card sidePartials">
                            <div class="card-header">
                                <h4>@lang('Booking Info')</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-header">
                                    <div class="image-area">
                                        <img src="{{ getFile($object->thumb_driver, $object->thumb) }}"
                                            alt="{{ $object->title }}">
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
                                        <h6><span class="updated-date">{{ $booking_dates_label }}</span> <a
                                                href="#" class="edit-btn"><i
                                                    class="fa-regular fa-edit"></i></a></h6>
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
        </div>
    </div>
</section>

@push('style')
    <style>
        .content-area .title {
            line-height: 21px !important;
        }
        .payment-btn-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .travellersDetailsButton{
            text-decoration: none;
        }
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

            if (collapseElement && chevronIcon) {
                collapseElement.addEventListener('shown.bs.collapse', function () {
                    chevronIcon.classList.remove('fa-chevron-down');
                    chevronIcon.classList.add('fa-chevron-up');
                });

                collapseElement.addEventListener('hidden.bs.collapse', function () {
                    chevronIcon.classList.remove('fa-chevron-up');
                    chevronIcon.classList.add('fa-chevron-down');
                });
            }
        });
    </script>
@endpush


