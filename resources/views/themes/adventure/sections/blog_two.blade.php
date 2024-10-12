<section class="blog-section3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-50">
                    <div class="section-subtitle">{{ @$blog_two['single']['heading'] }}</div>
                    <h2 class="section-title mx-auto">@lang(@$blog_two['single']['sub_heading'])</h2>
                    <p class="cmn-para-text mx-auto">
                        {{ @$blog_two['single']['sub_text'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($blog_two['multiple']->toArray() as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-box3">
                        <div class="img-box">
                            <a href="{{ route('blog.details', @$item['details']['slug']) }}">
                                <img src="{{ getFile($item['blog_image_driver'] , $item['blog_image']) }}"
                                     alt="{{ @$item['details']['title'] }}">
                            </a>
                        </div>
                        <div class="content-box">
                            <div class="blog-date3">
                                <h4 class="mb-0">{{ dateTime3($item['created_at']) }}</h4>
                                <p class="mb-0">{{ dateTime2($item['created_at']) }}</p>
                            </div>
                            <div class="blog-title">
                                <h5>
                                    <a href="{{ route('blog.details', @$item['details']['slug']) }}">{{ Str::limit(trans(@$item['details']['title']),36) }}</a>
                                </h5>
                            </div>
                            <div class="para-text">
                                <p>{{ strip_tags(@$item['details']['description']) }}</p>
                            </div>
                            <a href="{{ route('blog.details', @$item['details']['slug']) }}" class="blog-btn">
                                <div class="link">@lang('Read more')</div>
                                <i class="fa-regular fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="shape2">
    </div>
</section>
