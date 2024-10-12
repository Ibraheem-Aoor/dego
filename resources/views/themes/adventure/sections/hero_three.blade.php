<!-- Hero section3 start -->
<div class="hero-section3">
    <div class="container">
        <div class="row gy-5 g-sm-5 align-items-center">
            <div class="col-xxl-5 col-lg-7 order-2 order-lg-1">
                <div class="content-area">
                    <h1>@lang(@$hero_three['single']['text_one']) <br>
                        @lang(@$hero_three['single']['text_two']) <br>
                        @lang(@$hero_three['single']['text_three']) <span class="highlight">@lang(@$hero_three['single']['text_four'])</span></h1>
                    <p class="hero-para-text">@lang(@$hero_three['single']['text_five'])</p>
                    <a href="{{ $hero_three['single']['media']->button_link_two }}" class="cmn-btn mt-30">{{ @$hero_three['single']['button_two'] }}</a>
                </div>

            </div>
            <div class="col-xxl-6 col-lg-5 order-1 order-lg-2 mx-auto d-none d-md-block">
                <div class="hero-image-area">
                    <img src="{{ getFile(@$hero_three['single']['media']->image->driver, @$hero_three['single']['media']->image->path) }}" alt="@lang('Hero Image')">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-lg-10">
{{--                @$hero_three['single']['media']->button_link--}}
                <form action="{{ route('package') }}" class="multiple-search-box">
                    <div class="input-box">
                        <h6>{{ @$hero_three['single']['search_title_one'] }}</h6>
                        <input class="form-control" type="text" name="search" />
                    </div>
                    <div class="input-box input-box2">
                        <h6>{{ @$hero_three['single']['search_title_two'] }}</h6>
                        <input class="form-control" name="date" id="myID" type="text" />
                    </div>
                    <button type="submit" class="multiple-search-btn">
                        <span><i class="fa-regular fa-magnifying-glass"></i></span>
                        <span class="d-md-none">{{ @$hero_three['single']['button'] }}')</span>
                    </button>

                    <div class="search-result" id="searchResults">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- Hero secton end -->
