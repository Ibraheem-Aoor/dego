<section class="search wow fadeInUp" data-wow-delay="100ms">
    <div class="container">
        <div class="search-container">
            <div class="bg-layer" style="background: url({{ getFile(@$relaxation_search['single']['media']->image->driver,@$relaxation_search['single']['media']->image->path ) }});"></div>
            <div class="search-form">
{{--                @$relaxation_search['single']['media']->button_link--}}
                <form action="{{ route('package') }}" method="GET">
                    <div class="serach-title">
                        <h6><i class="fa-light fa-earth-americas"></i> @lang(@$relaxation_search['single']['title'])</h6>
                    </div>
                    <div class="search-form-inner">
                        <div class="location search-box">
                            <i class="fa-light fa-location-dot"></i>
                            <div class="select-option">
                                <input class="form-control" type="text" name="search" placeholder="@lang('e.g. Dubai')" />
                            </div>
                            <ul class="options">
                                <div class="search-result" id="searchResults"></div>
                            </ul>
                        </div>
                        <div class="date">
                            <input class="flatpickr" name="date" id="myID" type="text" placeholder="Feb24"/>
                            <i class="fa-thin fa-calendar-days"></i>
                        </div>
                        <div class="count">
                            <div class="count-counter">
                                <i class="fa-light fa-user"></i>
                                <div class="count-counter-inner">
                                    <span class="adult">0</span>
                                    <p>@lang('adult')</p>
                                </div>
                                <div class="count-counter-inner">
                                    <span class="children">0</span>
                                    <p>@lang('children')</p>
                                </div>
                                <div class="count-counter-inner">
                                    <span class="infant">0</span>
                                    <p>@lang('infant')</p>
                                </div>
                            </div>
                            <div class="count-container">
                                <div class="count-single">
                                    <div class="count-single-text">
                                        <h6>@lang('Adult')</h6>
                                        <p>@lang('Over 12 Years')</p>
                                    </div>
                                    <div class="count-single-inner">
                                        <button type="button" class="decrement" data-type="adult">-</button>
                                        <span class="adult">0</span>
                                        <button type="button" class="increment" data-type="adult">+</button>
                                    </div>
                                </div>
                                <div class="count-single">
                                    <div class="count-single-text">
                                        <h6>@lang('Children')</h6>
                                        <p>@lang('Below 12 Years')</p>
                                    </div>
                                    <div class="count-single-inner">
                                        <button type="button" class="decrementTwo" data-type="children">-</button>
                                        <span class="children">0</span>
                                        <button type="button" class="incrementTwo" data-type="children">+</button>
                                    </div>
                                </div>
                                <div class="count-single">
                                    <div class="count-single-text">
                                        <h6>@lang('Infant')</h6>
                                        <p>@lang('Below 3 Years')</p>
                                    </div>
                                    <div class="count-single-inner">
                                        <button type="button" class="decrementThree" data-type="infant">-</button>
                                        <span class="infant">0</span>
                                        <button type="button" class="incrementThree" data-type="infant">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn-1"><i class="fa-light fa-magnifying-glass"></i> <span></span></button>
                    </div>
                    <input type="hidden" name="adults" id="adultInput" value="0">
                    <input type="hidden" name="children" id="childrenInput" value="0">
                    <input type="hidden" name="infants" id="infantInput" value="0">
                </form>
            </div>
        </div>
    </div>
</section>
