<section class="adventure">
    <div class="map-right-shape">
        <img src="{{ getFile(@$relaxation_adventure['single']['media']->image->driver, @$relaxation_adventure['single']['media']->image->path) }}" alt="Adventure Image One">
    </div>
    <div class="map-left-shape">
        <img src="{{ getFile($relaxation_adventure['single']['media']->image_two->driver, @$relaxation_adventure['single']['media']->image_two->path) }}" alt="Adventure Image Two">
    </div>
    <div class="common-title text-center">
        <h2>{{ @$relaxation_adventure['single']['heading_part_one'] }}
            <span>{{ @$relaxation_adventure['single']['heading_part_two'] }}
                <img src="{{ getFile(@$relaxation_adventure['single']['media']->image_three->driver, @$relaxation_adventure['single']['media']->image_three->path) }}" alt="shape">
            </span>
        </h2>
        <p class="mt_15">{{ @$relaxation_adventure['single']['sub_heading'] }}</p>
    </div>
    <div class="adventure-container">
        <div class="adventure-carousol">
            <div class="four-item-carousel swiper-container adventure-carousol-container">
                <div class="swiper-wrapper">
                    @foreach(@$relaxation_adventure['destinations']->toArray() as $item)

                        <div class="swiper-slide">
                            <div class="adventure-carousol-single wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                                <div class="adventure-carousol-single-image">
                                    <img src="{{ getFile(@$item['thumb_driver'], @$item['thumb']) }}" alt="{{ @$item['title'] }}">
                                </div>
                                <div class="adventure-carousol-single-content">
                                    <a href="{{ route('package', ['destination' => @$item['slug']]) }}">{{ @$item['title'] }}</a>
                                    <p>{{ Str::limit(strip_tags(@$item['details']), 100,'') }}</p>
                                    <div class="review">
                                        <p><i class="fa-sharp fa-thin fa-location-dot"></i>{{ @$item['country_take']['name']??'' }}</p>
                                        <p><i class="fa-sharp fa-{{ @$item['reaction_count'] <= 0 ? 'regular' : 'solid'  }} fa-star"></i> {{ @$item['reaction_count'] }} @lang('Reviews')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
