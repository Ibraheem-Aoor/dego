@extends($theme.'layouts.app')
@section('page_title',__('Blogs'))

@section('content')

    @include(template().'partials.breadcrumb')
    <section class="blog-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @forelse($blogs as $item)
                        <div class="blog-page-left-content">
                            <div class="blog-page-left-image">
                                <a href="{{ route('blog.details', optional($item->detailsoptional())->slug)}}"><img class="blogListImage" src="{{ getFile($item->blog_image_driver ,$item->blog_image) }}" alt="{{ $item->details->title }}"></a>
                            </div>
                            <div class="blog-page-lef-info">
                                <ul>
                                    <li><h6><img class="blogAuthorImage" src="{{ getFile(optional($item->authoroptional())->image_driver, optional($item->authoroptional())->image) }}" alt="{{ optional($item->author)->username }}"> @lang(ucfirst($item->author->username))</h6></li>
                                    <li><h6><i class="fa-light fa-calendar-days"></i>{{ ' '.dateTime($item->created_at) }}</h6></li>
                                </ul>
                            </div>
                            <h5>{{ optional($item->detailsoptional())->title }}</h5>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags(optional($item->detailsoptional())->description), 300) }}</p>
                            <a href="{{ route('blog.details', optional($item->detailsoptional())->slug)}}" class="btn-2">@lang('Read more') <span></span></a>
                        </div>
                    @empty
                        <div class="row justify-content-center pt-5">
                            <div class="col-12">
                                <div class="data-not-found text-center">
                                    <div class="no_data_image">
                                        <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                    </div>
                                    <p>@lang('No data found.')</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    {{ $blogs->appends($_GET)->links($theme.'partials.pagination') }}
                </div>

                <div class="col-lg-4">
                    <div class="blog-page-right-content">
                        <form action="{{ route('blog') }}" method="get">
                            <input type="text" name="search" placeholder="Search.">
                            <button type="submit" class="btn-1"><i class="fa-light fa-magnifying-glass"></i> <span></span></button>
                        </form>
                    </div>
                    <div class="blog-page-right-content">
                        <h5 class="destination-details-right-title">@lang('Recent post')</h5>
                        <div class="row">
                            @foreach($recentBlog as $item)
                                <div class="col-lg-12 col-md-6">
                                    <div class="blog-container">
                                        <div class="blog-image">
                                            <img class="blogImage" src="{{ getFile($item->blogThumb_driver ,$item->blogThumb) }}" alt="{{ optional($item->details)->title }}">
                                        </div>
                                        <div class="blog-content">
                                            <a href="{{ route('blog.details', optional($item->details)->slug)}}">@lang(optional($item->details)->title)</a>
                                            <div class="blog-info">
                                                <div class="blog-member">
                                                    <div class="image">
                                                        <img class="blogAuthorImage"  src="{{ getFile(optional($item->author)->image_driver, optional($item->author)->image) }}" alt="{{ optional($item->author)->username }}">
                                                    </div>
                                                    <span>@lang(optional($item->author)->username)</span>
                                                </div>
                                                <div class="blog-time"><i class="fa-light fa-calendar-days me-2"></i>{{ dateTime($item->created_at )}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include(template().'sections.relaxation_news_letter_two')
    @include(template().'sections.footer')
@endsection
