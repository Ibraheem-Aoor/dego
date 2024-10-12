<section class="sabscribe-2 wow fadeInUp" data-wow-delay="100ms">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="sabscribe-2-container">
                    <div class="bg-layer" style="background: url({{ getFile(@$relaxation_news_letter_two['single']['media']->image->driver, @$relaxation_news_letter_two['single']['media']->image->path) }});"></div>
                    <div class="sabscribe-content">
                        <div class="sabscribe-title">
                            <h4>@lang(@$relaxation_news_letter_two['single']['title'])</h4>
                            <h6>@lang(@$relaxation_news_letter_two['single']['sub_title'])</h6>
                        </div>
                        <div class="sabscribe-form">
                            <form method="post" action="{{ route('subscribe') }}">
                                @csrf

                                <input type="email" name="email" placeholder="@lang('Enter your email')">
                                <i class="fa-thin fa-envelopes"></i>

                                <button type="submit"><i class="fa-thin fa-thumbs-up"></i> <span>@lang($relaxation_news_letter_two['single']['button'])</span></button>
                            </form>

                            @error('email')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
