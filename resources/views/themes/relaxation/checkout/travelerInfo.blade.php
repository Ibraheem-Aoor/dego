@extends($theme.'layouts.app')
@section('title',trans('Checkout || Traveller Info'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="checkout-page">
        <div class="container">
            <div class="checkout-form row g-4">
                <div class="col-lg-8 order-1 order-lg-1">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="contactDetails mt-5">
                                <div class="travelerDetails d-flex justify-content-between">
                                    <p><span class="numberStyleTwo">@lang('1')</span>@lang('Contact Details')</p>
                                    <a class="btn-1" href="{{ route('user.checkout.form', [$package->slug, $instant->uid]) }}">@lang('Edit')</a>
                                </div>
                                <div class="contact-part">
                                    <h5 class="userName">{{ $instant->fname .' '. $instant->lname }}</h5>
                                    <p class="userInformation"><span>@lang('Email: ')</span>{{ $instant->email }}</p>
                                    <p class="userInformation"><span>@lang('Phone: ')</span>{{ $instant->phone }}</p>
                                </div>
                            </div>
                            <form class="checkout-form row g-4" id="checkoutForm" action="{{ route('user.checkout.form.travelers.payment') }}"
                                  method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="card checkout-form-card">
                                    <div class="card-header d-flex">
                                        <h3 class="title pb-2" ><span class="numberStyleOne">@lang('2')</span>@lang('Travelers Information')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-4">
                                            @php
                                                $adultInfo = $instant->adult_info;
                                                $childInfo = $instant->child_info;
                                                $infantInfo = $instant->infant_info;
                                            @endphp
                                            @if($instant->total_adult != 0)
                                                @for($i = 0; $i < $instant->total_adult; $i++)
                                                    {!! renderTravellerFields($adultInfo, 'adult', $i, $errors) !!}
                                                @endfor
                                            @endif

                                            @if($instant->total_children != 0)
                                                @for($i = 0; $i < $instant->total_children; $i++)
                                                    {!! renderTravellerFields($childInfo, 'child', $i, $errors) !!}
                                                @endfor
                                            @endif

                                            @if($instant->total_infant != 0)
                                                @for($i = 0; $i < $instant->total_infant; $i++)
                                                    {!! renderTravellerFields($infantInfo, 'infant', $i, $errors) !!}
                                                @endfor
                                            @endif

                                            <input name="booking" value="{{ $instant->id }}" type="hidden"/>
                                            <input name="package" value="{{ $package->slug }}" type="hidden"/>
                                            <input name="seo" value="{{ $pageSeo->id }}" type="hidden"/>

                                            <div class="col-md-12">
                                                <button class="btn-1" id="nextButton" type="submit">@lang('Next')<i class="fa-regular fa-arrow-right ps-1"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                            <img src="{{ getFile($package->thumb_driver, $package->thumb) }}" alt="{{ $package->title }}">
                                        </div>
                                        <div class="content-area">
                                            <h5 class="title">{{ $package->title }}</h5>
                                            <span class="location"><i class="fa-regular fa-location-dot"></i>{{ optional($package->cityTake)->name.', '. optional($package->stateTake)->name.', '.$package->countryTake->name }}</span>
                                        </div>
                                    </div>
                                    <ul class="cmn-list pt-3">
                                        <li class="item">
                                            <h6>@lang('Tour type')</h6>
                                            <h6>{{ optional($package->category)->name }}</h6>
                                        </li>
                                        <li class="item">
                                            <h6>@lang('Departure date')</h6>
                                            <h6><span class="updated-date">{{ dateTime($instant->date) }}</span> <a href="#" class="edit-btn"><i class="fa-regular fa-edit"></i></a></h6>
                                        </li>
                                        <div class="item mb-15 schedule d-none">
                                            <h6 class="title">@lang('Update Date')</h6>
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
            </div>
        </div>
    </section>

    @include(template().'sections.footer')
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <style>
        .checkout-form{
            margin: 0 0;
        }
        .checkout-page .card{
            padding: 0;
        }
        .sidePartials{
            margin-top: 50px !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script>
        const today = new Date().toISOString().split('T')[0];
        flatpickr('.flatpickr', {
            enableTime: false,
            dateFormat: "Y-m-d",
            maxDate: 'today',
            disableMobile: "true"
        });

        document.addEventListener("DOMContentLoaded", function() {
            const editButton = document.querySelector('.edit-btn');
            const scheduleDiv = document.querySelector('.schedule');
            const dateInput = document.querySelector('.schedule-form input[name="date"]');
            const csrfToken = '{{ csrf_token() }}';

            editButton.addEventListener('click', function (event) {
                event.preventDefault();
                scheduleDiv.classList.toggle('d-none');
            });

            flatpickr(dateInput, {
                enableTime: false,
                dateFormat: 'Y-m-d',
                minDate: 'today',
                onClose: function (selectedDates, dateStr) {
                    $.ajax({
                        url: '{{ route("user.date.update") }}',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': csrfToken},
                        data: {
                            id: "{{ $instant->id }}",
                            date: dateStr
                        },
                        success: function (response) {
                            document.querySelector('.updated-date').textContent = dateStr;
                            const url = new URL(window.location.href);
                            url.searchParams.set('date', dateStr);
                            history.pushState({}, '', url.toString());
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                url: '{{ route("user.checkout.form.travelers.payment") }}',
                type: 'POST',
                data: $(this).serialize(),
                headers: {'X-CSRF-TOKEN': csrfToken},
                success: function (res) {
                    console.log(res)
                    if (res.success === true) {
                        let redirectUrl = '{{ route("user.checkout.payment.form", ["uid" => ":instantUid"]) }}';
                        redirectUrl = redirectUrl.replace(':instantUid', res.instant.uid);

                        window.location.href = redirectUrl;
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    function displayErrors(errors) {
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const errorMessages = errors[key];

                                const errorSpanId = `.error_${key.replace('.', '_')}`;
                                const errorSpan = document.querySelector(errorSpanId);

                                if (errorSpan) {
                                    errorSpan.textContent = errorMessages.join(', ');
                                }

                                const errorKey = key.replace(/\.(\d+)/, '[$1]');
                                const inputField = document.querySelector(`[name="${errorKey}"]`);
                                if (inputField) {
                                    inputField.addEventListener('input', function() {
                                        if (inputField.value.trim() !== '') {
                                            errorSpan.textContent = '';
                                        }
                                    });
                                }
                            }
                        }
                    }
                    displayErrors(errors);
                }
            });
        });
    </script>
@endpush
