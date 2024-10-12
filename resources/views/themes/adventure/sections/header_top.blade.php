<div class="container">
    <div class="top-bar">
        <ul class="contact-info">
            <li><a href="javascript:void(0)"><i class="fa-regular fa-headphones"></i><span>{{ @$header_top['single']['phone'] }}</span></a>
            </li>
            <li><a href="mailto:{{$header_top['single']['email']}}"><i
                        class="fa-regular fa-envelope-open"></i><span>{{$header_top['single']['email']}}</span></a>
            </li>
        </ul>
        <div class="social-area ">
            <ul class="d-flex d-none  d-sm-flex">
                @foreach($header_top['multiple']->toArray() as $item )
                    <li><a href="{{ $item['media']->my_link }}"><i class="{{ $item['media']->icon }}"></i></a></li>
                @endforeach
            </ul>
{{--            @if(Route::currentRouteName() !== 'package')--}}
                <a href="{{ @$header_top['single']['media']->button_link }}" class="cmn-btn">
                    <span class="d-md-none"><i class="fa-regular fa-calendar-check"></i></span>
                    <span class="d-none d-md-block">{{ @$header_top['single']['button'] }}</span>
                </a>
{{--            @endif--}}
        </div>
    </div>
</div>
