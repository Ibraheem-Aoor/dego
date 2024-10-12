<section class="feature-section3">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-6 col-lg-4 ">
                <h2 class="section-title">{{ @$feature_three['single']['heading'] }}
                </h2>
                <p class="cmn-para-text">
                    {{ strip_tags(@$feature_three['single']['sub_heading']) }}
                </p>
                <a href="" class="cmn-btn mt-30">@lang('explore more')</a>
            </div>
            @foreach(@$feature_three['multiple']->toArray() as $item)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="feature-box3">
                        <div class="icon-area">
                            <i class="{{ @$item['media']->icon }}"></i>
                        </div>
                        <div class="content-area">
                            <h4 class="title">{{ $item['title'] }}</h4>
                            <p>{{ $item['sub_title'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
