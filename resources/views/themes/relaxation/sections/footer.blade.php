<footer class="main-footer footer-style-1">
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="link-widget-1 logo-widget wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                    <div class="logo-widget-inner">
                        <div class="footer-logo">
                            <a href="{{ route('page','/') }}"><img
                                    src="{{ getFile(@$footer['single']['media']->image->driver , @$footer['single']['media']->image->path) }}"
                                    alt="logo"></a>
                        </div>
                        <div class="footer-location">
                            <div class="location">
                                <div class="icon"><i class="fa-light fa-location-dot"></i></div>
                                <p>{{ $footer['single']['address'] }}
                            </div>
                            <div class="hot-line">
                                <div class="icon"><i class="fa-light fa-phone"></i></div>
                                <p>@lang('Call Us:') <a href="#">{{ @$footer['single']['phone'] }}</a></p>
                            </div>
                        </div>
                        <div class="footer-media">
                            <ul>
                                @if(isset($footer['multiple']))
                                @foreach($footer['multiple'] as $item)
                                    <li><a href="{{ @$item['media']->button_link }}"><i
                                                class="{{ @$item['media']->icon }}"></i></a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 offset-xl-1 col-lg-2 col-md-3">
                <div class="link-widget-1 useful-widget wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                    <h6>@lang('Useful Link')</h6>
                    <ul class="link-widget-1-list">
                        @if(getFooterMenuData('useful_link') != null)
                            @foreach(getFooterMenuData('useful_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>


            <div class="col-lg-3 col-md-3">
                <div class="link-widget-1 destination-widget wow fadeInUp" data-wow-delay="400ms"
                     data-wow-duration="1500ms">
                    <h6>@lang($footer['single']['destination_package_text'])</h6>
                    @if(isset($footer['popular_destinations']))
                        <ul class="link-widget-1-list">
                            @foreach($footer['popular_destinations'] as $item)
                                <li>
                                    <a href="{{ route('package', ['destination'=>@$item['slug']]) }}">{{ @$item['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <div class="link-widget-1 help-widget wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1500ms">
                    <h6>@lang('Company Policy')</h6>
                    <ul class="link-widget-1-list">
                        @if(getFooterMenuData('support_link') != null)
                            @foreach(getFooterMenuData('support_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-7">
                <div class="link-widget-1 pyment-widget wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                    <h6>@lang('Card Acceptance')</h6>
                    <div class="footer-pyment">
                        <p>@lang($footer['single']['card_text'])</p>
                        <div class="bank-card">
                            @if(isset($footer['card']))
                                @foreach($footer['card'] as $item)
                                    <a href="javascript:void(0);"><img
                                            src="{{ getFile(@$item['media']->image->driver , @$item['media']->image->path) }}"
                                            alt="bank-card"></a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-copyright justify-content-center">
            <p class="copyright-text">{{ @$footer['single']['copyright_text'].' '. @$footer['single']['copyright'] .' By ' }}
                <a class="copyRightSiteTitle"
                   href="{{ @$footer['single']['media']->button_link }}">{{ basicControl()->site_title }}</a></p>
        </div>
    </div>
</footer>
