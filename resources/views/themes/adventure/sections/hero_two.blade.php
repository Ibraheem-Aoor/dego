
<!-- Hero area start -->
<div class="hero-section2">
    <div class="owl-carousel owl-theme hero-carousel">
        <div class="item" style="background-image: url({{getFile(@$hero_two['single']['media']->image->driver, @$hero_two['single']['media']->image->path)}});">
        </div>
        <div class="item" style="background-image: url({{getFile(@$hero_two['single']['media']->image_two->driver, @$hero_two['single']['media']->image_two->path)}});">
        </div>
        <div class="item" style="background-image: url({{getFile(@$hero_two['single']['media']->image_three->driver, @$hero_two['single']['media']->image_three->path)}});">
        </div>
    </div>
    <div class="hero-content">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 mx-auto">
                    <div class="section-header">
                        <div class="section-subtitle">@lang(@$hero_two['single']['heading'])</div>
                        <h1>@lang(@$hero_two['single']['sub_heading']) </h1>
                        <p class="hero-para-text">@lang(@$hero_two['single']['sub_heading_text'])</p>
                    </div>
{{--                    @$hero_two['single']['media']->button_link--}}
                    <form action="{{ route('package') }}" class="multiple-search-box">
                        <div class="input-box">
                            <h6>{{ @$hero_two['single']['search_title_one'] }}</h6>
                            <input class="form-control" type="text" name="search" />
                        </div>
                        <div class="input-box input-box2">
                            <h6>{{ @$hero_two['single']['search_title_two'] }}</h6>
                            <input class="form-control" name="date" id="myID" type="text" />
                        </div>
                        <button type="submit" class="multiple-search-btn">
                            <span><i class="fa-regular fa-magnifying-glass"></i></span>
                            <span class="d-md-none">{{ @$hero_two['single']['button'] }}</span>
                        </button>

                        <div class="search-result" id="searchResults">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Hero secton end -->
