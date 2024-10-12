<div class="row">
    <div class="col-lg-12">
        <div class=" row packageImage">
            <div class="col-lg-8">
                <div class="destination-details-left-image">
                    <div class="image">
                        <img src="{{ getFile($package->thumb_driver, $package->thumb) }}" alt="{{ $package->title }}">
                    </div>
                    <div class="destination-details-gallery">
                        <a href="{{ $package->video }}" class="btn-2 video-link"><i class="fa-thin fa-video"></i> @lang('Video') <span></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 image">
                <div class="imageRight">
                    @if($package->media->isNotEmpty())
                        @php
                            $firstImage = $package->media->first();
                            $otherImages = $package->media->slice(1);
                        @endphp

                        <div class="destination-details-right-image">
                            <a href="{{ getFile($firstImage->driver, $firstImage->image) }}" class="lightbox-image" data-fancybox="gallery">
                                <img src="{{ getFile($firstImage->driver, $firstImage->image) }}" alt="{{ $package->title }}">
                            </a>
                        </div>

                        <div class="row">
                            @foreach($otherImages as $item)
                                <div class="col-lg-6 col-md-6">
                                    <div class="destination-details-right-image wow fadeInLeft" data-wow-delay="100ms">
                                        <a href="{{ getFile($item->driver, $item->image) }}" class="lightbox-image" data-fancybox="gallery">
                                            <img src="{{ getFile($item->driver, $item->image) }}" alt="{{ $package->title }}">
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
            {!! $package->description !!}
        </div>
        <div class="row">
            <div class="col-xl-9 col-lg-11">
                @if($package->facility || $package->excluded)
                    <div class="destination-details-price">
                        @if($package->facility)
                            <div class="price-content">
                                <h6>@lang('Price Includes')</h6>
                                <ul>
                                    @foreach($package->facility as $item)
                                        <li><i class="fa-light fa-check"></i>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($package->excluded)
                            <div class="price-content">
                                <h6>@lang('Price Excludes')</h6>
                                <ul>
                                    @foreach($package->excluded as $item)
                                        <li><i class="fa-sharp fa-light fa-xmark"></i>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="destination-details-facilities">
                    <ul>
                        <li><i class="fa-thin fa-clock"></i> {{ $package->duration }}</li>
                        <li>
                            <i class="fa-thin fa-user"></i> @lang('Max Travelers :') {{ $package->maximumTravelers }}
                        </li>
                        <li>
                            <i class="fa-thin fa-user"></i> @lang('Min Travelers :') {{ $package->minimumTravelers }}
                        </li>
                        <li>
                            <i class="fa-thin fa-list"></i> @lang('Package Type :') {{ $package->category->name }}
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
                    <p>{{ $package->start_point }}</p>
                    <a href="javascript:void(0);"
                       onclick="toggleMap('mapContainer', 'mapFrame', '{{ $package->map }}')">@lang('Open in Google Maps')</a>

                </div>
                <div class="destination-details-meeting-content">
                    <h6>@lang('Start time')</h6>
                    <p>@lang('07:30AM')</p>
                </div>
                <div class="destination-details-meeting-content">
                    <h6>@lang('End point')</h6>
                    <p>{{ $package->end_point }}</p>
                    <a href="javascript:void(0);"
                       onclick="toggleMap('mapContainer2', 'mapFrame2', '{{ $package->map }}')">@lang('Open in Google Maps')</a>

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
            @if($package->media->isNotEmpty())
                <div class="destination-details-right-image smallScreen">
                    <a href="{{ getFile($package->media->first()->driver, $package->media->first()->image) }}" class="lightbox-image" data-fancybox="gallery">
                        <img src="{{ getFile($package->media->first()->driver, $package->media->first()->image) }}" alt="{{ $package->title }}">
                    </a>
                </div>
            @endif
            @if($package->media->isNotEmpty() && $package->media->count() > 1)
                <div class="row">
                    @foreach($package->media->slice(1, 2) as $item)
                        <div class="col-lg-6 col-md-6">
                            <div class="destination-details-right-image wow fadeInLeft smallScreen" data-wow-delay="100ms">
                                <a href="{{ getFile($item->driver, $item->image) }}" class="lightbox-image" data-fancybox="gallery">
                                    <img src="{{ getFile($item->driver, $item->image) }}" alt="{{ $package->title }}">
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

                @if($package->discount == 1)
                    @php
                        $amount = $package->calculateDiscountedPrice();
                    @endphp
                    <p class="destination_details_price"><i class="fa-thin fa-bag-shopping"></i> @lang('Start From')
                        <span class="discountPrice">{{ currencyPosition($package->adult_price) }}</span>
                        <span>{{ currencyPosition($amount) }}</span>
                    </p>
                @else
                    <p><i class="fa-thin fa-bag-shopping"></i> @lang('Start From')
                        <span>{{ currencyPosition($package->adult_price) }}</span>
                    </p>
                @endif
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
                    @if($package->status == 1)
                        <form id="bookingInformationForm" class="form" action="{{ route('user.checkout.form', $package->slug) }}" method="post">
                            @csrf
                            <div class="tabs-content-box">
                                <div class="tab-content-box-item tab-content-box-item-active" id="quote1">
                                    <div class="quote-tab-content-box-item">
                                        <div class="search-form">
                                            <div class="date">
                                                <i class="fa-thin fa-calendar-days"></i>
                                                <input type="text" class="flatpickr" name="date" value="{{ request()->date ?? '' }}"
                                                       placeholder="Select Date" id="myID">
                                            </div>
                                            <span id="inputDateError" class="text-danger"></span>
                                            <div class="count">
                                                <div class="count-counter">
                                                    <i class="fa-light fa-user"></i>
                                                    <div class="count-counter-inner">
                                                        <span class="adult_person" id="adult">{{request()->adults ?? 0}}</span>
                                                        <p class="m-0">@lang('adult')</p>
                                                    </div>
                                                    <div class="count-counter-inner">
                                                        <span class="children" id="child">{{request()->children ?? 0}}</span>
                                                        <p class="m-0">@lang('Children')</p>
                                                    </div>
                                                    <div class="count-counter-inner">
                                                        <span class="infant" id="infant">{{request()->infants ?? 0}}</span>
                                                        <p class="m-0">@lang('Infant')</p>
                                                    </div>
                                                </div>
                                                <div class="count-container">
                                                    <div class="count-single">
                                                        <div class="count-single-text">
                                                            <h6>@lang('Adult')</h6>
                                                            <p>@lang('Over 12 Years')</p>
                                                        </div>
                                                        <div class="count-single-inner">
                                                            <button type="button" class="decrement"
                                                                    data-target="adult-quantity">-
                                                            </button>
                                                            <span class="quantity"
                                                                  id="adult-quantity">{{request()->adults ?? 0}}</span>
                                                            <button type="button" class="increment"
                                                                    data-target="adult-quantity">+
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="count-single">
                                                        <div class="count-single-text">
                                                            <h6>@lang('Children')</h6>
                                                            <p>@lang('Below 12 Years')</p>
                                                        </div>
                                                        <div class="count-single-inner">
                                                            <button type="button" class="decrement"
                                                                    data-target="children-quantity">-
                                                            </button>
                                                            <span class="quantity" id="children-quantity">{{request()->children ?? 0}}</span>
                                                            <button type="button" class="increment"
                                                                    data-target="children-quantity">+
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="count-single">
                                                        <div class="count-single-text">
                                                            <h6>@lang('Infant')</h6>
                                                            <p>@lang('Below 3 Years')</p>
                                                        </div>
                                                        <div class="count-single-inner">
                                                            <button type="button" class="decrement"
                                                                    data-target="infant-quantity">-
                                                            </button>
                                                            <span class="quantity" id="infant-quantity">{{request()->infants ?? 0}}</span>
                                                            <button type="button" class="increment"
                                                                    data-target="infant-quantity">+
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="count-single">
                                                        <h5 class="totalPrice">@lang('Total Price: ')</h5>
                                                        <h5 class="totalPrice"><span id="totalPrice">0</span>
                                                            <span>{{ basicControl()->base_currency }}</span></h5>
                                                    </div>
                                                </div>
                                                <span id="inputPersonError" class="text-danger"></span>
                                            </div>
                                            <input type="hidden" name="totalAdult" id="totalAdult" value="">
                                            <input type="hidden" name="totalChildren" id="totalChildren" value="">
                                            <input type="hidden" name="totalInfant" id="totalInfant" value="">
                                            <a type="submit" id="bookNowBtn" class="btn-1">@lang('Proceed Booking')
                                                <span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif($package->status == 0)
                        <div class="text-center">
                            <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                            <p>@lang('This Package is not available for booking.')<i class="fa-regular fa-face-meh"></i></p>
                        </div>
                    @endif

                </div>
                <div class="wish-list">
                    <p><i class="fa-thin fa-heart"></i> {{ ' '.$package->favourite_count. ' Time saved to wishlist' }}</p>
                    <p><i class="fa-thin fa-eye"></i> {{ $package->visitor_count }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($package->expected)
        <div class="col-lg-9">
            <div class="destination-details-expect pb-0">
                <h5 class="destination-details-common-title">@lang('What To Expect')</h5>
                <p>@lang('Meet your guide and a small group of no more than six near the Vatican where you enjoy early access into the complex.')</p>
                @foreach($package->expected as $item)
                    <div class="destination-details-expect-content item-list {{ $loop->index >= 2 ? 'd-none' : '' }}">
                        <div class="number">{{ $loop->iteration }}</div>
                        <div class="content">
                            <h6>{{ $item->expect }}</h6>
                            <p>{{ $item->expect_detail }}</p>
                        </div>
                    </div>
                @endforeach
                @if(count($package->expected) > 2)
                    <a href="#0" class="btn-2 load-more">@lang('Show More')<span></span></a>
                    <a href="#0" class="btn-2 load-less d-none">@lang('Show Less')<span></span></a>
                @endif
            </div>
        </div>
    @endif

    @include(template().'package.partials.review')
</div>
@push('style')
    <style>
        h3{
            font-size: 16px !important;
            line-height: 30px;
        }
        p{
            margin-top: 10px !important;
        }
    </style>
@endpush
