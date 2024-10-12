
<section class="contact-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact-form-left-container">
                    <div class="contact-form-left-image">
                        <img src="{{ getFile(@$relaxation_contact['single']['media']->image->driver, @$relaxation_contact['single']['media']->image->path) }}" alt="Contact Image">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form-right-container">
                    <h3 class="mb_10">@lang(@$relaxation_contact['single']['title'])</h3>
{{--                    @$relaxation_contact['single']['media']->button_link--}}
                    <form action="{{ route('contact.send') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name" class="contact-input" value="{{ old('name') }}" placeholder="Your Name">
                                @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" class="contact-input" value="{{ old('email') }}" placeholder="Your Email">
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input type="tel" name="number" class="contact-input" value="{{ old('number') }}" placeholder="Phone Number">
                                @error('number')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="subject" class="contact-input" value="{{ old('subject') }}" placeholder="Subject">
                                @error('subject')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message" class="contact-input" placeholder="@lang('Write your message')">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                                <div class="form-check">
                                    <input class="form-check-input mt_25 contactCur" name="check" value="1" type="checkbox">
                                    <label class="mb_30 mt_20">@lang(@$relaxation_contact['single']['heading_text'])</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn-1">@lang(@$relaxation_contact['single']['button']) <span></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact-info">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 offset-xl-1">
                <div class="contact-info-content">
                    <div class="icon">
                        <i class="fa-light fa-location-dot"></i>
                    </div>
                    <div class="content">
                        <h6>{{ @$relaxation_contact['single']['address'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="contact-info-content">
                    <div class="icon">
                        <i class="fa-light fa-phone"></i>
                    </div>
                    <div class="content">
                        <a href="tel:{{ @$relaxation_contact['single']['phone'] }}">{{ @$relaxation_contact['single']['phone'] }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="contact-info-content">
                    <div class="icon">
                        <i class="fa-light fa-envelope"></i>
                    </div>
                    <div class="content">
                        <a href="mailto:{{ @$relaxation_contact['single']['email'] }}">{{ @$relaxation_contact['single']['email'] }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact-map">
    <div class="container">
        <div class="rpw">
            <div class="col-lg-12">
                <div class="destination-details-map">
                    <h5 class="destination-details-common-title"> @lang('Destination Map')</h5>
                    <div class="map-container">
                        <iframe class="mapIn" src="{{ strip_tags(@$relaxation_contact['single']['map']) }}"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

