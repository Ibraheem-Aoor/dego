@extends($theme . 'layouts.app')
@section('title', trans('Car Details'))

@section('content')
    @include(template() . 'partials.breadcrumb')
    <section class="destination-details">
        <div class="container">
            <div class="destination-details-title-box">
                <div class="destination-details-title">
                    <h3>@lang($car->name)</h3>
                </div>
                {{-- <div class="destination-details-review">
                    @if ($car->review_average > 0)
                        <ul class="review-star">
                            {!! displayStarRating($car->review_average) !!}
                            <p class="mb-0">{{$car->review_count .' reviews' }} </p>
                        </ul>
                    @endif

                    <div class="destination-details-review-text">
                        <span><i class="fa-regular fa-location-dot"></i>
                            {{ optional($car->cityTake)->name .', '.optional($car->stateTake)->name .', '. optional($car->countryTake)->name }}
                        </span>
                    </div>
                </div> --}}
            </div>
            @include($base_view_path . '.partials.detailsPart')
        </div>
    </section>
    @if ($car?->related_packages?->count() > 0)
        @include($base_view_path . '.partials.popular_package')
    @endif
    @include(template() . 'sections.relaxation_news_letter_two')
    @include(template() . 'sections.footer')
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <style>
        .btn-hover:hover .fa-plus {
            color: var(--primary-color);
            cursor: pointer;
        }

        .btn-hover:hover .fa-minus {
            color: var(--orange);
            cursor: pointer;
        }

        .lightbox-image img {
            border-radius: 10px;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue . 'js/flatpickr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let disabledRanges = [
                @foreach ($bookingDate as $range)
                    {
                        from: '{{ $range['date'] }}',
                        to: '{{ $range['date'] }}',
                        message: '{{ $range['message'] }}'
                    },
                @endforeach
            ];

            flatpickr('#myID', {
                enableTime: false,
                mode: "multiple",
                dateFormat: "Y-m-d",
                minDate: 'today',
                disableMobile: "true",
                disable: disabledRanges.map(range => ({
                    from: range.from,
                    to: range.to
                })),
            });

            console.log("Flatpickr initialized.");
            const bookNowBtn = document.getElementById('bookNowBtn');
            bookNowBtn.addEventListener('click', function(event) {
                event.preventDefault();

                const dateField = document.getElementById('myID');
                const date = dateField.value.trim();

                if (!date) {
                    inputDateError.textContent = 'Date is required.';
                    return;
                } else {
                    inputDateError.textContent = '';
                }



                document.getElementById('bookingInformationForm').submit();
            });
        });
    </script>
@endpush
