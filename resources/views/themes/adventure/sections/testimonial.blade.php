<section class="testimonial-section">
    <div class="container">
        <div class="row">
            <div class="section-header text-center">
                <div class="section-subtitle">{{ @$testimonial['single']['heading'] }}</div>
                <h2>{{ @$testimonial['single']['sub_heading'] }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme testimonial-carousel">
                @foreach($testimonial['multiple'] as $item)
                    <div class="item">
                        <div class="testimonial-box">
                            <p>{!! Str::limit(strip_tags($item['description']), 200) !!}</p>
                            <div class="client-info">
                                <div class="thumbs-area">
                                    <img src="{{ getFile(@$item['media']->image->driver, @$item['media']->image->path) }}" alt="{{ $item['name'] }})">
                                </div>
                                <div class="content-area">
                                    <h4>{{ @$item['name'] }}</h4>
                                    <h6>{{ @$item['address'] }}</h6>
                                </div>
                            </div>
                            <div class="quote-area">
                                <i class="fa-solid fa-quote-right"></i>
                            </div>
                            <div class="line1"></div>
                            <div class="line2"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
