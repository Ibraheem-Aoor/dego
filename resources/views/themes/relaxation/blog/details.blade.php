@extends($theme.'layouts.app')
@section('page_title',__('Blog Details'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="blog-details pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-page-left-content">
                        <div class="blog-page-left-image">
                            <a class="blogDetailsImage" href="{{ getFile(optional($blogDetails->blog)->blog_image_driver, optional($blogDetails->blog)->blog_image) }}"><img src="{{ getFile(optional($blogDetails->blog)->blog_image_driver, optional($blogDetails->blog)->blog_image) }}" alt="{{ $blogDetails->title }}"></a>
                        </div>
                        <div class="blog-page-lef-info">
                            <ul>
                                <li><h6><img class="blogAuthorImage" src="{{ getFile(optional(optional($blogDetails->blog)->author)->image_driver, optional(optional($blogDetails->blog)->author)->image) }}" alt="{{ optional(optional($blogDetails->blog)->author)->username }}"> @lang(ucfirst(optional(optional($blogDetails->blog)->author)->username))</h6></li>
                                <li><h6><i class="fa-light fa-calendar-days"></i> {{ dateTime(optional($blogDetails->blog)->created_at) }}</h6></li>
                            </ul>
                        </div>
                        <h5>@lang($blogDetails->title)</h5>
                        {!! $blogDetails->description !!}
                        <div class="share">
                            <h6>@lang('Share:')</h6>
                            <div class="share-media">
                                <div id="shareBlock">
                                    <div class="fb-share-button" data-href=""
                                         data-layout="button_count">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="fb-comments" data-href="" data-width="" data-numposts="5"></div>
                        <div id="fb-root"></div>

                    </div>
                </div>

                <div class="col-lg-4">

                    @include(template().'blog.partials.blog')
                </div>
            </div>
        </div>
    </section>
    @include(template().'sections.relaxation_news_letter_two')
    @include(template().'sections.footer')
@endsection
@push('style')
    <style>
        .blog-page-left-content h4{
            font-size: 18px !important;
            font-weight: 600 !important;
        }
        .blog-page-left-content p{
            margin: 10px 0 !important;
        }
    </style>
@endpush

@push('script')
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0"></script>
    <script>
        $("#shareBlock").socialSharingPlugin({
            urlShare: window.location.href,
            description: $("meta[name=description]").attr("content"),
            title: $("title").text(),
        });
    </script>
@endpush
