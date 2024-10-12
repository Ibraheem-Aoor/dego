<section class="banner-section-two">
    <div class="swiper-container banner-slider-1">
        <div class="swiper-wrapper">
            @foreach(@$relaxation_hero_two['multiple']->toArray() as $item)
                <div class="swiper-slide">
                    <div class="bg-layer" style="background-image: url({{ getFile(@$item['media']->image->driver,@$item['media']->image->path ) }});"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 col-md-6">
                                <div class="content-box">
                                    <h3>{{ @$item['title'] }} </h3>
                                    <p>{{ @$item['sub_title'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
