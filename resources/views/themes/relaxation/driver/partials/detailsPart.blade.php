<div class="row">
    {{-- Images & Media --}}
    <div class="col-lg-6">
        <div class=" row packageImage">
            <div class="col-lg-4 image">
                <div class="">
                    <div class="destination-details-right-image">
                        <a href="{{ getFile($driver->car->thumb_driver, $driver->car->thumb) }}" class="lightbox-image"
                            data-fancybox="gallery">
                            <img src="{{ getFile($driver->car->thumb_driver, $driver->car->thumb) }}"
                                alt="{{ $driver->car->name }}">
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-xl-9 col-lg-11">
                <div class="destination-details-facilities">
                    <ul>
                        <li><i class="fa-thin fa-clock"></i>@lang($driver->car->name)</li>
                        <li>
                            <i class="fa-thin fa-car"></i> @lang('Type: ') @lang($driver->car->type)
                        </li>
                        <li>
                            <i class="fa-thin fa-cube"></i> @lang('Model :') @lang($driver->car->model)
                        </li>
                        <li>
                            <i class="fa-thin fa-user"></i> @lang('Max Travelers :') @lang($driver->car->max_passengers)
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- Rides & Services --}}
    <form id="bookingInformationForm" class="form"
        action="{{ route('user.driver.checkout.form', encrypt($driver->id)) }}" method="get">
        <div class="row">
            @csrf
            <div class="col-lg-6">
                <div class="destination-details-right-container">
                    <div class="destination-details-price-form wow fadeInUp" data-wow-delay="100ms">
                        <h5 class="destination-details-right-title">@lang('Services')</h5>
                        <div class="quote-tab">
                            <div class="quote-tab__button">
                                <ul class="tabs-button-box">
                                    <li class="">
                                        <div class="quote-tab__button-inner">
                                            <h6> @lang('Choose Service')</h6>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @if ($driver->status == 1)
                                <div class="tabs-content-box">
                                    <div class="tab-content-box-item tab-content-box-item-active">
                                        <div class="quote-tab-content-box-item">
                                            <div class="search-form">
                                                <select name="service" id="service" class="form-control">
                                                    <option value="">@lang('--Select Service--')</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->value }}" @selected(old('service') == $service->value)>@lang($service->name)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="inputDateError"
                                                class="text-danger">{{ $errors->first('service') }}</span>
                                            </div>
                                            @php
                                                $old_ride = old('ride');
                                            @endphp
                                            <div class="@if(!isset($old_ride) && !$errors->has('ride')) d-none  @endif" id="rides-select">
                                                <div class="quote-tab__button">
                                                    <ul class="tabs-button-box">
                                                        <li class="">
                                                            <div class="quote-tab__button-inner">
                                                                <h6> @lang('Choose Cities')</h6>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="search-form mt-2 ">
                                                    <select name="ride" id="ride" class="form-control">
                                                        <option value="">@lang('--Select Cities--')</option>
                                                        @foreach ($driver_rides as $ride)
                                                            <option value="{{ $ride->id }}" @selected(old('ride') == $ride->id)
                                                                data-price="{{ currencyPosition($ride->price) }}">
                                                                @lang('From')
                                                                {{ $ride->from }} @lang('To')
                                                                {{ $ride->to }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span id="inputDateError"
                                                    class="text-danger">{{ $errors->first('ride') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="quote-tab__button">
                                                    <ul class="tabs-button-box">
                                                        <li class="">
                                                            <div class="quote-tab__button-inner">
                                                                <h6> @lang('Choose Pickup Point')</h6>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="maps mt-2" id="map"
                                                    style="width:100%!important; height:500px !important;">
                                                </div>
                                            </div>
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                            <span id="inputDateError"
                                            class="text-danger">{{ $errors->first('latitude') }}</span>
                                            <span id="inputDateError"
                                            class="text-danger">{{ $errors->first('longitude') }}</span>
                                        </div>

                                    </div>
                                </div>
                            @elseif($driver->status == 0)
                                <div class="text-center">
                                    <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                    <p>@lang('This Car is not available for booking.')<i class="fa-regular fa-face-meh"></i></p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            {{-- Pricing --}}
            <div class="col-lg-6">
                <div class="destination-details-right-container">
                    <div class="destination-details-price-form wow fadeInUp" data-wow-delay="100ms">
                        <h5 class="destination-details-right-title">@lang('Price Includes')</h5>
                        <p><i class="fa-thin fa-bag-shopping"></i> @lang('Price')
                            <span id="total-price"></span>
                        </p>
                        <div class="quote-tab">
                            <div class="quote-tab__button">
                                <ul class="tabs-button-box">
                                    <li class="">
                                        <div class="quote-tab__button-inner">
                                            <h6> @lang('Booking Form')</h6>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @if ($driver->status == 1)
                                @csrf
                                <div class="tabs-content-box">
                                    <div class="tab-content-box-item tab-content-box-item-active">
                                        <div class="quote-tab-content-box-item">
                                            <div class="search-form">
                                                <div class="date">
                                                    <i class="fa-thin fa-calendar-days"></i>
                                                    <input type="text" class="flatpickr" name="date"
                                                        value="{{ old('date', request()->date) ?? '' }}"
                                                        placeholder="@lang('Select Start Date')" id="myID">
                                                </div>
                                                <span id="inputDateError"
                                                    class="text-danger">{{ $errors->first('date') }}</span>
                                                <a type="submit" id="bookNowBtn"
                                                    class="btn-1 mt-2">@lang('Proceed Booking')
                                                    <span></span></a>
                                                @if($errors->all())
                                                @foreach ($errors->all() as $error)
                                                    <p class="text-danger">{{ $error }}</p>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($driver->status == 0)
                                <div class="text-center">
                                    <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                    <p>@lang('This Car is not available for booking.')<i class="fa-regular fa-face-meh"></i></p>
                                </div>
                            @endif

                        </div>
                        <div class="wish-list">
                            <p><i class="fa-thin fa-heart"></i>
                                {{ ' ' . $driver->favourite_count . ' Time saved to wishlist' }}
                            </p>
                            <p><i class="fa-thin fa-eye"></i> {{ $driver->visitor_count }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include(template() . 'package.partials.review')
</div>
@push('style')
    <style>
        h3 {
            font-size: 16px !important;
            line-height: 30px;
        }

        p {
            margin-top: 10px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            var driver_to_airport_price = "{{ currencyPosition($driver->to_airport_price) }}";
            var driver_from_airport_price = "{{ currencyPosition($driver->from_airport_price) }}";
            $(document).on('change', 'select[name="service"]', function() {
                if (this.value == 'between_cities') {
                    $('#rides-select').removeClass('d-none');
                } else if (this.value == 'to_airport') {
                    console.log(driver_to_airport_price);
                    $('#total-price').html(driver_to_airport_price);
                } else if (this.value == 'from_airport') {
                    $('#total-price').html(driver_from_airport_price);
                } else {
                    $('#rides-select').addClass('d-none');
                }
            });
            $(document).on('change', 'select[name="ride"]', function() {
                var price = $(this).find(':selected').data('price');
                $('#total-price').html(price);
            });
        });

        function initMap(zoom = 12) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    const myLatLng = {
                        lat: latitude,
                        lng: longitude
                    };

                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: zoom,
                        center: myLatLng,
                    });

                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: "Selected Location",
                    });

                    google.maps.event.addListener(map, 'click', function(event) {
                        marker.setPosition(event.latLng);
                        document.getElementById('latitude').value = event.latLng.lat();
                        document.getElementById('longitude').value = event.latLng.lng();

                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({
                            location: event.latLng
                        }, function(results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                                if (results[0]) {
                                    var address = results[0].formatted_address;
                                    var addressInput = $('#address');
                                    var googleAddressInput = $('#googleAddress');

                                    addressInput.attr('readonly', 'readonly');
                                    addressInput.val(address);
                                    googleAddressInput.val(address);
                                }
                            } else {
                                console.log("Geocode failed due to: " + status);
                            }
                        });
                    });
                }, function(error) {
                    console.log("Geolocation error: " + error.message);
                });
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }



        window.initMap = initMap;
    </script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKi2FQtjk-SV0uG0ir9ZuuDaknjDjBO0s&callback=initMap"></script>
@endpush
