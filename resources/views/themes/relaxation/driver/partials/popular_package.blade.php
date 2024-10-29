<section class="destination-details-page">
    <div class="bg-layer" style="background: url({{ getFile(optional(optional($content->media)->image)->driver, optional(optional($content->media)->image)->path) }});"></div>
    <div class="container">
        <div class="common-title">
            @foreach($content->contentDetails as $details)
                <h2> @lang(optional($details->description)->heading) <span>@lang(optional($details->description)->heading_two)<img src="{{ getFile(optional(optional($content->media)->image_two)->driver, optional(optional($content->media)->image_two)->path) }} " alt="shape"></span> @lang(optional($details->description)->heading_three)</h2>
                <p>@lang($details->description->sub_heading)</p>
            @endforeach
        </div>
        <div class="row">
            @foreach($package->related_packages as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="destination-single wow fadeInUp" data-wow-delay="100ms">
                        <div class="destination-single-image">
                            <img class="packageThumb" src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{ $item->title }}">
                        </div>
                        <div class="destination-single-content">
                            <h6>{{ optional($item->cityTake)->name .', '.optional($item->stateTake)->name.', '.optional($item->countryTake)->name }}</h6>
                            <a href="{{ route('package.details', $item->slug) }}">{{ $item->title }}</a>
                            <div class="destination-single-review">
                                <div class="destination-single-review-inner">
                                    <div class="review">
                                        <ul>
                                            {!! displayStarRating($item->review_avg_rating) !!}
                                        </ul>
                                        <div class="review-number">{{ '( '. $item->review_count . ' reviews )' }}</div>
                                    </div>
                                    <div class="destination-single-price">
                                        @if($item->discount == 1)
                                            @php
                                                $amount = $item->calculateDiscountedPrice();
                                            @endphp
                                            <p>@lang('Starting From')
                                                <span>{{ currencyPosition($item->adult_price) }}</span>
                                                <span>{{ currencyPosition($amount) }}</span>
                                            </p>
                                        @else
                                            <p>@lang('Starting From') <span class="simplePrice">{{ currencyPosition($item->adult_price) }}</span></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="destination-single-review-inner text-end">
                                    <div class="destination-single-date">
                                        <p><i class="fa-light fa-clock"></i> {{ $item->duration }}</p>
                                    </div>
                                    @if($item->discount == 1)
                                        <div class="destination-single-discount">
                                            {{ $item->discount_amount }}{{ $item->discount_type == 0 ? '%' : basicControl()->currency_symbol }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
