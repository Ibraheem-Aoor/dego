<div class="blog-page-right-content">
    <form action="{{ route('blog') }}" method="get">
        <input type="text" name="search" placeholder="Search.">
        <button type="submit" class="btn-1"><i class="fa-light fa-magnifying-glass"></i> <span></span></button>
    </form>
</div>
<div class="blog-page-right-content">
    <h5 class="destination-details-right-title">@lang('Recent post')</h5>
    <div class="row blog-page p-0">
        @foreach($recents as $item)
            <div class="col-lg-12 col-md-6">
                <div class="blog-container">
                    <div class="blog-image">
                        <img class="blogImage" src="{{ getFile($item->blogThumb_driver ,$item->blogThumb) }}" alt="{{ $item->details->title }}">
                    </div>
                    <div class="blog-content">
                        <a href="{{ route('blog.details', $item->details->slug)}}">@lang($item->details->title)</a>
                        <div class="blog-info">
                            <div class="blog-member">
                                <div class="image">
                                    <img class="blogAuthorImage"  src="{{ getFile($item->author->image_driver, $item->author->image) }}" alt="{{ $item->author->username }}">
                                </div>
                                <span>@lang($item->author->username)</span>
                            </div>
                            <div class="blog-time"><i class="fa-light fa-calendar-days me-2"></i>{{ dateTime($item->created_at )}}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
