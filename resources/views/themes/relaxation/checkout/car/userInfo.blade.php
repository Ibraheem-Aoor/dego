@extends($theme . 'layouts.app')
@section('title', trans('Checkout || Contact Info'))

@section('content')
    @include(template() . 'partials.breadcrumb')
    <section class="checkout-page">
        <div class="container">
            <form class="checkout-form row g-4" id="checkoutForm" action="{{ route('user.car.checkout.form.store_booking' , ['id' => encrypt($object->id) , 'booking_id' => encrypt($instant->id)]) }}" method="post">
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
                                                value="{{ old('fname', $instant->fname) }}" id="First-Name"
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
                                                value="{{ old('lname', $instant->lname) }}" id="last-Name"
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
                                                value="{{ old('email', $instant->email) }}" id="email"
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
                                                value="{{ old('phone', $instant->phone) }}" id="phone"
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
                                                value="{{ old('address_one', $instant->address_one) }}" id="Address-Line1"
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
                                                value="{{ old('address_two', $instant->address_two) }}" id="Address-Line2"
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
                                                value="{{ old('city', $instant->city) }}" id="City"
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
                                                value="{{ old('state', $instant->state) }}" id="State/Province/Region"
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
                                            <input type="text" class="form-control" name="postal_code"
                                                id="ZIP-code/Postal-code"
                                                value="{{ old('postal_code', $instant->postal_code) }}"
                                                placeholder="ZIP code/Postal code">
                                            @error('postal_code')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Country" class="form-label">@lang('Country')</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('country', $instant->country) }}" id="Country"
                                                name="country" placeholder="Country">
                                            @error('country')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="message" class="form-label">@lang('Message')</label>
                                            <textarea class="form-control" id="message" name="message" rows="5">{{ old('message', $instant->message) }}</textarea>
                                            @error('message')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>

                                        <input name="package" value="{{ encrypt($object->id) }}" type="hidden" />

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
                @include(template().'checkout.car.partials.booking_submission_section')
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
    </script>
@endpush
