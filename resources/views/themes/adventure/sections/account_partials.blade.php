<div class="col-md-6 p-0 login-signup-thums-wrapper">
    <div class="login-signup-thums h-100" style="background-image: url({{getFile(@$account_partials['single']['media']->image->driver,@$account_partials['single']['media']->image->path)}});">
        <div class="content-area">
            <div class="logo-area mb-30">
                <a href="{{ @$account_partials['single']['media']->button_link }}">
                    <img class="logo" src="{{getFile(basicControl()->admin_dark_mode_logo_driver, basicControl()->admin_dark_mode_logo)}}" alt="Website Logo">
                </a>
            </div>
            <div class="middle-content">
                <div class="section-subtitle">@lang(@$account_partials['single']['heading'])</div>
                <h3 class="section-title">@lang(@$account_partials['single']['sub_heading'])</h3>
                <p>@lang(@$account_partials['single']['heading_text'])</p>
            </div>
            <div class="bottom-content">
                <div class="social-area mt-50">
                    <ul class="d-flex">
                        @foreach($account_partials['multiple']->toArray() as $item )
                            <li><a href="{{ @$item['media']->my_link }}"><i class="{{ $item['media']->icon }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
