<section class="team">
    <div class="container">
        <div class="common-title text-center">
            <h2>@lang(@$relaxation_team['single']['heading']) <span>@lang(@$relaxation_team['single']['heading_two'])  <img src="{{ getFile($relaxation_team['single']['media']->image->driver, @$relaxation_team['single']['media']->image->path) }}" alt="shape"></span> @lang(@$relaxation_team['single']['heading_three'])</h2>
            <p class="mt_10">@lang(@$relaxation_team['single']['sub_heading'])</p>
        </div>
        <div class="row">
            @foreach(@$relaxation_team['multiple']->toArray() as $key => $item)
                <div class="col-lg-4 col-md-4">
                    <div class="team-single wow fadeInUp" data-wow-delay="100ms">
                        <div class="team-single-image-box">
                            <div class="team-single-image text-center">
                                <img src="{{ getFile(@$item['media']->image->driver, @$item['media']->image->path ) }}" alt="{{ @$item['name'] }}">
                            </div>
                            <div class="team-single-overlay">
                                <div class="footer-media">
                                    <ul>
                                        <li><a href="{{ @$item['facebook'] }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="{{ @$item['twitter'] }}"><i class="icon-x-twitter"></i></a></li>
                                        <li><a href="{{ @$item['instagram'] }}"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="{{ @$item['linkedin'] }}"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="team-single-number"><p>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</p></div>
                        <div class="team-single-content">
                            <h6>{{ @$item['name'] }}</h6>
                            <p>{{ @$item['designation'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
