<div class="hero-section">
    <div class="container-xl-fluid container container">
        <div class="row gy-5 g-sm-4 align-items-center">
            <div class="offset-xl-1 col-xl-5">
                <div class="hero-text">
                    <div class="section-subtitle">@lang(@$hero['single']['heading'])</div>
                    <h1>@lang(@$hero['single']['sub_heading'])</h1>
                    <p class="hero-para-text">@lang(@$hero['single']['sub_heading_text'])</p>
                </div>
{{--                $hero['single']['media']->button_link--}}
                <form action="{{ route('package') }}" method="GET" class="multiple-search-box" >
                    <div class="input-box">
                        <h6>{{ @$hero['single']['search_title_one'] }}</h6>
                        <input class="form-control" type="text" name="search" />
                    </div>
                    <div class="input-box input-box2">
                        <h6>{{ @$hero['single']['search_title_two'] }}</h6>
                        <input class="form-control" name="date" id="myID" type="text" />
                    </div>
                    <button type="submit" class="multiple-search-btn">
                        <span><i class="fa-regular fa-magnifying-glass"></i></span>
                        <span class="d-md-none">{{ $hero['single']['button'] }}</span>
                    </button>

                    <div class="search-result" id="searchResults">
                    </div>
                </form>
            </div>
            <div class="col-xl-6 d-none d-md-block">
                <div class="hero-image-area">
                    <div class="row g-3 align-items-center">
                        <div class="col-xl-6 col-md-8">
                            <div class="row g-3">
                                <div class="col-xl-12 col-md-6">
                                    <div class="img img1"><img src="{{ getFile(@$hero['single']['media']->image->driver, @$hero['single']['media']->image->path) }}" alt="@lang('Hero Image One')"></div>
                                </div>
                                <div class="col-xl-12 col-md-6">
                                    <div class="img img2"><img src="{{ getFile(@$hero['single']['media']->image_two->driver, @$hero['single']['media']->image_two->path) }}" alt="@lang('Hero Image Two')"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-4">
                            <div class="img img4"><img src="{{ getFile(@$hero['single']['media']->image_three->driver, @$hero['single']['media']->image_three->path) }}" alt="@lang('Hero Image Three')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

