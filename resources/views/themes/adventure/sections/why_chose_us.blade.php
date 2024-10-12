<section class="why-choose-us p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 p-0">
                <div class="thumbs-area">
                    <img src="{{ getFile(@$why_chose_us['single']['media']->image->driver, @$why_chose_us['single']['media']->image->path) }}" alt="@lang('Why Chose us image')">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="col-md-6 p-0">
                <div class="content-area">
                    <div class="section-header">
                        <div class="section-subtitle">{{ @$why_chose_us['single']['heading'] }}</div>
                        <h2 class="section-title">{{ @$why_chose_us['single']['sub_heading'] }}</h2>
                        <p>{{ @$why_chose_us['single']['sub_text'] }}</p>
                    </div>
                    <ul class="why-choose-us-list">
                        @foreach($why_chose_us['multiple'] as $item)
                            <li class="item">
                                <div class="icon-area">
                                    <i class="{{ $item['media']->icon }}"></i>
                                </div>
                                <div class="text-area">
                                    <h5 class="title">{{ $item['title'].':' }} </h5>
                                    <p>{{ $item['details'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
