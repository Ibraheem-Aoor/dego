<section class="about-section2">
    <div class="container">
        <div class="row gy-5 gx-sm-5 align-items-center">
            <div class="col-lg-6">
                <div class="about-image-area">
                    <div class="img1">
                        <img src="{{ getFile(@$about_two['single']['media']->image->driver, @$about_two['single']['media']->image->path) }}" alt="About Image">
                    </div>
                    <div class="about-counter">
                        <h2>{{ @$about_two['single']['number'] }}+</h2>
                        <h5>{{ @$about_two['single']['text_part_one'] }}
                            <br>
                            {{ @$about_two['single']['text_part_two'] }}
                            <br>
                            {{ @$about_two['single']['text_part_three'] }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-subtitle">{{ @$about_two['single']['heading'] }}</div>
                    <h2 class="section-title">{{ @$about_two['single']['sub_heading'] }}</h2>
                    <p>{{ strip_tags(@$about_two['single']['description']) }}</p>
                    <br>
                    <ul class="item-list-container">
                        @foreach($about_two['multiple']->toArray() as $item)
                            <li class="item">
                                <div class="icon-box">
                                    <i class="fa-regular fa-badge-check"></i>
                                </div>
                                <div class="item-content">
                                    <h5>{{ $item['topic'] }} :</h5>
                                    <span>{{ strip_tags($item['description']) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="btn-area mt-30">
                        <a href="{{ $about_two['single']['media']->button_link }}" class="cmn-btn">{{ $about_two['single']['button_name'] }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
