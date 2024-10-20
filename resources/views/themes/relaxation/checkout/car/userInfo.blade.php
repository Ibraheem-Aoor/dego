@extends($theme . 'layouts.app')
@section('title', trans('Checkout || Contact Info'))

@section('content')
    @include(template() . 'partials.breadcrumb')
    <section class="checkout-page">
        <div class="container">
            <form class="checkout-form row g-4" id="checkoutForm" action="" method="post">
                @csrf

                <div class="col-lg-8 order-1 order-lg-1">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card checkout-form-card cardFor">
                                <div class="card-header d-flex">
                                    <h3 class="title pb-2"><span
                                            class="numberStyleOne">@lang('1')</span>@lang('Contact Info')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="First-Name" class="form-label">@lang('First Name *')</label>
                                            <input type="text" class="form-control" name="fname"
                                                value="{{ old('fname', $user->firstname) }}" id="First-Name"
                                                placeholder="First Name">
                                            @error('fname')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last-Name" class="form-label">@lang('Last Name *')</label>
                                            <input type="text" class="form-control" name="lname"
                                                value="{{ old('lname', $user->lastname) }}" id="last-Name"
                                                placeholder="Last Name">
                                            @error('lname')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">@lang('Email *')</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $user->email) }}" id="email"
                                                placeholder="user@email.com">
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">@lang('Phone *')</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone', $user->phone) }}" id="phone"
                                                placeholder="Your Phone"
                                                onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                            @error('phone')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Address-Line1" class="form-label">@lang('Address Line 1')</label>
                                            <input type="text" class="form-control" name="address_one"
                                                value="{{ old('address_one', $user->address_one) }}" id="Address-Line1"
                                                placeholder="Your Address Line 1">
                                            @error('address_one')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Address-Line2" class="form-label">@lang('Address Line 2')</label>
                                            <input type="text" class="form-control" name="address_two"
                                                value="{{ old('address_two', $user->address_two) }}" id="Address-Line2"
                                                placeholder="Your Address Line 2">
                                            @error('address_two')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="City" class="form-label">@lang('City')</label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ old('city', $user->city) }}" id="City"
                                                placeholder="Your City">
                                            @error('city')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="State/Province/Region" class="form-label">@lang('State/Province/Region')</label>
                                            <input type="text" class="form-control" name="state"
                                                value="{{ old('state', $user->state) }}" id="State/Province/Region"
                                                placeholder="State/Province/Region">
                                            @error('state')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ZIP-code/Postal-code"
                                                class="form-label">@lang('ZIP code/Postal code')</label>
                                            <input type="text" class="form-control" name="postalCode"
                                                id="ZIP-code/Postal-code"
                                                value="{{ old('postalCode', $user->postal_code) }}"
                                                placeholder="ZIP code/Postal code">
                                            @error('postalCode')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Country" class="form-label">@lang('Country')</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('country', $user->country) }}" id="Country"
                                                name="country" placeholder="Country">
                                            @error('country')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="message" class="form-label">@lang('Message')</label>
                                            <textarea class="form-control" id="message" name="message" rows="5">{{ old('message', $user->message) }}</textarea>
                                            @error('message')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>

                                        <input name="package" value="{{ encrypt($car->id) }}" type="hidden" />

                                        <div class="col-md-12">
                                            <button class="btn-1" id="nextButton" type="submit">@lang('Next')<i
                                                    class="fa-regular fa-arrow-right ps-1"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="paymentDetails d-flex justify-content-between">
                                <p><span class="numberStyleTwo">@lang('3')</span>@lang('Payment Details')</p>
                                <i class="fa-regular fa-chevron-right nextPlayIcon"></i>
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
                                            <img src="{{ getFile($car->thumb_driver, $car->thumb) }}"
                                                alt="{{ $car->title }}">
                                        </div>
                                        <div class="content-area">
                                            <h5 class="title">{{ $car->name }}</h5>
                                            <span class="location"><i
                                                    class="fa-regular fa-car"></i>{{ $car->transmission_type . ', ' . $car->engine_type }}</span>
                                        </div>
                                    </div>
                                    <ul class="cmn-list pt-3">
                                        <li class="item">
                                            <h6>@lang('Doors')</h6>
                                            <h6>{{ $car->doors_count }}</h6>
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
                                                    <span>{{ currencyPosition($car->rent_price * $days_count) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @include(template() . 'sections.footer')
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButton = document.querySelector('.edit-btn');
            const scheduleDiv = document.querySelector('.schedule');
            const dateInput = document.querySelector('.schedule-form input[name="date"]');
            const csrfToken = '{{ csrf_token() }}';

            editButton.addEventListener('click', function(event) {
                event.preventDefault();
                scheduleDiv.classList.toggle('d-none');
            });
            flatpickr('#myID', {
                enableTime: false,
                dateFormat: "Y-m-d",
                mode: "multiple",
                defaultDate:  @json($booking_dates)
            });
            // ToDO
            // On Change => change duration and price using js.
        });
        document.getElementById('nextButton').addEventListener('click', function(e) {
            e.preventDefault();
            let csrfToken = '{{ csrf_token() }}';

            $.ajax({
                url: '{{ route('user.car.checkout.form.payment.form') }}',
                type: 'POST',
                data: $('#checkoutForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(res) {
                    if (res.success === true) {
                        let redirectUrl =
                            '{{ route('user.checkout.get.travel', ['uid' => ':instantUid']) }}';
                        redirectUrl = redirectUrl.replace(':instantUid', res.instant.uid);

                        window.location.href = redirectUrl;
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;

                    $('.invalid-feedback').remove();
                    $('.form-control').removeClass('is-invalid');

                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<span class="invalid-feedback d-block" role="alert"><span>' +
                                errors[field][0] + '</span></span>');

                            input.on('input', function() {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').remove();
                            });
                        }
                    }
                }
            });
        });
    </script>
@endpush
