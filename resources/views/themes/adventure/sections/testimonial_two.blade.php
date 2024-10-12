<section class="testimonial-section2">
    <div class="container">
        <div class="row">
            <div class="section-header mb-50 text-center">
                <div class="section-subtitle">{{ @$testimonial_two['single']['heading'] }}</div>
                <h2 class="">{{ @$testimonial_two['single']['sub_heading'] }}</h2>
                <p class="cmn-para-text m-auto">{{ strip_tags(@$testimonial_two['single']['description']) }}</p>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme testimonial-carousel2">
                @foreach($testimonial_two['multiple']->toArray() as $item)
                    <div class="item">
                        <div class="testimonial-box">
                            <div class="testimonial-header">
                                <div class="testimonial-title-area">
                                    <div class="testimonial-thumbs">
                                        <img src="{{ getFile(@$item['media']->image->driver, @$item['media']->image->path) }}" alt="{{ $item['name'] }}">
                                    </div>
                                    <div class="testimonial-title">
                                        <h5>{{ $item['name'] }}</h5>
                                        <h6>{{ $item['address'] }}</h6>
                                    </div>
                                </div>
                                <div class="qoute-icon">
                                    <i class="fa-sharp fa-regular fa-quote-left"></i>
                                </div>
                            </div>
                            <div class="quote-area">
                                <p>{{ strip_tags($item['description']) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
