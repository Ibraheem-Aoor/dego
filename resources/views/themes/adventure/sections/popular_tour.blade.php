<section class="popular-tour-section">
    <div class="container-fluid">
        <div class="row">
            <div class="section-header text-center">
                <div class="section-subtitle">{{ @$popular_tour['single']['title'] }}</div>
                <h2 class="section-title mx-auto">{{ @$popular_tour['single']['sub_title'] }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme carousel-area1">
                @foreach($popular_tour['packages'] as $item)
                    <div class="item">
                        <div class="package-card">
                            <a href="{{ route('package.details', $item['slug']) }}">
                                <div class="thumbs-area">
                                    <img class="packageThumb" src="{{ getFile($item['thumb_driver'],$item['thumb']) }}" alt="{{ $item['title'] }}">
                                </div>
                            </a>
                            <div class="content-area">
                                @auth
                                    @php
                                        $isFavorite = false;
                                        $user = null;
                                    @endphp

                                    @foreach ($item->reaction as $reaction)
                                        @if ($reaction->reaction == 1)
                                            @php
                                                $isFavorite = true;
                                                $user = $reaction->user_id;
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endauth

                                <div class="rate-area">
                                    <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item->id }}" data-toggle="tooltip"
                                       title="{{ auth()->check() ? ($isFavorite && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.') : 'add to the favorite list.' }}">
                                        <i class="{{ auth()->check() ? ($isFavorite && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart') : 'fa-regular fa-heart' }}"></i>
                                    </a>
                                </div>
                                <span class="location"><i class="fa-regular fa-location-dot"></i>{{ optional($item['cityTake'])['name'] .', '.optional($item['stateTake'])['name'].', '.optional($item['countryTake'])['name'] }}</span>
                                <h4 class="title"><a href="{{ route('package.details', $item['slug'])}}">@lang($item['title'])</a>
                                </h4>
                                <div class="review-area">
                                    <ul class="star-list">
                                        {!! displayStarRating($item->review_avg_rating) !!}
                                    </ul>
                                    <p class="mb-0">
                                        <span>({{ $item->review_count }} @lang('reviews'))</span></p>
                                </div>
                                <div class="content-bottom">
                                    <div class="duration">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $item['duration'] }}
                                    </div>
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
