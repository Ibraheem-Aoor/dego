<section class="mission">
    <div class="bg-layer" style="background: url({{ getFile(@$relaxation_mission['single']['media']->image_three->driver, @$relaxation_mission['single']['media']->image_three->path) }});"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                @foreach(@$relaxation_mission['multiple']->toArray() as $item)
                    <div class="mission-title">
                        <h4>@lang(@$item['heading'])</h4>
                        <p>{{ strip_tags(@$item['description']) }}</p>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="mission-right-container">
                    <div class="mission-right-image wow fadeInDown" data-wow-delay="100ms">
                        <img src="{{ getFile(@$relaxation_mission['single']['media']->image->driver, @$relaxation_mission['single']['media']->image->path) }}" alt="Image One">
                    </div>
                    <div class="mission-right-image wow fadeInUp" data-wow-delay="100ms">
                        <img src="{{ getFile(@$relaxation_mission['single']['media']->image_two->driver, @$relaxation_mission['single']['media']->image_two->path) }}" alt="Image Two">
                    </div>
                    <div class="round-box-content">
                        <span class="curved-circle"> @lang(@$relaxation_mission['single']['circle_text'])</span>
                        <div class="inner-icon">
                            <i class="fa-solid fa-arrow-up-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
