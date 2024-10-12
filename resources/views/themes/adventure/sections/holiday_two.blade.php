<section class="holiday-section">
    <div class="container">
        <div class="row">
            <div class="section-header text-center">
                <div class="section-subtitle">@lang(@$holiday_two['single']['title'])</div>
                <h2 class="section-title mx-auto">@lang(@$holiday_two['single']['sub_title'])</h2>
            </div>
        </div>
        <div class="row g-4">
            @foreach($holiday_two['packages'] as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('package.details', $item['slug']) }}" class="package-card2" data-bs-toggle="modal" data-bs-target="#package-card2">
                        <div class="thumbs-area">
                            <img src="{{ getFile($item['thumb_driver'], $item['thumb']) }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="content-area">
                            <span>
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
                            </span>
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
        <div class="btn-are text-center mt-50">
            <a href="{{ @$holiday_two['single']['media']->button_link }}" class="cmn-btn2">{{ $holiday_two['single']['button'] }}</a>
        </div>
    </div>

</section>
