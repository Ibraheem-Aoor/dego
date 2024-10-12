
@if($relaxation_experience)
<section class="experience">
    <div class="experience-left-shape">
        <img src="{{ getFile(@$relaxation_experience['single']['media']->image->driver, @$relaxation_experience['single']['media']->image->path)  }}" alt="shape">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="experience-left-container">
                    <div class="common-title">
                        <h2>@lang(@$relaxation_experience['single']['heading']) <span>@lang(@$relaxation_experience['single']['heading_two']) <img src="{{ getFile(@$relaxation_experience['single']['media']->image_two->driver, @$relaxation_experience['single']['media']->image_two->path) }}" alt="shape"></span> @lang(@$relaxation_experience['single']['heading_three'])</h2>
                    </div>
                    @foreach(@$relaxation_experience['multiple']->toArray() as $item)
                        <div class="experience-left-content">
                            <div class="icon"><img src="{{ getFile(@$item['media']->image->driver,@$item['media']->image->path ) }}" alt="icon"></div>
                            <div class="content">
                                <h5>@lang(@$item['heading'])</h5>
                                <p>{{ strip_tags(@$item['description']) }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="experience-rivew">
                        <div class="experience-rivew-btn">
                            <a href="{{ @$relaxation_experience['single']['media']->button_link }}" class="btn-1">@lang(@$relaxation_experience['single']['button_text'])<span></span></a>
                        </div>
                        <div class="rivew-box">
                            <div class="avater-image">
                                <ul>
                                    <li><a><img src="{{ getFile(@$relaxation_experience['single']['media']->image_three->driver, @$relaxation_experience['single']['media']->image_three->path) }}" alt="client"></a></li>
                                    <li><a><img src="{{ getFile(@$relaxation_experience['single']['media']->image_four->driver, @$relaxation_experience['single']['media']->image_four->path) }}" alt="client"></a></li>
                                    <li><a><img src="{{ getFile(@$relaxation_experience['single']['media']->image_five->driver, @$relaxation_experience['single']['media']->image_five->path) }}" alt="client"></a></li>
                                    <li><a class="client-icon">+</a></li>
                                </ul>
                            </div>
                            <div class="counter">
                                <div class="odometer-box">
                                    <h5 class="odometer" data-count="{{ @$relaxation_experience['single']['total_customer'] }}">00</h5>
                                    <div class="odometer-text">K <span>+</span></div>
                                </div>
                                <p>@lang(@$relaxation_experience['single']['customer_text'])</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="experience-right-content">
                    <div class="plane">
                        <img src="{{ getFile(@$relaxation_experience['single']['media']->image_six->driver, @$relaxation_experience['single']['media']->image_six->path) }}" alt="plane">
                    </div>
                    <div class="gallery">
                        <img src="{{ getFile(@$relaxation_experience['single']['media']->image_seven->driver, @$relaxation_experience['single']['media']->image_seven->path) }}" alt="image">
                    </div>
                    <div class="experience-right-bg">
                        <img src="{{ getFile(@$relaxation_experience['single']['media']->image_eight->driver, @$relaxation_experience['single']['media']->image_eight->path) }}" alt="bg">
                    </div>
                    <div class="experience-image-1 paroller exextra">
                        <img src="{{ getFile(@$relaxation_experience['single']['media']->image_nine->driver,@$relaxation_experience['single']['media']->image_nine->path ) }}" alt="image">
                    </div>
                    <div class="experience-bottom-image">
                        <div class="image">
                            <img src="{{ getFile(@$relaxation_experience['single']['media']->image_ten->driver,@$relaxation_experience['single']['media']->image_ten->path ) }}" alt="image">
                        </div>
                        <div class="image">
                            <img src="{{ getFile(@$relaxation_experience['single']['media']->image_eleven->driver,@$relaxation_experience['single']['media']->image_eleven->path ) }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
