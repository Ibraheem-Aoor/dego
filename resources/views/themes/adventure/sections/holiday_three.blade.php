<section class="holiday-section holiday-section3">
    <div class="container-fluid">
        <div class="row">
            <div class="section-header text-center">
                <h2 class="section-title mx-auto">@lang(@$holiday_three['single']['title'])</h2>
                <p class="cmn-para-text mx-auto">@lang(@$holiday_three['single']['sub_title']) </p>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme carousel-area2">
                @foreach($holiday_three['packages'] as $item)
                    <div class="item">
                        <div class="package-card3">
                            <a href="{{ route('package.details').'?slug='.$item->slug }}">
                                <div class="thumbs-area">
                                    <img src="{{ getFile($item['thumb_driver'], $item['thumb']) }}" alt="{{ $item['title'] }}">
                                </div>
                            </a>
                            <div class="content-area">
                                <h4 class="title"><a href="{{ route('package.details').'?slug='.$item->slug }}">@lang($item['title'])</a></h4>
                                <div class="locat-revi-price">
                                    <div class="location"><i class="fa-regular fa-location-dot"></i>
                                        <span>{{ optional($item['countryTake'])['name'] }}</span>
                                    </div>
                                    @if($item->review_avg_rating >0)
                                        <div class="review-area">
                                            <ul class="star-list">
                                                {!! calculateAvgRating($item->review_avg_rating) !!}
                                            </ul>
                                            <p class="mb-0"><span>{{ number_format($item->review_avg_rating, 1) }} </span></p>
                                        </div>
                                    @endif
                                    <div class="price">
                                        @if($item['discount'] == 1)
                                            @php
                                                $amount = $item->calculateDiscountedPriceFromArray($item);
                                            @endphp
                                            <p>@lang('from :')
                                                <span>{{ currencyPosition($item['adult_price']) }}</span>
                                                <span>{{ currencyPosition($amount) }}</span>
                                            </p>
                                        @else
                                            @lang('from :')
                                            <span>{{ currencyPosition($item['adult_price']) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
