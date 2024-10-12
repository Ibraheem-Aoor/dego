<section class="sabscribe">
    <div class="container">
        <div class="sabscribe-container">
            <div class="bg-layer" style="background: url({{ getFile(@$relaxation_news_letter['single']['media']->image->driver, @$relaxation_news_letter['single']['media']->image->path) }});"></div>
            <div class="sabscribe-content">
                <div class="sabscribe-title">
                    <h6>@lang(@$relaxation_news_letter['single']['title'])</h6>
                    <h4>@lang(@$relaxation_news_letter['single']['sub_title'])</h4>
                </div>
                <div class="sabscribe-form">
                    <form method="post" action="{{ route('subscribe') }}">
                        @csrf

                        <input type="email" name="email" placeholder="@lang('Enter your email')">
                        <i class="fa-thin fa-envelopes"></i>
                        <button type="submit"><i class="fa-thin fa-thumbs-up"></i> <span>@lang(@$relaxation_news_letter['single']['button'])</span></button>
                    </form>

                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</section>
