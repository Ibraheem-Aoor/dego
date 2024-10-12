@extends($theme.'layouts.app')
@section('page_title',__('Blogs'))

@section('content')
    @include(template().'partials.breadcrumb')
        <section class="blog-section3">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @foreach($blogContent->contentDetails as $item)
                            <div class="section-header text-center mb-50">
                                <div class="section-subtitle">@lang(optional($item->description)->title)</div>
                                <h2 class="section-title mx-auto">@lang(optional($item->description)->sub_title)</h2>
                                <p class="cmn-para-text mx-auto">@lang(optional($item->description)->description)</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row g-4 justify-content-center align-items-center">
                    @forelse($blogs as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-box3">
                                <div class="img-box">
                                    <a href="{{ route('blog.details', optional($item->details)->slug)}}">
                                        <img src="{{ getFile($item->blog_image_driver ,$item->blog_image) }}" alt="{{ optional($item->details)->title }}">
                                    </a>
                                </div>
                                <div class="content-box">
                                    <div class="blog-date3">
                                        <p class="mb-0">
                                            {{ dateTime2($item->created_at) }}
                                            {{ dateTime4($item->created_at) }}
                                        </p>
                                    </div>
                                    <div class="blog-title">
                                        <h5><a href="{{ route('blog.details', optional($item->details)->slug)}}">{{ Str::limit(trans(optional($item->details)->title), 36) }}</a></h5>
                                    </div>
                                    <div class="para-text">
                                        <p>{{ strip_tags(optional($item->details)->description )}}</p>
                                    </div>
                                    <a href="{{ route('blog.details', optional($item->details)->slug)}}" class="blog-btn">
                                        <div class="link">@lang('Read more')</div> <i class="fa-regular fa-arrow-right"></i>
                                    </a>
                                </div>

                            </div>
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
            </div>
            <div class="shape2">
            </div>
        </section>
    @include(template().'sections.footer')
@endsection
