<section class="faq">
    <div class="faq-left-shape paroller">
        <img src="{{ getFile(@$relaxation_faq['single']['media']->image->driver, @$relaxation_faq['single']['media']->image->path) }}" alt="shape">
    </div>
    <div class="faq-right-shape paroller">
        <img src="{{ getFile(@$relaxation_faq['single']['media']->image_two->driver, @$relaxation_faq['single']['media']->image_two->path) }}" alt="shape">
    </div>
    <div class="container">
        <div class="common-title">
            <h2>{{ @$relaxation_faq['single']['title'] }}</h2>
            <p>{{ @$relaxation_faq['single']['sub_title'] }}</p>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="faq-left-container">
                    <ul class="accordion-box acc_style_h4">
                        @foreach(@$relaxation_faq['multiple'] as $index => $item)
                            <li class="accordion block {{ $index === 0 ? 'active' : '' }}">
                                <div class="acc-btn">
                                    <div class="icon-box">
                                        <div class="icon icon_1" data-action="open">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="icon icon_2" data-action="close">
                                            <i class="fas fa-minus"></i>
                                        </div>
                                    </div>
                                    <h4>{{ @$item['question'] }}</h4>
                                </div>
                                <div class="acc-content {{ $index === 0 ? 'active' : '' }}">
                                    <p class="text">
                                        {{ @$item['answer'] }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block">
                <div class="faq-rifht-container">
                    <div class="faq-image">
                        <img src="{{ getFile(@$relaxation_faq['single']['media']->image_three->driver, @$relaxation_faq['single']['media']->image_three->path) }}" alt="avater">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
