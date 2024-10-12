@extends($theme.'layouts.app')
@section('title',trans('Packages'))

@section('content')
    @include(template().'partials.breadcrumb')
    <div class="pakeg-slider">
        <div class="container">
            <div class="pakeg-carousol">
                <div class="ten-item-carousel swiper-container pakeg-carousol-container">
                    <div class="swiper-wrapper">
                        @foreach($categories as $item)
                            <div
                                class="swiper-slide @if(request()->has('type') && request()->type == $item->id) active @endif">
                                <div class="pakeg-slider-content">
                                    <a href="{{ route('package',['type' => title2Kebab($item->name)]) }}"
                                       style="@if(request()->has('type') && request()->type == title2Kebab($item->name)) color: #ff8e3f; @endif">@lang($item->name)</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="package">
        <div class="container">
            <div class="row gy-5 g-sm-5">
                <div class="col-lg-3">
                    @include(template().'package.partials.searchBox')
                </div>
                <div class="col-lg-9" id="packageSearch">
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
                                    <img src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{$item->title}}">
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
                                                @if($item->review_count > 0)
                                                    <div class="review-number">{{ '( '. $item->review_count . ' reviews )' }} </div>
                                                @endif
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
                                            @if($item->discount == 1)
                                                <div class="destination-single-discount">
                                                    {{ $item->discount_amount }}{{ $item->discount_type == 0 ? '%' : basicControl()->currency_symbol }}
                                                </div>
                                            @endif
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
                </div>
            </div>
        </div>
    </section>

    @include(template().'sections.relaxation_news_letter_two')
    @include(template().'sections.footer')
@endsection
@push('style')
    <style>
        .filled-heart {
            color: red;
        }
    </style>
@endpush
@push('script')

    <script>
        function toggleHeart(element) {
            const isAuthenticated = document.querySelector('meta[name="is-authenticated"]').content === '1';

            if (!isAuthenticated) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            let heartIcon = $(element).find('i.fa-heart');
            let packageId = $(element).data('id');

            if (heartIcon.hasClass('fa-solid')) {
                removeFavorite(packageId);
                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                heartIcon.css('color', '');
            } else {
                addFavorite(packageId);
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                heartIcon.css('color', 'red');
            }
        }

        function addFavorite(packageId) {
            $.ajax({
                url: '{{ route('user.package.reaction') }}',
                type: 'GET',
                data: {
                    package_id: packageId,
                    reaction: 1
                },
                success: function (response) {
                    Notiflix.Notify.success(response.message);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function removeFavorite(packageId) {
            $.ajax({
                url: '{{ route('user.package.reaction') }}',
                type: 'GET',
                data: {
                    package_id: packageId,
                    reaction: 0
                },
                success: function (response) {
                    Notiflix.Notify.success(response.message);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            let $range = $(".js-range-slider");
            let $priceRange = $("#price-range .highlight");
            let currencySymbol = "{{ basicControl()->currency_symbol }}";

            $range.ionRangeSlider({
                type: "double",
                min: {{ $rangeMin }},
                max: {{ $rangeMax }},
                from: {{ $min ?? $rangeMin }},
                to: {{ $max ?? $rangeMax }},
                prettify_separator: "-",
                grid: false,
                onChange: function (data) {
                    $priceRange.text(data.from + currencySymbol + " - " + data.to + currencySymbol);
                }
            });

        });
    </script>
@endpush
