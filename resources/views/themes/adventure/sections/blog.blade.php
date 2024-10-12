
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-50">
                    <div class="section-subtitle">{{ @$blog['single']['heading'] }}</div>
                    <h2 class="section-title mx-auto">{{ @$blog['single']['sub_heading'] }}</h2>
                    <p class="cmn-para-text mx-auto">{{ @$blog['single']['sub_text'] }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-5">
            <div class="col-lg-5 order-2 order-lg-1">
                <div class="row g-4 justify-content-center">
                    @foreach(@$blog['multiple']->slice(1) as $item)
                        <div class="col-12">
                        <div class="blog-box">
                            <div class="thumbs-area">
                                <img src="{{getFile(@$item['blog_image_driver'],@$item['blog_image'])}}" alt="{{ @$item['details']['title'] }}">
                                <div class="blog-date">
                                    <h4 class="text-white">{{ dateTime3($item['created_at']) }}</h4>
                                    <p>{{ dateTime2($item['created_at']) }}</p>
                                </div>
                            </div>
                            <div class="content-area">
                                <h4 class="blog-title"><a href="{{ route('blog.details', @$item['details']['slug']) }}">{{ @$item['details']['title'] }}</a></h4>
                                <p class="description">{{ strip_tags(@$item['details']['description']) }}</p>
                                <a href="{{ route('blog.details', @$item['details']['slug']) }}" class="blog-btn link">@lang('Read more')<i
                                        class="fa-regular fa-arrow-up-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7 order-1 order-lg-2">
                <div class="blog-box-large">
                    <div class="thumbs-area">
                        <img src="{{getFile(@$blog['multiple'][0]['blog_image_driver'],@$blog['multiple'][0]['blog_image'])}}" alt="{{ optional(@$blog['multiple'][0]['details'])['title'] }}">
                        <div class="blog-date">
                            <h5>{{ dateTime3(@$blog['multiple'][0]['created_at']) }}</h5>
                            <p>{{ dateTime2(@$blog['multiple'][0]['created_at']) }}</p>
                        </div>
                    </div>
                    <div class="content-area">
                        <h4 class="blog-title"><a type="button" href="{{ route('blog.details', optional(@$blog['multiple'][0]['details'])['slug']) }}">{{ optional(@$blog['multiple'][0]['details'])['title'] }}</a></h4>
                        <p class="description">{{strip_tags(optional(@$blog['multiple'][0]['details'])['description'])  }}</p>
                        <a href="{{ route('blog.details', @$blog['multiple'][0]['details']['slug']) }}" class="blog-btn link">
                            @lang('Read more')<i class="fa-regular fa-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
