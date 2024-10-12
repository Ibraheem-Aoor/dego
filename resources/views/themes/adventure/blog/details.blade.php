@extends($theme.'layouts.app')
@section('page_title',__('Blog Details'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="blog-details-section">
    <div class="container">
        <div class="row gy-5 g-sm-g">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="blog-box-large">
                    <div class="thumbs-area">
                        <img src="{{ getFile(optional($blogDetails->blog)->blog_image_driver ,optional($blogDetails->blog)->blog_image) }}" alt="{{ $blogDetails->title }}">
                        <div class="blog-date">
                            <p>{{ dateTime(optional($blogDetails->blog)->created_at) }}</p>
                        </div>
                    </div>
                    <div class="content-area">
                        <h3 class="blog-title">
                            {{ $blogDetails->title }}
                        </h3>

                        <div class="para-text">
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

                            <div class="fb-comments" data-href="{{ url()->current() }}" data-width="100%" data-numposts="5"></div>

                            <div id="fb-root"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
                <div class="blog-sidebar mt-2">
                    <div class="sidebar-widget-area">
                        <form action="{{ route('blog') }}" method="get">
                            <div class="search-box">
                                <input type="text" class="form-control" name="search" placeholder="Search here...">
                                <button type="submit" class="search-btn"><i class="far fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-widget-area">
                        <div class="widget-title">
                            <h4>@lang('Recent Post')</h4>
                        </div>
                        @foreach($recents as $item)
                            <a href="{{ route('blog.details',optional($item->details)->slug) }}" class="sidebar-widget-item">
                                <div class="image-area">
                                    <img src="{{ getFile($item->blog_image_driver ,$item->blog_image) }}" alt="{{ $item->title }}">
                                </div>
                                <div class="content-area">
                                    <div class="title">{{ $item->details->title }}</div>
                                    <div class="widget-date">
                                        <i class="fa-regular fa-calendar-days"></i> {{ dateTime($item->created_at) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="sidebar-widget-area">
                        <div class="sidebar-categories-area">
                            <div class="categories-header">
                                <div class="widget-title">
                                    <h4>@lang('Categories')</h4>
                                </div>
                            </div>
                            <ul class="categories-list">
                                @foreach($categoriesWithCounts as $item)
                                    <li>
                                        <a href="{{ route('blog', ['category'=>$item->slug]) }}"><span>{{ $item->category_name }}</span> <span class="highlight">{{ $item->blog_count }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    @include(template().'sections.footer')
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/icomoon.css') }}">

    <style>
        #shareBlock{
            padding-top: 4px;
        }
       .share{
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 50px 0 20px;
        }
      .share h6{
            font-size: 16px;
            font-weight: 500;
            line-height: 24px;
        }
        .blog-box-large .content-area h4{
            font-size: 18px;
        }
    </style>
@endpush

@push('script')
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0"></script>
    <script src="{{ asset($themeTrue.'js/socialSharing.js')}}"></script>

    <script>
        $("#shareBlock").socialSharingPlugin({
            urlShare: window.location.href,
            description: $("meta[name=description]").attr("content"),
            title: $("title").text(),
        });
    </script>
@endpush
