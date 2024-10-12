@extends($theme.'layouts.app')
@section('title',trans('Package Details'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="package-details-section">
        <div class="container">
            <div class="row g-xl-5 g-4">
                <div class="col-lg-8 order-2 order-lg-1">
                    <div class="fancybox-carousel-section">
                        <div id="mainCarousel" class="carousel mx-auto fancybox-carousel">
                            @foreach($package->media as $item)
                                <div class="carousel__slide" data-src="{{ getFile($item->driver, $item->image) }}"
                                     data-fancybox="gallery" data-caption="{{ $package->title }}">
                                    <img class="img-fluid" src="{{ getFile($item->driver, $item->image) }}" alt="{{ $package->title }}">
                                </div>
                            @endforeach
                        </div>

                        <div id="thumbCarousel" class="carousel max-w-xl mx-auto thumb_carousel">
                            @foreach($package->media as $item)
                                <div class="carousel__slide">
                                    <img class="panzoom__content img-fluid" src="{{ getFile($item->driver, $item->image) }}" alt="{{ $package->title }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-header">
                        <h3 class="title">@lang($package->title)</h3>
                        <div class="location-review">
                            <span class="location"><i class="fa-regular fa-location-dot"></i>{{ optional($package->cityTake)->name .', '.optional($package->stateTake)->name .', '. optional($package->countryTake)->name }}</span>
                            @if($package->review_average >0)
                                <div class="review-area">
                                    <ul class="star-list">
                                        {!! displayStarRating($package->review_average) !!}
                                    </ul>
                                    <p class="mb-0"><span>{{ $package->review_average }} </span> <span>({{$package->review_count }} @lang('reviews'))</span></p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Feature area start  -->
                    <div class="feature-area">
                        <div class="row g-4">
                            <div class="col-lg-3 col-6">
                                <div class="feature-box">
                                    <div class="icon-area">
                                        <i class="fa-light fa-clock"></i>
                                    </div>
                                    <div class="content-area">
                                        <h5 class="mb-0">@lang('Duration')</h5>
                                        <span>@lang( $package->duration )</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="feature-box">
                                    <div class="icon-area">
                                        <i class="fa-light fa-rocket-launch"></i>
                                    </div>
                                    <div class="content-area">
                                        <h5 class="mb-0">@lang('Tour Type')</h5>
                                        <span>{{optional($package->category)->name}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="feature-box">
                                    <div class="icon-area">
                                        <i class="fa-light fa-user"></i>
                                    </div>
                                    <div class="content-area">
                                        <h5 class="mb-0">@lang('Min Travelers')</h5>
                                        <span>{{ $package->minimumTravelers.' People' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="feature-box">
                                    <div class="icon-area">
                                        <i class="fa-light fa-user-cowboy"></i>
                                    </div>
                                    <div class="content-area">
                                        <h5 class="mb-0">@lang('Maximum Travelers')</h5>
                                        <span>{{ $package->maximumTravelers.' People' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="package-details-nav">
                        <li>
                            <a href="#overview-area" class="nav-link active">@lang('Overview')</a>
                        </li>
                        @if($package->facility)
                            <li>
                                <a href="#included-area" class="nav-link">@lang('Included')</a>
                            </li>
                        @endif
                        @if($package->excluded)
                            <li>
                                <a href="#excluded-area" class="nav-link">@lang('Excluded')</a>
                            </li>
                        @endif
                        <li>
                            <a href="#map-section" class="nav-link">@lang('Tour Map') </a>
                        </li>
                        @if(isset($package->review) && $package->review->count() > 0)
                        <li>
                            <a href="#review-section" class="nav-link">@lang('Reviews')</a>
                        </li>
                        @endif
                    </ul>
                    <div class="content-product">
                        <div id="overview-area" class="overview-area">
                            <h4 class="title">@lang('Overview')</h4>
                            {!! $package->description !!}
                        </div>
                    </div>
                    @if($package->facility)
                        <div class="content-product">
                            <div id="included-area" class="included-area">
                                <h4 class="title">@lang('Included')</h4>
                                <ul class="cmn-list">
                                    @foreach($package->facility as $key =>$item)
                                        <li class="item"><i class="fa-regular fa-circle-check"></i>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if($package->excluded)
                        <div class="content-product">
                            <div id="excluded-area" class="excluded-area">
                                <h4 class="title">@lang('Excluded')</h4>
                                <ul class="cmn-list">
                                    @foreach($package->excluded as $key =>$item)
                                        <li class="item"><i class="fa-regular fa-times text-danger"></i>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if(isset($package->map))
                        <div class="content-product">
                            <div id="map-section" class="map-section mt-50">
                                <h4 class="title">@lang('Tour Map')</h4>
                                <iframe
                                    src="{{ $package->map }}"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                    width="600" height="450">
                                </iframe>
                            </div>
                        </div>
                    @endif
                    @include(template().'package.partials.review')
                </div>
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="package-sidebar">
                        <div class="sidebar-widget-area">
                            <div class="widget-title">
                                <h4>@lang('Booking Tour')</h4>
                            </div>
                            @if($package->status == 1)
                                <form id="bookingInformationForm" class="form" action="{{ route('user.checkout.form', $package->slug) }}" method="post">
                                    @csrf

                                    <div class="mb-15">
                                        <h6 class="title">@lang('Date')</h6>
                                        <div class="schedule-form">
                                            <input type="text" class="form-control" name="date" value="{{ request()->date }}"
                                                   id="myID">
                                        </div>
                                        <span id="inputDateError" class="text-danger"></span>
                                    </div>
                                    <div class="cmn-list">
                                        <div class="cmn-item">
                                            <div class="content-area">
                                                <h6 class="title">@lang('Adults')</h6>
                                                <span>@lang('Over 18+')</span>
                                            </div>
                                            <div class="increment-decrement-area">
                                                <span class="decrement btn-hover"><i class="fa-regular fa-minus"></i></span>
                                                <div class="quantity">0</div>
                                                <span class="increment btn-hover"><i class="fa-regular fa-plus"></i></span>
                                            </div>
                                        </div>

                                        <div class="cmn-item">
                                            <div class="content-area">
                                                <h6 class="title">@lang('Children')</h6>
                                                <span>@lang('Under 12')</span>
                                            </div>
                                            <div class="increment-decrement-area">
                                                <span class="decrement btn-hover"><i class="fa-regular fa-minus"></i></span>
                                                <div class="quantity">0</div>
                                                <span class="increment btn-hover"><i class="fa-regular fa-plus"></i></span>
                                            </div>
                                        </div>

                                        <div class="cmn-item">
                                            <div class="content-area">
                                                <h6 class="title">@lang('Infant')</h6>
                                                <span>@lang('Under 3')</span>
                                            </div>
                                            <div class="increment-decrement-area">
                                                <span class="decrement btn-hover"><i class="fa-regular fa-minus"></i></span>
                                                <div class="quantity">0</div>
                                                <span class="increment btn-hover"><i class="fa-regular fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="totalAdult" id="totalAdult" value="">
                                        <input type="hidden" name="totalChildren" id="totalChildren" value="">
                                        <input type="hidden" name="totalInfant" id="totalInfant" value="">
                                        <div class="cmn-item">
                                            <h5>@lang('Total')</h5>
                                            <h5 ><span id="totalPrice">0</span> <span>{{ basicControl()->base_currency }}</span></h5>
                                        </div>
                                        <span id="inputPersonError" class="text-danger"></span>
                                    </div>
                                    <div class="btn-area mt-20">
                                        <button type="submit" id="bookNowBtn" class="cmn-btn2 w-100">@lang('book now')</button>
                                    </div>
                                </form>

                            @elseif($package->status == 0)
                                <div class="text-center">
                                    <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                    <p>@lang('This Package is not available for booking.')<i class="fa-regular fa-face-meh"></i></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($package->related_packages->count() > 0)
        <section class="popular-tour-section pt-50">
            <div class="container-fluid">
                <div class="row">
                    <div class="section-header text-center">
                        <div class="section-subtitle">@lang('Similar tours')</div>
                        <h2 class="section-title mx-auto">@lang('Explore our promoted experiences')</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="owl-carousel owl-theme carousel-area1">
                        @foreach($package->related_packages as $item)
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
                            <div class="item">
                                <div class="package-card">
                                    <a href="{{ route('package.details', $item->slug) }}">
                                        <div class="thumbs-area">
                                            <img class="packageThumb" src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{ $item->title }}">
                                        </div>
                                    </a>
                                    <div class="content-area">
                                        <div class="rate-area">
                                            @auth
                                                <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item->id }}" data-toggle="tooltip" title="{{ $isFavorite && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.' }}">
                                                    <i class="{{ $isFavorite && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart' }}"></i>
                                                </a>
                                            @endauth
                                            @guest
                                                <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item->id }}" data-toggle="tooltip" title="add to the favorite list.">
                                                    <i class="fa-regular fa-heart"></i>
                                                </a>
                                            @endguest
                                        </div>
                                        <span class="location"><i class="fa-regular fa-location-dot"></i> {{ optional($item->cityTake)->name .', '.optional($item->stateTake)->name.', '.optional($item->countryTake)->name }}</span>
                                        <h4 class="title"><a href="{{ route('package.details', $item->slug)}}">{{ $item->title }}</a></h4>
                                        <div class="review-area">
                                            <ul class="star-list">
                                                {!! displayStarRating($item->review_avg_rating) !!}
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
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include(template().'sections.footer')
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/fancybox.css') }}">
    <style>
        .btn-hover:hover .fa-plus {
            color: var(--primary-color);
            cursor: pointer;
        }
        .btn-hover:hover .fa-minus{
            color: var(--orange);
            cursor: pointer;
        }
        .section-title{
            max-width: none;
        }
        .package-details-section .content-product h3 {
            font-size: 22px;
        }

    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script src="{{ asset($themeTrue.'js/fancybox.umd.js')}}"></script>
    <script>
        const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
            Dots: false,
        });
        const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
            Sync: {
                target: mainCarousel,
                friction: 0,
            },
            Dots: false,
            Navigation: false,
            center: true,
            slidesPerPage: 1,
            infinite: true,
        });
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

            disable: disabledRanges.map(range => ({ from: range.from, to: range.to })),
        });
        document.addEventListener("DOMContentLoaded", function() {
            const incrementButtons = document.querySelectorAll('.increment');
            const decrementButtons = document.querySelectorAll('.decrement');
            const quantityDisplays = document.querySelectorAll('.quantity');

            let quantities = [0, 0, 0];
            const maximumTravelers = <?php echo $package->maximumTravelers; ?>;
            const adultPrice = <?php echo $package->adult_price; ?>;
            const childrenPrice = <?php echo $package->children_Price; ?>;
            const infantPrice = <?php echo $package->infant_price; ?>;


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
    </script>
@endpush
