<!-- Map section start -->

<section class="contact-section">
    <div class="container">
        <div class="contact-inner">
            <div class="row g-4">
                <div class="col-xl-5 col-lg-6">
                    <div class="contact-area">
                        <div class="section-header mb-0">
                            <h3>{{ $contact['single']['heading'] }}</h3>
                        </div>
                        <p class="para_text">{{ @$contact['single']['sub_heading'] }}</p>
                        <div class="contact-item-list">
                            @foreach(@$contact['multiple'] as $item)
                                <div class="item">
                                    <div class="icon-area">
                                        <i class="{{ @$item['media']->icon }}"></i>
                                    </div>
                                    <div class="content-area">
                                        <h6 class="mb-0">{{ @$item['title'].': ' }}</h6>
                                        <p class="mb-0">{{ @$item['value'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="contact-message-area">
                        <div class="contact-header">
                            <h3 class="section-title">{{ @$contact['single']['heading_two'] }}</h3>
                            <p>{{ @$contact['single']['sub_heading_two'] }}</p>
                        </div>
{{--                        @$contact['single']['media']->button_link--}}
                        <form action="{{ route('contact.send') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your Name">
                                    @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail Address">
                                    @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Your Subject">
                                    @error('subject')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb  -3 col-12">
                                    <textarea class="form-control" name="message" id="message" rows="5"
                                              placeholder="Your Massage">{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-end">
                                <button type="submit" class="cmn-btn2 w-100">{{ @$contact['single']['button'] }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="map-section">
        <iframe class="shadow-none p-0"
                src="{{ strip_tags(@$contact['single']['map']) }}"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
<!-- Contact section end -->
