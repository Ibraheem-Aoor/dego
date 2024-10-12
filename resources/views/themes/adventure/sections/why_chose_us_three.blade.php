<section class="why-chose-us-section-wrapper">
    <section class="why-choose-us-section3" style="background-image: url({{getFile(@$why_chose_us_three['single']['media']->image->driver, @$why_chose_us_three['single']['media']->image->path)}});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="content-area">
                    <div class="section-subtitle">{{ @$why_chose_us_three['single']['heading'] }}</div>
                    <h2 class="section-title">{{ @$why_chose_us_three['single']['sub_heading'] }}</h2>
                    <div>
                        <a href="{{ @$why_chose_us_three['single']['media']->button_link }}" class="cmn-btn">{{ @$why_chose_us_three['single']['button'] }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="why-choose-us-section3-feature">
        <div class="section-inner">
            <div class="container">
                <div class="row g-4">
                    @foreach($why_chose_us_three['multiple']->toArray() as $item)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="feature-box3">
                                <div class="icon-area">
                                    <i class="{{ $item['media']->icon }}"></i>
                                </div>
                                <div class="content-area">
                                    <h4 class="title">{{ $item['title'] }}</h4>
                                    <p>{{ strip_tags($item['details']) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </section>
</section>
