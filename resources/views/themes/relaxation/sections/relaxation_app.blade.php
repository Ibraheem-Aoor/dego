<section class="app">
    <div class="app-top-shape">
        <img src="{{ getFile(@$relaxation_app['single']['media']->image->driver,@$relaxation_app['single']['media']->image->path) }}" alt="shape">
    </div>
    <div class="app-top-shape-2">
        <img src="{{ getFile(@$relaxation_app['single']['media']->image_two->driver,@$relaxation_app['single']['media']->image_two->path) }}" alt="shape">
    </div>
    <div class="right-maq-2">
        <img src="{{ getFile(@$relaxation_app['single']['media']->image_three->driver,@$relaxation_app['single']['media']->image_three->path) }}" alt="map">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="app-left-container">
                    <div class="common-title">
                        <h2>{{ @$relaxation_app['single']['title'] }}</h2>
                        <p>{{ @$relaxation_app['single']['sub_title'] }}</p>
                        <div class="app-icon">
                            <a href="{{ @$relaxation_app['single']['media']->button_link }}"> <img src="{{ getFile(@$relaxation_app['single']['media']->image_four->driver,@$relaxation_app['single']['media']->image_four->path) }}" alt="icon"></a>
                            <a href="{{ @$relaxation_app['single']['media']->button_link_two }}"> <img src="{{ getFile(@$relaxation_app['single']['media']->image_five->driver,@$relaxation_app['single']['media']->image_five->path) }}" alt="icon"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="app-right-container">
                    <div class="app-right-image">
                        <img src="{{ getFile(@$relaxation_app['single']['media']->image_six->driver,@$relaxation_app['single']['media']->image_six->path) }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
