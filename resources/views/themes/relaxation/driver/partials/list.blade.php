    <div class="package-right-container">
    @forelse($drivers as $item)
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

        <div class="package-right-single wow fadeInRight" data-wow-delay="100ms">
            <div class="package-right-image">
                <img src="{{ getFile($item->car->thumb_driver, $item->car->thumb) }}" alt="{{ $item->car->name }}">
                <div class="icon d-none">
                    <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)"
                        data-id="{{ $item->car->id }}" data-toggle="tooltip"
                        title="{{ $isFavorite && auth()->check() && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.' }}">
                        <i
                            class="{{ $isFavorite && auth()->check() && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart' }}"></i>
                    </a>
                </div>
            </div>
            <div class="destination-single-content">
                <h6>@lang($item->transmission_type)
                </h6>
                <a
                    href="{{ route($base_route_path . 'details', encrypt($item->id))}}">@lang($item->car->name)</a>
                {{-- <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 100) }}</p> --}}
                <div class="destination-single-review">
                    <div class="destination-single-review-inner ">
                        <div class="review d-flex gap-2 d-none">
                            <ul>
                                {!! displayStarRating($item->average_rating) !!}
                            </ul>
                            @if ($item->review_count > 0)
                                <div class="review-number">
                                    {{ '( ' . $item->review_count . ' reviews )' }} </div>
                            @endif
                        </div>
                    </div>
                    <div class="destination-single-review-inner">
                        <div class="destination-single-date">
                            <p><i class="fa-light fa-car"></i>{{ ' ' . $item->car->type }}
                            </p>
                        </div>
                        <div class="destination-single-date">
                            <p><i class="fa-light fa-cube"></i>{{ ' ' . $item->car->model }}
                            </p>
                        </div>
                        <div class="destination-single-date">
                            <p><i class="fa-light fa-users"></i>{{ ' ' . $item->car->max_passengers }}
                            </p>
                        </div>
                        @if ($item->discount == 1)
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
    {{ $drivers->appends(request()->query())->links($theme . 'partials.pagination') }}
</div>
