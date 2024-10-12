<section class="newsletter-section"
         style="
               background-image: linear-gradient(rgba(45, 55, 60, 0.8), rgba(45, 55, 60, 0.8)), url({{ getFile(@$news_letter['single']['media']->image->driver, @$news_letter['single']['media']->image->path) }});
               background-repeat: no-repeat;background-size: cover;">
    <div class="container">
        <div class="row gy-5 gx-sm-5 align-items-center">
            <div class="col-lg-6">
                <div class="newsletter-form-area">
                    <div class="section-subtitle">@lang(@$news_letter['single']['heading'])</div>
                    <h2 class="newslatter-title">@lang(@$news_letter['single']['sub_heading']) <br> @lang(@$news_letter['single']['sub_heading_two'])
                    </h2>
                    <form method="post" action="{{ @$news_letter['single']['media']->button_link }}" class="newsletter-form">
                        @csrf
                        <input type="text" class="form-control" name="email"  placeholder="Enter your mail">
                        <button type="submit" class="subscribe-btn"><i class="fa-regular fa-envelope"></i>@lang(@$news_letter['single']['button'])</button>
                    </form>
                    @error('email')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="counter-section">
                    <div class="row g-4">
                        @foreach($news_letter['multiple']->toArray() as $item)
                            <div class="col-md-6">
                                <div class="counter-box">
                                    <div class="icon-area">
                                        <i class="{{ $item['media']->icon }}"></i>
                                    </div>
                                    <div class="content-area">
                                        <h2 class="title">{{ $item['value'] . ' +' }}</h2>
                                        <h4>{{ $item['title'] }}</h4>
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
