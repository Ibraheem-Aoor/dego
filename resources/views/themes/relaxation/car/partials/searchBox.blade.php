
    <div class="package-left-container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="package-left-form">
                    <h6>@lang('Search')</h6>
                    <form action="{{ route($base_route_path.'index') }}" id="searchForm" method="get">
                        <div class="search-form">
                            <input type="text" class="form-control" name="search" value="@lang(request()->search)" placeholder="Search here...">
                            <button type="submit" class="d-none"></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12 col-md-6">
                <div class="package-left-content pt-3">
                    <div class="checkbox-categories-area">
                        <h6 class="package-left-common-title">@lang('Transmission Type')</h6>
                        <div class="section-inner">
                            <div class="categories-list">
                                @foreach($transmission_types as $transmission_type)
                                    <div class="form-check">
                                        <input class="form-check-input category_input_search" type="checkbox" name="transmission_types[]" value="{{ $transmission_type->value}}"
                                               id="flexCheckChecked{{ $transmission_type->value}}"
                                            {{ in_array($transmission_type->value, (array) request()->input('transmission_types', [])) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="flexCheckChecked{{ $transmission_type->value}}">
                                            <span>{{ $transmission_type->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-6">
                <div class="package-left-content">
                    <div class="package-left-content-inner">
                        <h6 class="package-left-common-title">@lang('Engine')</h6>
                        <div class="package-left-duration">
                            @php
                                $selectedDurations = request()->input('engine_type', []);
                            @endphp
                            @foreach($engine_types as $item)
                                <div class="form-check">
                                    <input class="form-check-input durations_search_input" type="checkbox" name="engine_types[]"
                                           value="{{  $item->value }}" id="flexCheckChecked{{ $item->value }}"
                                        {{ in_array($item->value, (array) $selectedDurations) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckChecked{{ $item->value }}">
                                        <span>{{ $item->value }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-6">
                <div class="package-left-content">
                    <div class="package-left-content-inner">
                        <h6 class="package-left-common-title">@lang('Price')</h6>
                        <div class="range-sidebar-form">
                            <div class="range-slider clearfix p_relative">
                                <div class="range-area">
                                    <input type="text" class="js-range-slider price_range_input" value="{{ $min.';'.$max }}" name="my_range"/>
                                </div>
                                <h5 class="range_show rangeInfo" id="price-range">@lang('Range:') <span class="highlight">{{$min ?? $rangeMin}}{{basicControl()->currency_symbol}} - {{$max ?? $rangeMax}}{{basicControl()->currency_symbol}}</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <style>
            .checkbox-categories-area .categories-list {
                padding-right: 5px;
            }

            .checkbox-categories-area .form-check {
                margin: 10px 0;
            }

            .checkbox-categories-area .form-check .form-check-input {
                cursor: pointer;
                border-radius: 5px;
            }

            .checkbox-categories-area .form-check .form-check-input:checked + .form-check-label {
                color: var(--primary-color);
            }

            .checkbox-categories-area .form-check .form-check-label {
                display: flex;
                justify-content: space-between;
                cursor: pointer;
            }

            .btn-2{
                background-color: var(--secondary-color)!important;
                color: #e7e7e7;
            }



            /* To change the main slider track background color */
            .irs--flat .irs-bar {
                background-color: var(--praimary-color) !important;
            }

            .irs--flat .irs-from,
            .irs--flat .irs-to,
            .irs--flat .irs-single {
                background-color: var(--praimary-color) !important;
                /*color: gree !important; !* For text inside the handle *!*/
            }

            .irs--flat .irs-handle {
                background-color: var(--praimary-color) !important;
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
                    url: "{{ route($base_route_path.'index') }}",
                    method: 'GET',
                    data: {
                        transmission_types: filters.categories,
                        engine_types: filters.durations,
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

                updateFilterParams('transmission_type', '.category_input_search');
                updateFilterParams('engine_type', '.durations_search_input');

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

