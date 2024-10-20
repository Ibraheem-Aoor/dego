@extends($theme . 'layouts.app')
@section('title', trans('Cars'))

@section('content')
    @include(template() . 'partials.breadcrumb')

    <section class="package">
        <div class="container">
            <div class="row gy-5 g-sm-5">
                <div class="col-lg-3">
                    @include($base_view_path . 'partials.searchBox')
                </div>
                <div class="col-lg-9" id="packageSearch">
                    @include($base_view_path . 'partials.list')
                </div>
            </div>
        </div>
    </section>

    @include(template() . 'sections.relaxation_news_letter_two')
    @include(template() . 'sections.footer')
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
                prettify_separator: "-",
                grid: false,
                onChange: function(data) {
                    $priceRange.text(data.from + currencySymbol + " - " + data.to + currencySymbol);
                }
            });

        });
    </script>
@endpush
