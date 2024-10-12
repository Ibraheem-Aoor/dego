<section class="popular">
    <div class="container">
        <div class="common-title text-center">
            <h2>@lang(@$relaxation_destination['single']['heading_part_one']) <span>@lang(@$relaxation_destination['single']['heading_part_two']) <img src="{{ getFile(@$relaxation_destination['single']['media']->image->driver, @$relaxation_destination['single']['media']->image->path) }}" alt="shape"></span> @lang(@$relaxation_destination['single']['heading_part_three'])</h2>
            <p>{{ @$relaxation_destination['single']['sub_heading'] }}</p>
        </div>
        <div class="row">
            @foreach(@$relaxation_destination['destinations']->toArray() as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="popular-single wow fadeInUp" data-wow-delay="100ms">
                        <div class="popular-single-image">
                            <img src="{{ getFile(@$item['thumb_driver'], @$item['thumb']) }}" alt="{{ @$item['title'] }}">
                        </div>
                        <div class="popular-single-content">
                            @php
                                $isFavorite = false;
                            @endphp

                            @foreach (@$item['reaction'] as $reaction)
                                @if ($reaction['reaction'] == 1)
                                    @php
                                        $isFavorite = true;
                                        $user = $reaction['user_id'];
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                            <div class="icon">
                                <a href="javascript:void(0)" class="item heart-icon" onclick="toggleHeart(this)" data-id="{{ $item['id'] }}" data-type ="destination" data-toggle="tooltip"
                                   title="@auth {{ $isFavorite && $user == auth()->user()->id ? 'remove from the favorite list.' : 'add to the favorite list.' }} @else Please log in to add to the favorite list. @endauth">
                                    <i class="{{ $isFavorite && auth()->check() && $user == auth()->user()->id ? 'fa-solid fa-heart heartActiveColor' : 'fa-regular fa-heart' }}"></i>
                                </a>
                            </div>
                            <div class="popular-single-content-inner">
                                <div class="popular-single-title">
                                    <a href="{{ route('package',['destination'=>@$item['slug']]) }}">{{ @$item['title'] }}</a>

                                    <p>{{ Str::limit(strip_tags(@$item['details']), 70, '') }}</p>
                                </div>
                                <div class="popular-single-btn">
                                    <a href="{{ route('package',['destination' => @$item['slug']]) }}" class="btn-2">@lang('Discover Now')<span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

