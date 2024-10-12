<section class="inspiration">
    <div class="inspiration-bg">
        <img src="{{ getFile(@$relaxation_inspiration['single']['media']->image->driver, @$relaxation_inspiration['single']['media']->image->path) }}" alt="shape">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="common-title">
                    <h2>@lang(@$relaxation_inspiration['single']['heading_part_one']) <span>@lang(@$relaxation_inspiration['single']['heading_part_two'])  <img src="{{ getFile(@$relaxation_inspiration['single']['media']->image_two->driver, @$relaxation_inspiration['single']['media']->image_two->path) }}" alt="shape"></span> {{ @$relaxation_inspiration['single']['heading_part_three'] }}</h2>
                    <div class="web">
                        <img src="{{ getFile(@$relaxation_inspiration['single']['media']->image_three->driver, @$relaxation_inspiration['single']['media']->image_three->path) }}" alt="web">
                    </div>
                </div>
                <div class="inspiration-left-content">
                    <p>{{ @$relaxation_inspiration['single']['sub_heading'] }}</p>
                    <div class="inspiration-btn">
                        <a href="{{ @$relaxation_inspiration['single']['media']->button_link }}" class="btn-1">@lang(@$relaxation_inspiration['single']['button_text']) <span></span></a>
                    </div>
                    <div class="bird">
                        <img src="{{ getFile(@$relaxation_inspiration['single']['media']->image_four->driver, @$relaxation_inspiration['single']['media']->image_four->path) }}" alt="icon">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="inspiration-right-content wow fadeInRightBig" data-wow-delay="0ms" data-wow-duration="3000ms">
                    <div class="inspiration-right-bg">
                        <img src="{{ getFile(@$relaxation_inspiration['single']['media']->image_five->driver, @$relaxation_inspiration['single']['media']->image_five->path) }}" alt="bg">
                    </div>
                    <div class="image">
                        <img src="{{ getFile(@$relaxation_inspiration['single']['media']->image_six->driver, @$relaxation_inspiration['single']['media']->image_six->path) }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
