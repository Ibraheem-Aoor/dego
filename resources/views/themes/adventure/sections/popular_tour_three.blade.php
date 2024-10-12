<section class="popular-tour-section3">
    <div class="container-fluid">
        <div class="row">
            <div class="section-header text-center">
                <h2 class="section-title mx-auto">@lang($popular_tour_three['single']['heading'])</h2>
                <p class="cmn-para-text mx-auto">@lang($popular_tour_three['single']['sub_heading'])</p>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme carousel-area2">
                @foreach($popular_tour_three['packages'] as $item)
                    <div class="item">
                        <div class="package-card3">
                            <a href="{{ route('package.details', $item['slug']) }}">
                                <div class="thumbs-area">
                                    <img src="{{ getFile($item['thumb_driver'], $item['thumb']) }}" alt="{{ $item['title'] }}">
                                </div>
                            </a>
                            <div class="content-area">
                                <h4 class="title"><a href="{{ route('package.details', $item['slug']) }}">@lang($item['title'])</a></h4>
                                <div class="locat-revi-price">
                                    <div class="location"><i class="fa-regular fa-location-dot"></i>
                                        <span>{{ optional($item['countryTake'])['name'] }}</span>
                                    </div>
                                    @if($item->review_avg_rating > 0)
                                        <div class="review-area">
                                            <ul class="star-list">
                                                {!! calculateAvgRating($item->review_avg_rating) !!}
                                            </ul>
                                            <p class="mb-0">
                                                <span>{{ number_format($item->review_avg_rating, 1) }} </span>
                                            </p>
                                        </div>
                                    @endif
                                    <div class="price">
                                        @if($item['discount'] == 1)
                                            @php
                                                $amount = $item->calculateDiscountedPriceFromArray($item);
                                            @endphp
                                            <span>{{ currencyPosition($item['adult_price']) }}</span>
                                            <span>{{ currencyPosition($amount) }}</span>
                                        @else
                                            <span class="simplePrice">{{ currencyPosition($item['adult_price']) }}</span>
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
