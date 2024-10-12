@extends($theme.'layouts.app')
@section('title',trans('Packages'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="package-section">
        <div class="container">
            <div class="row gy-5 g-sm-5">
                <div class="col-lg-4">
                    @include(template().'package.partials.searchBox')
                </div>
                <div class="col-lg-8" id="packageSearch">
                    <div class="row g-4">
                        @forelse($packages as $item)
                            @php
                                $isFavorite = false;
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

                            @php
                                $params = [
                                    'date' => request()->date,
                                    'adults' => request()->adults,
                                    'children' => request()->children,
                                    'infants' => request()->infants,
                                ];

                                $query = http_build_query(array_filter($params));
                            @endphp
                            <div class="col-md-6">
                                <div class="package-card packageHeight">
                                    <a href="{{ route('package.details', $item->slug) . ($query ? '?' . $query : '') }}">
                                        <div class="thumbs-area">
                                            <img class="packageThumbImage" src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{ $item->title }}">
                                        </div>
                                    </a>
                                    <div class="content-area">
                                        <div class="rate-area">
                                            <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item->id }}" data-toggle="tooltip" title="{{ auth()->check() ? ($isFavorite && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.') : 'add to the favorite list.' }}">
                                                <i class="{{ auth()->check() ? ($isFavorite && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart') : 'fa-regular fa-heart' }}"></i>
                                            </a>
                                        </div>
                                        <span class="location"><i class="fa-regular fa-location-dot"></i> {{ optional($item->cityTake)->name .', '.optional($item->stateTake)->name.', '.optional($item->countryTake)->name }} </span>
                                        <h4 class="title">
                                            <a href="{{ route('package.details', $item->slug) . ($query ? '?' . $query : '') }}">@lang($item->title)</a>
                                        </h4>

                                        <div class="review-area">
                                            <ul class="star-list">
                                                {!! displayStarRating($item->average_rating) !!}
                                            </ul>
                                            <p class="mb-0"> <span>({{ $item->review_count }} @lang('reviews'))</span></p>
                                        </div>

                                        <div class="content-bottom">
                                            <div class="duration">
                                                <i class="fa-regular fa-clock"></i>
                                                {{ $item->duration }}
                                            </div>
                                            <div class="price">
                                                @if($item->discount == 1)
                                                    @php
                                                        $amount = $item->calculateDiscountedPrice();
                                                    @endphp
                                                    <p>@lang('from :')
                                                        <span>{{ currencyPosition($item->adult_price) }}</span>
                                                        <span>{{ currencyPosition($amount) }}</span>
                                                    </p>
                                                @else
                                                    @lang('from :')
                                                    <span>{{ currencyPosition($item->adult_price) }}</span>
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
                </div>
            </div>
        </div>
    </section>
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
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
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
                success: function(response) {
                    Notiflix.Notify.success(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
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
                grid: false,
                onChange: function(data) {
                    $priceRange.text(data.from + currencySymbol + " - " + data.to + currencySymbol);
                }
            });

        });
    </script>

@endpush
