<section class="about-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-3-left-content">
                    <div class="about-3-left-content-inner">
                        <h3>@lang(@$relaxation_about_three['single']['heading'])</h3>
                        <p>@lang(@$relaxation_about_three['single']['sub_heading'])</p>
                        <a href="{{ @$relaxation_about_three['single']['media']->button_link }}" class="btn-1">@lang(@$relaxation_about_three['single']['button_name']) <span></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-3-right-content">
                    <div class="image-1">
                        <img src="{{ getFile(@$relaxation_about_three['single']['media']->image->driver , @$relaxation_about_three['single']['media']->image->path ) }}" alt="About Image One">
                    </div>
                    <div class="image-2">
                        <img src="{{ getFile(@$relaxation_about_three['single']['media']->image_two->driver , @$relaxation_about_three['single']['media']->image_two->path ) }}" alt="About Image Two">
                    </div>
                    <div class="about-3-right-frem paroller">
                        <div class="about-3-right-frem-inner">
                            <h5>{{ @$relaxation_about_three['single']['year_number'] }}</h5>
                            <p>@lang(@$relaxation_about_three['single']['message'])</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
