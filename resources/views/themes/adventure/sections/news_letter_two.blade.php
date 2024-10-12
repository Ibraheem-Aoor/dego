<section class="newsletter-section2 pt-0 pb-0">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 p-0">
                <div class="newsletter-offer" style="background: linear-gradient(rgba(56, 53, 53, 0.8) 100%, rgba(56, 53, 53, 0.8) 100%), url({{ getFile(@$news_letter_two['single']['media']->image->driver, @$news_letter_two['single']['media']->image->path) }});">
                    <div class="newsletter-offer-inner">
                        <h2 class="section-title">@lang(@$news_letter_two['single']['section_title'])</h2>
                        <p class="cmn-para-text">{{ strip_tags(@$news_letter_two['single']['section_title_text']) }}</p>
                        <a href="{{ @$news_letter_two['single']['media']->button_link }}" class="cmn-btn mt-30">@lang(@$news_letter_two['single']['button_one_title'])</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6  p-0">
                <div class="newsletter-form-area" style="background: url({{ getFile(@$news_letter_two['single']['media']->image_two->driver, @$news_letter_two['single']['media']->image_two->path) }}), var(--bg-color3)" >
                    <div class="newsletter-form-area-inner">
                        <div class="section-header">
                            <div class="section-subtitle">{{ @$news_letter_two['single']['section_sub_title'] }}</div>
                            <h2 class="newslatter-title">{{ @$news_letter_two['single']['newsletter_title'] }}
                            </h2>
                            <p>{{ strip_tags(@$news_letter_two['single']['newsletter_text']) }}</p>
                        </div>
                        <form method="post" action="{{ @$news_letter_two['single']['media']->my_link }}" class="newsletter-form">
                            @csrf
                            <input type="text" class="form-control" name="email"  placeholder="@lang("Enter your mail")">
                            <button type="submit" class="subscribe-btn"><i class="fa-regular fa-envelope"></i>@lang(@$news_letter_two['single']['button_two_title'])</button>
                        </form>
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
