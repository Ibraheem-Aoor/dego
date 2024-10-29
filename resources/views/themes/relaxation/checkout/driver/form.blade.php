<section class="checkout-page">
    <div class="container">
        <div class="checkout-form row g-4">
            <div class="col-lg-8 order-1 order-lg-1">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="contactDetails pt-0 mt-5 d-none">
                            <div class="travelerDetails d-flex justify-content-between">
                                <p><span class="numberStyleTwo">@lang('1')</span>@lang('Contact Details')</p>
                                <a class="btn-1" href="{{ route('user.driver.checkout.form', ['id' => encrypt($object->id), 'booking_id' => encrypt($instant->id) , 'date' => $instant->date]) }}" id="editUserInfo">@lang('Edit')</a>
                            </div>
                            <div class="contact-part">
                                <h5 class="userName">{{ $instant->fname .' '. $instant->lname }}</h5>
                                <p class="userInformation"><span>@lang('Email: ')</span>{{ $instant->email }}</p>
                                <p class="userInformation"><span>@lang('Phone: ')</span>{{ $instant->phone }}</p>
                            </div>
                        </div>


                        <div class="card paymentCard">
                            <div class="col-12">
                                <form class="row g-4" id="checkoutForm" action="{{ route('user.driver.make.payment') }}"
                                      method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input name="booking" type="text" id="booking" value="{{$instant->id}}" hidden/>

                                    <div class="payment-section">
                                        <div class="card-header d-flex">
                                            <h3 class="title pb-2"><span
                                                    class="numberStyleOne">@lang('2')</span>@lang('Payment Info')</h3>
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
            @include(template().'checkout.driver.partials.booking_submission_section')

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


