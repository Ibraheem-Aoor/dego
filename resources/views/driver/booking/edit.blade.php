@extends('admin.layouts.app')
@section('page_title', __('Edit Booking'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Booking Manage')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Booking Edit')</h1>
                    <div class="d-flex justify-content-start align-items-center gap-2">
                        <p class="mb-0">{{ 'Booking Date ' . dateTime($booking->date) . '.' }}</p>
                        @if ($booking->status != 0 && $booking->status != 4 && $booking->status != 2)
                            <a class="refundBtn text-dark" href="javascript:void(0)"
                                data-route="{{ route($base_route.'refund', $booking->id) }}" data-bs-toggle="modal"
                                data-bs-target="#refundModal">
                                <i class="bi bi-arrow-up-circle"></i>
                                @lang('Make it Refund')
                            </a>
                            <a class="actionBtn text-dark" href="javascript:void(0)"
                                data-action="{{ route($base_route.'action', $booking->id) }}" data-bs-toggle="modal"
                                data-bs-target="#Confirm" data-amount="{{ currencyPosition($booking->total_price) }}"
                                data-id="{{ $booking->id }}" data-trx_id = "{{ $booking->trx_id }}"
                                data-paid_date = " {{ dateTime($booking->created_at) }}">
                                <i class="bi bi-check-square"></i>
                                @lang('Make it Completed')
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center w-100">
            <div class="col-lg-3">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header card-header-content-between">
                        <div class="userHeader d-flex justify-content-start align-items-center gap-2">
                            <img class="bookingUserImage"
                                src="{{ getFile($booking->user->image_driver, $booking->user->image) }}">
                            <h4 class="card-header-title">
                                {{ optional($booking->user)->firstname . ' ' . optional($booking->user)->lastname }}</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled list-py-2 text-dark mb-0">
                            <li class="pb-0"><span class="card-subtitle">@lang('About')</span></li>
                            <li>
                                <i class="bi-person dropdown-item-icon"></i>
                                {{ optional($booking->user)->firstname . ' ' . optional($booking->user)->lastname }}
                            </li>
                            <li>
                                <i class="bi-briefcase dropdown-item-icon"></i> {{ optional($booking->user)->email }}
                            </li>

                            <li class="pt-4 pb-0"><span class="card-subtitle">@lang('Contacts')</span></li>
                            <li><i
                                    class="bi-phone dropdown-item-icon"></i>{{ optional($booking->user)->phone_code . optional($booking->user)->phone }}
                            </li>

                            @if (optional($booking->user)->country)
                                <li class="pt-4 pb-0"><span class="card-subtitle">@lang('Address')</span></li>
                                <li class="fs-6 text-body">
                                    <i class="bi bi-geo-alt dropdown-item-icon"></i> @lang(optional($booking->user)->country)
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="card mb-3 mb-lg-5">
                    <div class="card-header card-header-content-between">
                        <div class="userHeader d-flex justify-content-start align-items-center gap-2">
                            <h4 class="card-header-title">@lang('Payment Information')</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled list-py-2 text-dark mb-0">
                            <li class="pb-0"><span class="card-subtitle">@lang('Transaction Details')</span></li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>@lang('Booking ID : ')</span> <span>{{ $booking->trx_id }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center text-danger">
                                <span>@lang('Charge In Payment Currency: ')</span>
                                <span>{{ getAmount($booking->depositable?->fixed_charge + $booking->depositable?->percentage_charge) }}
                                    {{ $booking->depositable?->payment_method_currency }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>@lang('Paid In Payment Currency : ')</span>
                                <span>{{ getAmount($booking->depositable?->payable_amount) }}
                                    {{ $booking->depositable?->payment_method_currency }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>@lang('Paid In Base : ')</span>
                                <span>{{ currencyPosition(getAmount($booking->depositable?->base_currency_charge + $booking->depositable?->payable_amount_in_base_currency)) }}</span>
                            </li>

                            <li class=" d-none pt-4 pb-0"><span class="card-subtitle">@lang('Coupon Information')</span></li>

                            <li class=" d-flex justify-content-between align-items-center">
                                <span>@lang('Amount : ')</span><span>{{ currencyPosition($booking->total_price + $booking->discount_amount) }}</span>
                            </li>
                            <li class=" d-none d-flex justify-content-between align-items-center">
                                <span>@lang('Coupon Apply : ')</span><span>@lang($booking->coupon == 1 ? 'Yes' : 'No')</span>
                            </li>
                            <li class=" d-none d-flex justify-content-between align-items-center">
                                <span>@lang('Coupon : ')</span><span>{{ $booking->cupon_number ?? 'N/A' }}</span>
                            </li>
                            <li class=" d-none d-flex justify-content-between align-items-center text-danger">
                                <span>@lang('Discount Amount : ')</span><span>{{ currencyPosition($booking->discount_amount) ?? 0 }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <h5>@lang('Final Amount : ')</h5>
                                <h5>{{ currencyPosition($booking->total_price) ?? 0 }}</h5>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-9 mb-3 mb-lg-0">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start align-items-center gap-2">
                            <h4 class="card-header-title">@lang('Booking Information')</h4>

                            @if ($booking->status == 1 && $booking->date > now())
                                <span class="badge bg-soft-warning text-warning">
                                    <span class="legend-indicator bg-warning"></span>
                                    @lang('Pending')
                                </span>
                            @elseif($booking->status == 0 && $booking->date > now())
                                <span class="badge bg-soft-warning text-warning">
                                    <span class="legend-indicator bg-warning"></span>
                                    @lang('Payment Pending')
                                </span>
                            @elseif($booking->status == 2)
                                <span class="badge bg-soft-success text-success">
                                    <span class="legend-indicator bg-success"></span>
                                    @lang('Completed')
                                </span>
                            @elseif($booking->status == 4)
                                <span class="badge bg-soft-secondary text-secondary">
                                    <span class="legend-indicator bg-secondary"></span>
                                    @lang('Refunded')
                                </span>
                            @elseif ($booking->date < now())
                                <span class="badge bg-soft-danger text-danger">
                                    <span class="legend-indicator bg-danger"></span>
                                    @lang('Expired')
                                </span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-2">
                            <a type="button" href="{{ route($base_route.'all') }}"
                                class="btn btn-info btn-sm float-end">
                                <i class="bi bi-arrow-left"></i>@lang('Back')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                {{-- <form action="{{ route($base_route.'update') }}" method="post"
                                    enctype="multipart/form-data"> --}}
                                @csrf

                                <input type="hidden" name="booking" value="{{ $booking->id }}" />
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-4">
                                            <label for="nameLabel" class="form-label">@lang('Car Name') <i
                                                    class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Type name here..."></i></label>
                                            <input type="text" class="form-control" name="name" id="nameLabel"
                                                placeholder="e.g dhaka" aria-label="name"
                                                value="{{ old('name', $booking->driver->car->name) }}"
                                                {{ 'disabled' }}>
                                            @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="TotalPriceLabel">@lang('Total Price')
                                                <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Total Paid Amount"></i></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control wid1" name="total_price"
                                                    id="TotalPriceLabel"
                                                    value="{{ old('total_price', $booking->total_price) }}"
                                                    placeholder="e.g 500" aria-label="price" {{ 'disabled' }}>
                                                <h5 class="form-control wid2 mb-0">{{ basicControl()->base_currency }}
                                                </h5>
                                            </div>
                                            @error('adult_price')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="statrtPoint">@lang('Booking Date')
                                            </label>
                                            <input type="text" name="bookingDate" id="bookingDate"
                                                class="form-control date-picker2" placeholder="@lang('Booking Date')"
                                                value="{{ $booking->date }}" disabled>
                                            @error('bookingDate')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="statrtPoint">@lang('Booking Created Date')</label>
                                            <input type="text" class="form-control" placeholder="@lang('Created At')"
                                                value="{{ dateTime($booking->created_at) }}" disabled>
                                            @error('startPoint')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-6">
                                        <div class="mb-4">
                                            <div class="maps mt-2" id="map"
                                                style="width:100%!important; height:500px !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.booking.partials.modal')

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/global/css/flatpickr.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let today = new Date();
            today.setDate(today.getDate() - 1);
            let maxDate = today.toISOString().split('T')[0];

            flatpickr('.date-picker', {
                enableTime: false,
                dateFormat: "Y-m-d H:i",
                maxDate: maxDate,
            });
            flatpickr('.date-picker2', {
                enableTime: false,
                dateFormat: "Y-m-d H:i",
                defaultDate: @json($booking->date)
            });
        });
    </script>

        {{-- Location Script --}}
        <script>
           function initMap(zoom = 24) {
        const latitude = parseFloat("{{ $booking->latitude ?? 0 }}");
        const longitude = parseFloat("{{ $booking->longitude ?? 0 }}");

        if (isNaN(latitude) || isNaN(longitude)) {
            console.warn("Invalid latitude/longitude values. Defaulting to [0,0].");
            return;
        }

        const myLatLng = { lat: latitude, lng: longitude };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: zoom,
            center: myLatLng,
        });

        const marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "Selected Location",
        });

        const geocoder = new google.maps.Geocoder();

        map.addListener('click', function(event) {
            const clickedLatLng = {
                lat: event.latLng.lat(),
                lng: event.latLng.lng()
            };

            marker.setPosition(clickedLatLng);

            geocoder.geocode({ location: clickedLatLng }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        const address = results[0].formatted_address;
                        $('#address').attr('readonly', 'readonly').val(address);
                        $('#googleAddress').val(address);
                    }
                } else {
                    console.error("Geocode failed: " + status);
                }
            });
        });
    }

    window.initMap = initMap;


            window.initMap = initMap;
        </script>
        <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKi2FQtjk-SV0uG0ir9ZuuDaknjDjBO0s&callback=initMap"></script>
@endpush
