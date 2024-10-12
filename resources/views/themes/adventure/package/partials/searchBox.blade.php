
<div class="package-sidebar">
    <div class="d-none d-lg-block">
        <div class="sidebar-widget-area">
            <div class="widget-title">
                <h4>@lang('Search Box')</h4>
            </div>
            <form action="{{ route('package') }}" id="searchForm" method="get">
                <div class="search-box d-flex">
                    <input type="text" class="form-control" name="search" value="{{ request()->search }}" placeholder="Search here...">
                    <button type="submit"><i class="fa-regular fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <div class="sidebar-widget-area">
            <div class="widget-title">
                <h4>@lang('Filter by Price')</h4>
            </div>
            <div class="range-area">
                <input type="text" class="js-range-slider price_range_input" value="{{ $min.';'.$max }}" name="my_range"/>
            </div>
            <h5 class="mt-20" id="price-range">@lang('Price :') <span class="highlight">{{$min ?? $rangeMin}}{{basicControl()->currency_symbol}} - {{$max ?? $rangeMax}}{{basicControl()->currency_symbol}}</span></h5>
        </div>

        <div class="sidebar-widget-area">
            <div class="checkbox-categories-area">
                <div class="widget-title">
                    <h4 class="">@lang('Tour Categories')</h4>
                </div>
                <div class="section-inner">
                    <div class="categories-list">
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input category_input_search" type="checkbox" name="category[]" value="{{ $category->id }}" id="flexCheckChecked{{ $category->id }}" {{ in_array($category->id, (array) request()->input('category', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckChecked{{ $category->id }}">
                                    <span>{{ $category->name }}</span> <span class="highlight">{{ $category->packages_count }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-widget-area">
            <div class="checkbox-categories-area">
                <div class="widget-title">
                    <h4 class="">@lang('Duration')</h4>
                </div>
                <div class="section-inner">
                    <div class="categories-list">
                        @foreach($durations as $item)
                            <div class="form-check">
                                <input class="form-check-input durations_search_input" type="checkbox" name="duration[]"
                                       value="{{ $item }}" id="flexCheckChecked{{ $item }}"
                                    {{ in_array($item, (array) request()->input('duration', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckChecked{{ $item }}">
                                    <span>{{ $item }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-widget-area">
            <div class="checkbox-categories-area">
                <div class="widget-title">
                    <h4 class="">@lang('Rating')</h4>
                </div>
                <div class="section-inner">
                    <div class="categories-list">
                        @php
                            $ratings = request()->input('rating', []);
                            if (is_string($ratings)) {
                                $ratings = explode(',', $ratings);
                            }
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <div class="form-check">
                                <input class="form-check-input rating_search_input" type="checkbox" name="rating[]" value="{{ $i }}" id="flexCheckChecked{{ $i }}" {{ in_array($i, $ratings) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckChecked{{ $i }}">
                                    <ul class="star-list">
                                        <li>
                                            @for($j = 1; $j <= 5; $j++)
                                                <i class="{{ $j <= $i ? 'active' : '' }} fa-solid fa-star"></i>
                                            @endfor
                                        </li>
                                    </ul>
                                </label>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-filter-bar d-lg-none">
        <button class="cmn-btn w-100" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <i class="fa-regular fa-filter-list"></i> @lang('Filters')
        </button>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
             aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">@lang('ackdrop with scrolling')B
                </h5>
                <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="fa-regular fa-arrow-left"></i></button>
            </div>
            <div class="offcanvas-body">
                    <div class="sidebar-widget-area">
                        <div class="widget-title">
                            <h4>@lang('Search Box')</h4>
                        </div>
                        <form action="{{ route('package') }}" id="searchForm" method="get">
                            <div class="search-box d-flex">
                                <input type="text" class="form-control" name="search" value="{{ request()->search }}" placeholder="Search here...">
                                <button type="submit"><i class="fa-regular fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-widget-area">
                        <div class="widget-title">
                            <h4>@lang('Filter by Price')</h4>
                        </div>
                        <div class="range-area">
                            <input type="text" class="js-range-slider price_range_input" value="{{ $min.';'.$max }}" name="my_range" />
                        </div>
                        <h5 class="mt-20" id="price-range">@lang('Price :')
                            <span class="highlight">
                                {{$min ?? $rangeMin}}{{basicControl()->currency_symbol}} - {{$max ?? $rangeMax}}{{basicControl()->currency_symbol}}
                            </span>
                        </h5>
                    </div>
                <div class="sidebar-widget-area">
                    <div class="checkbox-categories-area">
                        <div class="widget-title">
                            <h4 class="">@lang('Tour type')</h4>
                        </div>
                        <div class="section-inner">
                            <div class="categories-list">
                                @foreach($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input category_input_search" type="checkbox" name="category[]"
                                               value="{{ $category->id }}" id="flexCheckChecked{{ $category->id }}"
                                            {{ in_array($category->id, (array) request()->input('category', [])) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="flexCheckChecked{{ $category->id }}">
                                            <span>{{ $category->name }}</span> <span class="highlight">{{ $category->packages_count }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-widget-area">
                    <div class="checkbox-categories-area">
                        <div class="widget-title">
                            <h4 class="">@lang('Duration')</h4>
                        </div>
                        <div class="section-inner">
                            <div class="categories-list">
                                @foreach($durations as $item)
                                    <div class="form-check">
                                        <input class="form-check-input durations_search_input" type="checkbox" name="duration[]" value="{{  $item }}"
                                               id="flexCheckChecked{{ $item }}" {{ request()->duration == $item ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <span>{{ $item }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-widget-area">
                    <div class="checkbox-categories-area">
                        <div class="widget-title">
                            <h4 class="">@lang('Rating')</h4>
                        </div>
                        <div class="section-inner">
                            <div class="categories-list">
                                @for($i = 1; $i <= 5; $i++) <div class="form-check">
                                    <input class="form-check-input rating_search_input" type="checkbox" name="rating[]" value="{{ $i }}"
                                           id="flexCheckChecked{{ $i }}" {{ $i==request()->rating ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckChecked{{ $i }}">
                                        <ul class="star-list">
                                            <li>
                                                @for($j = 1; $j <= 5; $j++) <i
                                                        class="{{ $j <= ($i - (-1)) ? 'active' : '' }} fa-solid fa-star"></i>
                                                @endfor
                                            </li>
                                        </ul>
                                    </label>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .irs--flat .irs-bar {
            background-color: var(--primary-color) !important;
        }

        .irs--flat .irs-from,
        .irs--flat .irs-to,
        .irs--flat .irs-single {
            background-color: var(--primary-color) !important;
            /*color: gree !important; !* For text inside the handle *!*/
        }

        .irs--flat .irs-handle {
            background-color: var(--primary-color) !important;
        }

        .irs--flat .irs-bar-edge,
        .irs--flat .irs-handle {
            border: none !important;
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        function getFilters() {
            let categories = [];
            let durations = [];
            let ratings = [];
            let priceRange = $('.price_range_input').val();

            $('.category_input_search:checked').each(function() {
                categories.push($(this).val());
            });

            $('.durations_search_input:checked').each(function() {
                durations.push($(this).val());
            });

            $('.rating_search_input:checked').each(function() {
                ratings.push($(this).val());
            });

            return {
                categories: categories,
                durations: durations,
                ratings: ratings,
                priceRange: priceRange
            };
        }

        function performAjaxRequest() {
            let filters = getFilters();

            setTimeout(function() {
                Notiflix.Loading.standard('Searching...');
            }, 100);

            $.ajax({
                url: 'packages',
                method: 'GET',
                data: {
                    category: filters.categories,
                    duration: filters.durations,
                    rating: filters.ratings,
                    my_range: filters.priceRange
                },
                success: function(response) {
                    $('#packageSearch').html(response.html);
                    $('#pagination').html(response.pagination);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                },
                complete: function() {
                    Notiflix.Loading.remove();
                }
            });
        }

        $(document).ready(function () {
            let priceRangeTimeout;

            function onPriceRangeChange() {
                clearTimeout(priceRangeTimeout);

                priceRangeTimeout = setTimeout(function() {
                    performAjaxRequest();
                }, 2000);
            }

            function updateFilterParams(filterType, inputClass) {
                $(inputClass).on('click', function () {
                    let checkedVal = $(this).val();
                    const url = new URL(window.location.href);
                    const urlParams = url.searchParams;
                    let filterParams = urlParams.get(filterType)?.split(",") || [];

                    if (this.checked) {
                        filterParams.push(checkedVal);
                    } else {
                        filterParams = filterParams.filter(val => val !== checkedVal);
                    }

                    if (filterParams.length > 0) {
                        urlParams.set(filterType, filterParams.join(","));
                    } else {
                        urlParams.delete(filterType);
                    }

                    window.history.pushState("data", "", url.pathname + '?' + urlParams.toString().replace(/%2C/g, ","));
                });
            }

            updateFilterParams('category', '.category_input_search');
            updateFilterParams('duration', '.durations_search_input');
            updateFilterParams('rating', '.rating_search_input');

            $('.price_range_input').on('change', onPriceRangeChange);

            $('.category_input_search').on('change', function() {
                performAjaxRequest();
            });

            $('.durations_search_input').on('change', function() {
                performAjaxRequest();
            });

            $('.rating_search_input').on('change', function() {
                performAjaxRequest();
            });
        });

    </script>
@endpush
