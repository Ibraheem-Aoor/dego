@extends($theme.'layouts.app')
@section('title',trans('Destination'))
@section('content')
    @include(template().'partials.breadcrumb')
    <section class="popular popular-destination">
        <div class="container">
            <div class="common-title text-center">
                @foreach($content->contentDetails as $details)
                    <h2> @lang(optional($details->description)->heading) <span>@lang(optional($details->description)->heading_two)<img src="{{ getFile(optional(optional($content->media)->image_two)->driver, optional(optional($content->media)->image_two)->path) }} " alt="shape"></span> @lang(optional($details->description)->heading_three)</h2>
                    <p>@lang(optional($details->description)->sub_heading)</p>
                @endforeach
            </div>
            <div class="row d-flex align-items-center justify-content-center">
                @forelse($destinations as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="popular-single wow fadeInUp" data-wow-delay="100ms">
                            <div class="popular-single-image">
                                <img src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{ $item->title }}">
                            </div>
                            <div class="popular-single-content">
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
                                <div class="icon">
                                    <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item->id }}" data-toggle="tooltip"
                                       title="@auth {{ $isFavorite && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.' }} @else add to the favorite list. @endauth">
                                        <i class="{{ $isFavorite && auth()->check() && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart' }}"></i>
                                    </a>
                                </div>
                                <div class="popular-single-content-inner">
                                    <div class="popular-single-title">
                                        <a href="{{ route('package',['destination'=> $item->slug]) }}">@lang($item->title)</a>
                                        <p>{{ Str::limit(strip_tags($item['details']), 60,'') }}</p>
                                    </div>
                                    <div class="popular-single-btn">
                                        <a href="{{ route('package',['destination'=>$item->slug]) }}" class="btn-2">@lang('Discover Now') <span></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <th colspan="100%" class="text-center text-dark">
                            <div class="no_data_iamge text-center">
                                <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                            </div>
                            <p class="text-center">@lang('Destination List is empty here!.')</p>
                        </th>
                    </tr>
                @endforelse
                {{ $destinations->appends(request()->query())->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>
    @if(isset($packages))
    <section class="destination">
        <div class="bg-layer" style="background: url({{ getFile($content->media->image_two->driver, $content->media->image_two->path) }});"></div>
        <div class="container">
            <div class="common-title text-center">
                @foreach($content->contentDetails as $details)
                    <h2> @lang(optional($details->description)->popular_heading) <span>@lang(optional($details->description)->popular_heading_two)<img src="{{ getFile(optional(optional($content->media)->image_two)->driver, optional(optional($content->media)->image_two)->path) }} " alt="shape"></span> @lang(optional($details->description)->popular_heading_three)</h2>
                    <p>@lang($details->description->popular_sub_heading)</p>
                @endforeach
            </div>
            <div class="row">
                @forelse($packages as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="destination-single wow fadeInUp" data-wow-delay="100ms">
                            <div class="destination-single-image">
                                <img src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="image">
                            </div>
                            <div class="destination-single-content">
                                <div>
                                    <h6>{{ optional($item->cityTake)->name .', '.optional($item->stateTake)->name.', '.optional($item->countryTake)->name }}</h6>
                                    <a href="{{ route('package.details', $item->slug) }}">@lang($item->title)</a>
                                </div>
                                <div class="destination-single-review">
                                    <div class="destination-single-review-inner">
                                        <div class="review d-flex gap-2">
                                            <ul>
                                                {!! displayStarRating($item->average_rating) !!}
                                            </ul>
                                            <div class="review-number">{{ '( '. $item->review_count .' reviews )' }} </div>
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
                                            <p><i class="fa-light fa-clock"></i> {{ $item->duration}}</p>
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
            </div>
        </div>
    </section>
    @endif


    @include(template().'sections.relaxation_news_letter_two')
    @include(template().'sections.footer')
@endsection

@push('script')
    <script>
        function toggleHeart(element) {
            const isAuthenticated = document.querySelector('meta[name="is-authenticated"]').content === '1';

            if (!isAuthenticated) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            let heartIcon = $(element).find('i.fa-heart');
            let destinationId = $(element).data('id');

            if (heartIcon.hasClass('fa-solid')) {
                removeFavorite(destinationId);
                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                heartIcon.css('color', '');
            } else {
                addFavorite(destinationId);
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                heartIcon.css('color', 'red');
            }
        }

        function addFavorite(destinationId) {
            $.ajax({
                url: '{{ route('user.destination.reaction') }}',
                type: 'GET',
                data: {
                    destination_id: destinationId,
                    reaction: 1
                },
                success: function(response) {
                    Notiflix.Notify.success(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function removeFavorite(destinationId) {
            $.ajax({
                url: '{{ route('user.destination.reaction') }}',
                type: 'GET',
                data: {
                    destination_id: destinationId,
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

        document.querySelectorAll('.destinationLink').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                let destinationId = this.getAttribute('data-destination-id');
                let csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    url: '{{ route('destination.track') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        destination_id: destinationId
                    },
                    success: function(response) {
                        window.location.href = '{{ route('package', ['destination' => '']) }}'+ destinationId;
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endpush
