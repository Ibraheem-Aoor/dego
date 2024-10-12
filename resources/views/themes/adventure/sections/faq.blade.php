<section class="faq-area">
    <div class="container">
        <div class="section-header text-center">
            <div class="section-subtitle">{{ @$faq['single']['title'] }}</div>
            <h3>{{ @$faq['single']['sub_title'] }}</h3>
        </div>
        <div class="row gy-5 g-sm-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="faqImage">
                    <img src="{{ getFile(@$faq['single']['media']->image->driver, $faq['single']['media']->image->path) }}">
                </div>

            </div>
            <div class="col-lg-6 col-sm-12 align-items-center d-flex">
                <div class="tab-content w-100" id="v-pills-tabContent">
                    <div class="accordion" id="accordionExample">
                        @foreach($faq['multiple']->toArray() as $key => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{$key}}">
                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}"
                                            aria-expanded="false" aria-controls="collapse{{$key}}">
                                        {{ $item['question'] }}
                                    </button>
                                </h2>
                                <div id="collapse{{$key}}"
                                     class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                     aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{{ $item['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape3">
    </div>
</section>
