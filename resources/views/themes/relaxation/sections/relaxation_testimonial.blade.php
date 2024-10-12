<section class="testimonial about-testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="testimonial-left-container">
                    <div class="image-1">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_one->driver, @$relaxation_testimonial['single']['media']->image_one->path) }}" alt="image One">
                    </div>
                    <div class="image-2">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_two->driver, @$relaxation_testimonial['single']['media']->image_two->path) }}" alt="image Two">
                    </div>
                    <div class="image-3">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_three->driver, @$relaxation_testimonial['single']['media']->image_three->path) }}" alt="image Three">
                    </div>
                    <div class="image-4">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_four->driver, @$relaxation_testimonial['single']['media']->image_four->path) }}" alt="image Four">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="common-title text-center">
                    <h2>{{ @$relaxation_testimonial['single']['heading'] }}</h2>
                </div>
                <div class="testimonial-carousel-container">
                    <div class="testimonial-carousel-bg">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_five->driver, @$relaxation_testimonial['single']['media']->image_five->path) }}" alt="image">
                    </div>
                    <div class="single-item-carousel swiper-container">
                        <div class="swiper-wrapper">
                            @foreach(@$relaxation_testimonial['multiple']->toArray() as $item)
                            <div class="swiper-slide testimonial-single">
                                <div class="testimonial-content">
                                    <div class="icon">
                                        <i class="fa-thin fa-quote-left"></i>
                                    </div>
                                    <p><q>{{ strip_tags(@$item['description']) }}</q></p>
                                    <h6>@lang('-By') {{ @$item['name']. ', '. @$item['address'] }}</h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="testimonial-right-container">
                    <div class="image-5">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_six->driver, @$relaxation_testimonial['single']['media']->image_six->path) }}" alt="image">
                    </div>
                    <div class="image-6">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_seven->driver, @$relaxation_testimonial['single']['media']->image_seven->path) }}" alt="image">
                    </div>
                    <div class="image-7">
                        <img src="{{ getFile(@$relaxation_testimonial['single']['media']->image_eight->driver, @$relaxation_testimonial['single']['media']->image_eight->path) }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
