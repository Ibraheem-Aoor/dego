<section class="popular-tour-section">
    <div class="container">
        <div class="section-header">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <div class="section-subtitle">@lang(@$popular_two['single']['heading'])</div>
                    <h2 class="section-title">@lang(@$popular_two['single']['sub_heading'])</h2>
                </div>
                <div class="col-sm-4 d-flex justify-content-center justify-content-md-end">
                    <div class="btn-area">
                        <a href="{{ @$popular_two['single']['media']->button_link }}" class="cmn-btn">@lang(@$popular_two['single']['button'])</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach($popular_two['packages'] as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('package.details', $item['slug']) }}"
                       class="package-card2"
                    >
                        <div class="thumbs-area">
                            <img  src="{{ getFile($item['thumb_driver'], $item['thumb']) }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="content-area">
                            <div class="price">
                                @if($item['discount'] == 1)
                                    @php
                                        $amount = $item->calculateDiscountedPriceFromArray($item);
                                    @endphp
                                    <p class="text-white">@lang('from :')
                                        <span>{{ currencyPosition($item['adult_price']) }}</span>
                                        <span>{{ currencyPosition($amount) }}</span>
                                    </p>
                                @else
                                    <p class="text-white">
                                        @lang('from :')
                                        <span class="simplePrice">{{ currencyPosition($item['adult_price']) }}</span>
                                    </p>
                                @endif
                            </div>
                            <h5 class="title">@lang($item['title'])</h5>
                            <div class="review-area">
                                <ul class="star-list">
                                    {!! displayStarRating($item->review_avg_rating) !!}
                                </ul>
                                <p class="mb-0">
                                    <span>({{ $item->review_count }} @lang('reviews'))</span></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
