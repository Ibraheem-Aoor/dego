<section class="about-section">
    <div class="container">
        <div class="row gy-5 gx-sm-5 align-items-center">
            <div class="col-lg-6">
                <div class="about-image-area">
                    <div class="img1">
                        <img src="{{getFile(@$about['single']['media']->image->driver ,@$about['single']['media']->image->path )}}" alt="About Image One">
                    </div>
                    <div class="img2">
                        <img src="{{getFile(@$about['single']['media']->image_two->driver ,@$about['single']['media']->image_two->path )}}" alt="About Image Two">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-subtitle">{{ @$about['single']['heading'] }}</div>
                    <h2 class="section-title">{{ @$about['single']['sub_heading'] }}</h2>
                    <p>{{ strip_tags(@$about['single']['description'])  }}</p>
                    <br>
                    <ul class="item-list-container">
                        @foreach($about['multiple'] as $item)
                            <li class="item">
                                <div class="icon-box">
                                    <i class="fa-regular fa-badge-check"></i>

                                </div>
                                <div class="item-content">
                                    <h5>{{ $item['topic'] }}</h5>
                                    <span>{{ strip_tags($item['description'])  }}</span>
                                </div>
                            </li>
                        @endforeach
                    @if(request()->is('/'))
                        <div class="btn-area mt-18">
                            <a type="button" href="{{ @$about['single']['media']->button_link }}" class="cmn-btn">@lang(@$about['single']['button_name'])</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
