<section class="feature-section">
    <div class="container">
        <div class="row">
            <div class="section-header text-center">
                <div class="section-subtitle">{{ @$feature['single']['heading'] }}</div>
                <h3>{{ @$feature['single']['sub_heading'] }}</h3>
            </div>
        </div>
        <div class="row gy-5 g-sm-5">
            @foreach(@$feature['multiple']->toArray() as $item)
                <div class="col-md-3 col-sm-6">
                    <div class="feature-box">
                        <div class="icon-area">
                            <i class="{{ @$item['media']->icon }}"></i>
                        </div>
                        <div class="content-area">
                            <h5>{{ $item['title'] }}
                            </h5>
                            <p>{{ $item['sub_title'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
