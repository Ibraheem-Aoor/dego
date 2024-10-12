<section class="blog">
    <div class="container">
        <div class="common-title text-center">
            <h2>@lang(@$relaxation_blog['single']['title_part_one']) <span> @lang(@$relaxation_blog['single']['title_part_two']) <img src="{{ getFile(@$relaxation_blog['single']['media']->image->driver,@$relaxation_blog['single']['media']->image->path ) }}" alt="shape"></span></h2>
        </div>
        <div class="row">
            @foreach($relaxation_blog['multiple']->toArray() as $item)
                <div class="col-lg-6 col-md-6">
                    <div class="blog-container wow fadeInUp" data-wow-delay="100ms">
                        <div class="blog-image">
                            <img class="blogImageClassic" src="{{ getFile(@$item['blog_image_driver'],@$item['blog_image']) }}" alt="{{ @$item['details']['title'] }}">
                        </div>
                        <div class="blog-content">
                            <a class="blogTitle" href="{{ route('blog.details', @$item['details']['slug']) }}">@lang(@$item['details']['title'])</a>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags(@$item['details']['description']), 100) }}</p>
                            <div class="blog-info">
                                <div class="blog-member">
                                    <div class="image">
                                        <img class="blogAuthorImage" src="{{ getFile(@$item['author']['image_driver'], @$item['author']['image']) }}" alt="{{ @$item['author']['username'] }}">
                                    </div>
                                    <span>@lang(ucfirst(@$item['author']['username']))</span>
                                </div>
                                <div class="blog-time"><i class="fa-light fa-calendar-days me-2"></i>{{ dateTime(@$item['created_at']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
