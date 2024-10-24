<div class="row">
    {{-- Images & Media --}}
    <div class="col-lg-12">
        <div class=" row packageImage">
            <div class="col-lg-8">
                <div class="destination-details-left-image">
                    <div class="image">
                        <img src="{{ getFile($car->thumb_driver, $car->thumb) }}" alt="{{ $car->title }}">
                    </div>
                    <div class="destination-details-gallery d-none">
                        <a href="{{ $car->video }}" class="btn-2 video-link"><i class="fa-thin fa-video"></i>
                            @lang('Video') <span></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 image">
                <div class="imageRight">
                    @if ($car->media->isNotEmpty())
                        @php
                            $firstImage = $car->media->first();
                            $otherImages = $car->media->slice(1);
                        @endphp

                        <div class="destination-details-right-image">
                            <a href="{{ getFile($firstImage->driver, $firstImage->image) }}" class="lightbox-image"
                                data-fancybox="gallery">
                                <img src="{{ getFile($firstImage->driver, $firstImage->image) }}"
                                    alt="{{ $car->title }}">
                            </a>
                        </div>

                        <div class="row">
                            @foreach ($otherImages as $item)
                                <div class="col-lg-6 col-md-6">
                                    <div class="destination-details-right-image wow fadeInLeft" data-wow-delay="100ms">
                                        <a href="{{ getFile($item->driver, $item->image) }}" class="lightbox-image"
                                            data-fancybox="gallery">
                                            <img src="{{ getFile($item->driver, $item->image) }}"
                                                alt="{{ $car->title }}">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="destination-details-content">
            <h5 class="destination-details-common-title">@lang('Details Info')</h5>
            {!! $car->description !!}
        </div>
        <div class="row">
            <div class="col-xl-9 col-lg-11">
                <div class="destination-details-facilities">
                    <ul>
                        <li><i class="fa-thin fa-clock"></i>@lang($car->engine_type)</li>
                        <li>
                            <i class="fa-thin fa-user"></i> @lang('Max Travelers :') @lang($car->transmission_type)
                        </li>
                        <li>
                            <i class="fa-thin fa-user"></i> @lang('Min Travelers :') @lang($car->doors_count)
                        </li>
                        <li>
                            <i class="fa-thin fa-list"></i> @lang('Package Type :') @lang($car->fuel_type)
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="destination-details-meeting">
            <h5 class="destination-details-common-title">@lang('Meeting And Pickup')</h5>
            <div class="destination-details-meeting-inner">
                <div class="destination-details-meeting-content">
                    <h6>@lang('Start point')</h6>
                    <a href="{{ $car->pickup_location }}">@lang('Open in Google Maps')</a>
                </div>
                <div class="destination-details-meeting-content">
                    <h6>@lang('End point')</h6>
                    <p>{{ $car->end_point }}</p>
                    <a href="{{ $car->drop_location }}">@lang('Open in Google Maps')</a>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="mapContainer" class="mapShow">
                        <iframe id="mapFrame" width="450" height="300" frameborder="0" class="mapIn"
                            allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="mapContainer2" class="mapShow">
                        <iframe id="mapFrame2" width="450" height="300" frameborder="0" class="mapIn"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="small-screen-image d-lg-none">
            @if ($car->media->isNotEmpty())
                <div class="destination-details-right-image smallScreen">
                    <a href="{{ getFile($car->media->first()->driver, $car->media->first()->image) }}"
                        class="lightbox-image" data-fancybox="gallery">
                        <img src="{{ getFile($car->media->first()->driver, $car->media->first()->image) }}"
                            alt="{{ $car->title }}">
                    </a>
                </div>
            @endif
            @if ($car->media->isNotEmpty() && $car->media->count() > 1)
                <div class="row">
                    @foreach ($car->media->slice(1, 2) as $item)
                        <div class="col-lg-6 col-md-6">
                            <div class="destination-details-right-image wow fadeInLeft smallScreen"
                                data-wow-delay="100ms">
                                <a href="{{ getFile($item->driver, $item->image) }}" class="lightbox-image"
                                    data-fancybox="gallery">
                                    <img src="{{ getFile($item->driver, $item->image) }}" alt="{{ $car->title }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="destination-details-right-container">
            <div class="destination-details-price-form wow fadeInUp" data-wow-delay="100ms">
                <h5 class="destination-details-right-title">@lang('Price Includes')</h5>
                <p><i class="fa-thin fa-bag-shopping"></i> @lang('Pric')
                    <span>{{ currencyPosition($car->rent_price) }}</span>
                </p>
                <div class="quote-tab">
                    <div class="quote-tab__button">
                        <ul class="tabs-button-box">
                            <li data-tab="#quote1" class="tab-btn-item active-btn-item">
                                <div class="quote-tab__button-inner">
                                    <h6> @lang('Booking Form')</h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @if ($car->status == 1)
                        <form id="bookingInformationForm" class="form"
                            action="{{ route('user.car.checkout.form', encrypt($car->id)) }}" method="get">
                            @csrf
                            <div class="tabs-content-box">
                                <div class="tab-content-box-item tab-content-box-item-active" id="quote1">
                                    <div class="quote-tab-content-box-item">
                                        <div class="search-form">
                                            <div class="date">
                                                <i class="fa-thin fa-calendar-days"></i>
                                                <input type="text" class="flatpickr" name="date"
                                                    value="{{ request()->date ?? '' }}" placeholder="@lang('Select Start Date')"
                                                    id="myID">
                                            </div>
                                            <span id="inputDateError" class="text-danger">{{ $errors->first('date') }}</span>
                                            <a type="submit" id="bookNowBtn" class="btn-1 mt-2">@lang('Proceed Booking')
                                                <span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif($car->status == 0)
                        <div class="text-center">
                            <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                            <p>@lang('This Package is not available for booking.')<i class="fa-regular fa-face-meh"></i></p>
                        </div>
                    @endif

                </div>
                <div class="wish-list">
                    <p><i class="fa-thin fa-heart"></i> {{ ' ' . $car->favourite_count . ' Time saved to wishlist' }}
                    </p>
                    <p><i class="fa-thin fa-eye"></i> {{ $car->visitor_count }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="destination-details-expect pb-0">
            <h5 class="destination-details-common-title">@lang('Fuel Policy')</h5>
            {{-- <p>@lang('Meet your guide and a small group of no more than six near the Vatican where you enjoy early access into the complex.')</p> --}}
            {!! $car->fuel_policy !!}
        </div>
    </div>
    <div class="col-lg-9">
        <div class="destination-details-expect pb-0">
            <h5 class="destination-details-common-title">@lang('Insurance Info')</h5>
            {{-- <p>@lang('Meet your guide and a small group of no more than six near the Vatican where you enjoy early access into the complex.')</p> --}}
            {!! $car->insurance_info !!}
        </div>
    </div>

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
