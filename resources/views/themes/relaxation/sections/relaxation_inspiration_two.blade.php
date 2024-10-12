<section class="inspiration inspiration-2">
    <div class="bg-layer" style="background-image: url({{ getFile($relaxation_inspiration_two['single']['media']->image->driver,$relaxation_inspiration_two['single']['media']->image->path ) }});"></div>
    <div class="inspiration-bg">
        <img src="{{ getFile(@$relaxation_inspiration_two['single']['media']->image_two->driver,@$relaxation_inspiration_two['single']['media']->image_two->path ) }}" alt="shape">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="common-title">
                    <h2>@lang(@$relaxation_inspiration_two['single']['heading_part_one']) <span>@lang(@$relaxation_inspiration_two['single']['heading_part_two'])<img src="{{ getFile($relaxation_inspiration_two['single']['media']->image_three->driver,$relaxation_inspiration_two['single']['media']->image_three->path ) }}" alt="shape"></span> @lang($relaxation_inspiration_two['single']['heading_part_three'])</h2>
                    <div class="web">
                        <img src="{{ getFile(@$relaxation_inspiration_two['single']['media']->image_four->driver,@$relaxation_inspiration_two['single']['media']->image_four->path ) }}" alt="web">
                    </div>
                </div>
                <div class="inspiration-left-content">
                    <p>{{ @$relaxation_inspiration_two['single']['sub_heading'] }}</p>
                    <div class="inspiration-btn">
                        <a href="{{ @$relaxation_inspiration_two['single']['media']->button_link }}" class="btn-1">@lang(@$relaxation_inspiration_two['single']['button']) <span></span></a>
                    </div>
                    <div class="bird">
                        <img src="{{ getFile(@$relaxation_inspiration_two['single']['media']->image_five->driver,@$relaxation_inspiration_two['single']['media']->image_five->path ) }}" alt="icon">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="inspiration-right-content wow fadeInRightBig" data-wow-delay="0ms" data-wow-duration="3000ms">
                    <div class="inspiration-right-bg">
                        <img src="{{ getFile(@$relaxation_inspiration_two['single']['media']->image_six->driver,@$relaxation_inspiration_two['single']['media']->image_six->path ) }}" alt="background">
                    </div>
                    <div class="image">
                        <img src="{{ getFile(@$relaxation_inspiration_two['single']['media']->image_seven->driver,@$relaxation_inspiration_two['single']['media']->image_seven->path ) }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
