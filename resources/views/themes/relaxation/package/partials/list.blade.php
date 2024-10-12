<div class="package-right-container">
    @forelse($packages as $item)
        @php
            $isFavorite = false;

            $params = [
                'date' => request()->date,
                'adults' => request()->adults,
                'children' => request()->children,
                'infants' => request()->infants,
            ];

            $query = http_build_query(array_filter($params));
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
        <div class="package-right-single wow fadeInRight" data-wow-delay="100ms">
            <div class="package-right-image">
                <img src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{ $item->title }}">
                <div class="icon">
                    <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item->id }}"
                       data-toggle="tooltip" title="{{ $isFavorite && auth()->check() && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.' }}">
                        <i class="{{ $isFavorite && auth()->check() && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart' }}"></i>
                    </a>
                </div>
            </div>
            <div class="destination-single-content">
                <h6>{{ optional($item->cityTake)->name .', '.optional($item->stateTake)->name.', '.optional($item->countryTake)->name }}</h6>
                <a href="{{ route('package.details', $item->slug) . ($query ? '?' . $query : '') }}">@lang($item->title)</a>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 100) }}</p>
                <div class="destination-single-review">
                    <div class="destination-single-review-inner">
                        <div class="review d-flex gap-2">
                            <ul>
                                {!! displayStarRating($item->average_rating) !!}
                            </ul>
                            <div class="review-number">{{ '( '. $item->review_count . ' reviews )' }} </div>
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
                                <p>@lang('Starting From')
                                    <span class="simplePrice">{{ currencyPosition($item->adult_price) }}</span></p>
                            @endif

                        </div>
                    </div>
                    <div class="destination-single-review-inner text-end">
                        <div class="destination-single-date">
                            <p><i class="fa-light fa-clock"></i>{{' '. $item->duration }}
                            </p>
                        </div>
                        <div class="destination-single-discount">
                            @if($item->discount == 1)
                                {{ $item->discount_amount }}{{ $item->discount_type == 0 ? '%' : basicControl()->currency_symbol }}
                            @else
                                0 %
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="row justify-content-center pt-5">
            <div class="col-12">
                <div class="data-not-found text-center">
                    <div class="no_data_image">
                        <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                    </div>
                    <p>@lang('No data found.')</p>
                </div>
            </div>
        </div>
    @endforelse
    {{ $packages->appends(request()->query())->links($theme.'partials.pagination') }}
</div>
