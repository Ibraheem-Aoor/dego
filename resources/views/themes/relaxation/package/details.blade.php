@extends($theme.'layouts.app')
@section('title',trans('Package Details'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="destination-details">
        <div class="container">
            <div class="destination-details-title-box">
                <div class="destination-details-title">
                    <h3>@lang($package->title)</h3>
                </div>
                <div class="destination-details-review">
                    @if($package->review_average >0)
                        <ul class="review-star">
                            {!! displayStarRating($package->review_average) !!}
                            <p class="mb-0">{{$package->review_count .' reviews' }} </p>
                        </ul>
                    @endif

                    <div class="destination-details-review-text">
                        <span><i class="fa-regular fa-location-dot"></i>
                            {{ optional($package->cityTake)->name .', '.optional($package->stateTake)->name .', '. optional($package->countryTake)->name }}
                        </span>
                    </div>
                </div>
            </div>
            @include(template().'package.partials.detailsPart')
        </div>
    </section>
    @if($package->related_packages->count() > 0)
        @include(template().'package.partials.popular_package')
    @endif
    @include(template().'sections.relaxation_news_letter_two')
    @include(template().'sections.footer')
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
        .lightbox-image img{
            border-radius: 10px;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script>
        function toggleMap(containerId, frameId, mapUrl) {
            let mapContainer = document.getElementById(containerId);
            let mapFrame = document.getElementById(frameId);

            if (mapContainer.style.display === 'block') {
                mapContainer.style.display = 'none';
            } else {
                mapFrame.src = mapUrl;
                mapContainer.style.display = 'block';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreButton = document.querySelector('.load-more');
            const loadLessButton = document.querySelector('.load-less');
            const hiddenItems = document.querySelectorAll('.destination-details-expect-content.d-none');
            const allItems = document.querySelectorAll('.destination-details-expect-content');

            if (loadMoreButton) {
                loadMoreButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    hiddenItems.forEach(item => {
                        item.classList.remove('d-none');
                    });
                    loadMoreButton.classList.add('d-none');
                    if (loadLessButton) {
                        loadLessButton.classList.remove('d-none');
                    }
                });
            }

            if (loadLessButton) {
                loadLessButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    allItems.forEach((item, index) => {
                        if (index >= 2) {
                            item.classList.add('d-none');
                        }
                    });
                    loadLessButton.classList.add('d-none');
                    if (loadMoreButton) {
                        loadMoreButton.classList.remove('d-none');
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            const limit = {{ $package->maximumTravelers }};
            const errorMessage = document.getElementById('inputPersonError');

            document.querySelectorAll('.increment, .decrement').forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    const target = document.getElementById(targetId);
                    if (!target) {
                        console.error(`Element with ID ${targetId} not found.`);
                        return;
                    }

                    let currentQuantity = parseInt(target.textContent);
                    let newQuantity = currentQuantity;

                    if (button.classList.contains('increment')) {
                        newQuantity += 1;
                    } else if (button.classList.contains('decrement')) {
                        newQuantity = Math.max(0, newQuantity - 1);
                    }

                    const totalQuantity =
                        parseInt(document.getElementById('adult-quantity').textContent) +
                        parseInt(document.getElementById('children-quantity').textContent) +
                        parseInt(document.getElementById('infant-quantity').textContent) - currentQuantity + newQuantity;

                    if (totalQuantity > limit) {
                        errorMessage.textContent = `Maximum ${limit} people allowed.`;
                        errorMessage.style.display = 'block';
                        return;
                    } else {
                        errorMessage.style.display = 'none';
                    }

                    target.textContent = newQuantity;

                    if (targetId === 'adult-quantity') {
                        document.getElementById('adult').textContent = newQuantity;
                    } else if (targetId === 'children-quantity') {
                        document.getElementById('child').textContent = newQuantity;
                    } else if (targetId === 'infant-quantity') {
                        document.getElementById('infant').textContent = newQuantity;
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            let disabledRanges = [
                    @foreach($bookingDate as $range)
                {
                    from: '{{$range["date"]}}',
                    to: '{{$range["date"]}}',
                    message: '{{$range["message"]}}'
                },
                @endforeach
            ];

            flatpickr('#myID', {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: 'today',
                disableMobile: "true",
                disable: disabledRanges.map(range => ({from: range.from, to: range.to})),
            });

            console.log("Flatpickr initialized.");
        });

        document.addEventListener("DOMContentLoaded", function () {
            let quantities = [
                parseInt(document.getElementById('adult-quantity').textContent) || 0,
                parseInt(document.getElementById('children-quantity').textContent) || 0,
                parseInt(document.getElementById('infant-quantity').textContent) || 0
            ];

            const adultPrice = {{ $package->adult_price }};
            const childrenPrice = {{ $package->children_Price }};
            const infantPrice = {{ $package->infant_price }};
            const incrementButtons = document.querySelectorAll('.increment');
            const decrementButtons = document.querySelectorAll('.decrement');
            const quantityDisplays = document.querySelectorAll('.quantity');
            const maximumTravelers = {{ $package->maximumTravelers }};

            function incrementQuantity(index) {
                if (quantities.reduce((total, amount) => total + amount, 0) < maximumTravelers) {
                    quantities[index]++;
                    quantityDisplays[index].textContent = quantities[index];
                    updateTotalPrice();
                }
            }

            function decrementQuantity(index) {
                if (quantities[index] > 0) {
                    quantities[index]--;
                    quantityDisplays[index].textContent = quantities[index];
                    updateTotalPrice();
                }
            }

            function updateTotalPrice() {
                const totalAdults = quantities[0];
                const totalChildren = quantities[1];
                const totalInfant = quantities[2];
                const totalPerson = totalAdults + totalChildren + totalInfant;
                const totalPrice = (totalAdults * adultPrice) + (totalChildren * childrenPrice) + (totalInfant * infantPrice);
                let finalPrice = totalPrice;
                const discount = {{ $package->discount }};
                if (discount == 1) {
                    const discountType = {{ $package->discount_type }};
                    const discountAmount = {{ $package->discount_amount ?? 0 }};
                    if (discountType == 0) {
                        finalPrice = totalPrice - (totalPrice * discountAmount / 100);
                    } else if (discountType == 1) {
                        finalPrice = totalPrice - discountAmount;
                    }
                }
                if (totalPerson == 0){
                    finalPrice = 0;
                }
                document.getElementById('totalPrice').textContent = finalPrice.toFixed(2);
            }

            incrementButtons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    incrementQuantity(index);
                });
            });

            decrementButtons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    decrementQuantity(index);
                });
            });

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

                const quantityDisplays = document.querySelectorAll('.quantity');
                const totalAdults = parseInt(quantityDisplays[0].textContent);
                const totalChildren = parseInt(quantityDisplays[1].textContent);
                const totalInfant = parseInt(quantityDisplays[2].textContent);
                const totalPerson = totalAdults + totalChildren + totalInfant;

                if (totalPerson < 1) {
                    inputPersonError.textContent = 'Minimum one person required.';
                    return;
                } else {
                    inputPersonError.textContent = '';
                }

                if (totalAdults === 0 && (totalChildren > 0 || totalInfant > 0)) {
                    inputPersonError.textContent = 'At least one adult person required.';
                    return;
                } else {
                    inputPersonError.textContent = '';
                }

                document.getElementById('totalAdult').value = totalAdults;
                document.getElementById('totalChildren').value = totalChildren;
                document.getElementById('totalInfant').value = totalInfant;

                document.getElementById('bookingInformationForm').submit();
            });
        });
        $(document).ready(function () {
            $('.star-rating').each(function () {
                let rating = parseFloat($(this).data('rating'));
                let fullStars = Math.floor(rating);
                let halfStar = (rating % 1 !== 0);

                for (let i = 1; i <= fullStars; i++) {
                    $(this).append('<i class="fas fa-star"></i>');
                }

                if (halfStar) {
                    $(this).append('<i class="fas fa-star-half-alt half"></i>');
                }

                let unfilledStars = 5 - Math.ceil(rating);
                for (let j = 1; j <= unfilledStars; j++) {
                    $(this).append('<i class="far fa-star"></i>');
                }
            });

            let adultQuantity = parseInt($('#adult-quantity').text());
            let childrenQuantity = parseInt($('#children-quantity').text());
            let infantQuantity = parseInt($('#infant-quantity').text());

            adultQuantity = isNaN(adultQuantity) ? 0 : adultQuantity;
            childrenQuantity = isNaN(childrenQuantity) ? 0 : childrenQuantity;
            infantQuantity = isNaN(infantQuantity) ? 0 : infantQuantity;

            const adultPrice = {{ $package->adult_price }};
            const childrenPrice = {{ $package->children_Price }};
            const infantPrice = {{ $package->infant_price }};

            const totalPrice = (adultQuantity * adultPrice) + (childrenQuantity * childrenPrice) + (infantQuantity * infantPrice);

            $('#totalPrice').text(totalPrice);
        });

    </script>
@endpush
