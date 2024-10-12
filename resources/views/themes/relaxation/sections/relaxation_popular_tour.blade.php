<section class="destination">
    <div class="bg-layer" style="background: url({{ getFile(@$relaxation_popular_tour['single']['media']->image->driver, @$relaxation_popular_tour['single']['media']->image->path) }});"></div>
    <div class="container">
        <div class="common-title text-center">
            <h2>@lang(@$relaxation_popular_tour['single']['title_part_one']) <span>@lang(@$relaxation_popular_tour['single']['title_part_two']) <img src="{{ getFile(@$relaxation_popular_tour['single']['media']->image_two->driver, @$relaxation_popular_tour['single']['media']->image_two->path) }}" alt="shape"></span> @lang(@$relaxation_popular_tour['single']['title_part_three'])</h2>
        </div>
        <div class="row">
            @foreach(@$relaxation_popular_tour['packages']->slice(1) as $item)
                <div class="col-lg-4 col-md-6 popular_tour_col">
                    <div class="destination-single wow fadeInUp" data-wow-delay="100ms">
                        <div class="destination-single-image">
                            <a href="{{ route('package.details', @$item['slug']) }}"><img class="popularTourThumb" src="{{ getFile($item['thumb_driver'], $item['thumb']) }}" alt="{{ @$item['title'] }}"></a>
                        </div>
                        <div class="destination-single-content">
                            <h6>{{ optional(@$item['cityTake'])['name'] .', '.optional(@$item['stateTake'])['name'].', '.optional(@$item['countryTake'])['name'] }}</h6>
                            <a href="{{ route('package.details', ['slug' => @$item['slug']]) }}">@lang(@$item['title'])</a>
                            <div class="destination-single-review">
                                <div class="destination-single-review-inner">
                                    <div class="review d-flex gap-2">
                                        <ul>
                                            {!! displayStarRating(@$item->review_avg_rating) !!}
                                        </ul>
                                        <div class="review-number">{{ '(' .@$item->review_count.' reviews )' }} </div>
                                    </div>
                                    <div class="destination-single-price">
                                        @if($item['discount'] == 1)
                                            @php
                                                $amount = $item->calculateDiscountedPriceFromArray($item);
                                            @endphp
                                            <p>@lang('Starting From')
                                                <span>{{ currencyPosition(@$item['adult_price']) }}</span>
                                                <span>{{ currencyPosition($amount) }}</span>
                                            </p>
                                        @else
                                            <p>@lang('Starting From')
                                                <span class="simplePrice">{{ currencyPosition(@$item['adult_price']) }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="destination-single-review-inner text-end">
                                    <div class="destination-single-date">
                                        <p><i class="fa-light fa-clock"></i> {{ @$item->duration }}</p>
                                    </div>
                                    @if(@$item['discount'] == 1)
                                        <div class="destination-single-discount">
                                            {{ @$item['discount_amount'] }}{{ @$item['discount_type'] == 0 ? '%' : basicControl()->currency_symbol }}
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
