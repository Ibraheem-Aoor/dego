@if($relaxation_hero)
<section class="banner">
    <div class="container">
        <div class="banner-container">
            <div class="bg-layer" style="background: url({{ getFile($relaxation_hero['single']['media']->image->driver,$relaxation_hero['single']['media']->image->path ) }})"></div>
            <div class="banner-content">
                <div class="banner-title">
                    <h3>
                        @lang(@$relaxation_hero['single']['heading_part_one'])
                        <span class="banner-title-animation">
                            <span class="banner-title-animation-inner">
                                <span class=flip>
                                    <span class="flip-text">@lang(@$relaxation_hero['single']['heading_part_two'])</span>
                                </span>
                            </span>
                        </span>
                        @lang(@$relaxation_hero['single']['heading_part_three'])
                    </h3>
                </div>
                <p class="banner-text">{{ strip_tags(@$relaxation_hero['single']['sub_heading']) }}</p>
                <div class="banner-image">
                    <img src="{{ getFile(@$relaxation_hero['single']['media']->image_two->driver,@$relaxation_hero['single']['media']->image_two->path ) }}" alt="Hero Image">
                    <div class="video-btn">
                        <div class="missiom-video-btn">
                            <a href="{{ @$relaxation_hero['single']['media']->video_link }}" class="hv-popup-link">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
