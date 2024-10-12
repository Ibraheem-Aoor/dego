<section class="book">
    <div class="bg-layer" style="background: url({{ getFile(@$relaxation_booking['single']['media']->image->driver, @$relaxation_booking['single']['media']->image->path) }})"></div>
    <div class="container">
        <div class="common-title text-center">
            <h2>{{ @$relaxation_booking['single']['heading'] }} <span>@lang(@$relaxation_booking['single']['title'])? <img src="{{ getFile(@$relaxation_booking['single']['media']->image_two->driver, @$relaxation_booking['single']['media']->image_two->path) }}" alt="shape"></span></h2>
        </div>
        <div class="row">
            @foreach(@$relaxation_booking['multiple']->toArray() as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="book-single wow fadeInUp" data-wow-delay="100ms">
                        <div class="book-single-image">
                            <img src="{{ getFile(@$item['media']->image->driver,@$item['media']->image->path ) }}" alt="{{ @$item['title'] }}">
                        </div>
                        <div class="book-single-title">
                            <a href="{{ @$item['media']->button_link }}">@lang(@$item['title'])</a>
                            <p>{{ strip_tags(@$item['description']) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
