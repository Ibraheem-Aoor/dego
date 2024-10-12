
<section class="about">
    <div class="about-shape">
        <img src="{{ getFile(@$relaxation_about['single']['media']->image->driver, @$relaxation_about['single']['media']->image->path) }}" alt="shape">
    </div>
    <div class="container">
        <div class="common-title">
            <h2>@lang(@$relaxation_about['single']['heading_part_one']) <span>@lang(@$relaxation_about['single']['heading_part_two'])<img src="{{ getFile(@$relaxation_about['single']['media']->image_two->driver, @$relaxation_about['single']['media']->image_two->path) }}" alt="shape"></span> @lang(@$relaxation_about['single']['heading_part_three'])</h2>
            <p>{{ @$relaxation_about['single']['sub_heading'] }}</p>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="about-left-container">
                    <div class="about-contant">
                        @foreach(@$relaxation_about['multiple']->slice(0, 2) as $item)
                            <div class="about-contant-inner wow fadeInUp" data-wow-delay="100ms">
                                <div class="icon">
                                    <img src="{{ getFile($item['media']->image->driver, $item['media']->image->path ) }}" alt="icon">
                                </div>
                                <a href="{{ $item['media']->button_link }}">@lang($item['topic'])</a>
                                <p>@lang($item['description'])</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="about-contant">
                        @foreach($relaxation_about['multiple']->slice(2, 2) as $item)
                            <div class="about-contant-inner wow fadeInUp" data-wow-delay="100ms">
                                <div class="icon">
                                    <img src="{{ getFile(@$item['media']->image->driver, @$item['media']->image->path ) }}" alt="icon">
                                </div>
                                <a href="{{ @$item['media']->button_link }}">@lang(@$item['topic'])</a>
                                <p>@lang(@$item['description'])</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-right-content">
                    <div class="about-right-image wow fadeInRightBig" data-wow-delay="100ms" data-wow-duration="2500ms">
                        <img src="{{ getFile(@$relaxation_about['single']['media']->image_three->driver, @$relaxation_about['single']['media']->image_three->path) }}" alt="image">
                    </div>
                    <div class="round-border-shape"></div>
                    <div class="squir-shape"></div>
                </div>
            </div>
        </div>
    </div>
</section>
