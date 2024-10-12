<section class="destination-section destination-section3">
    <div class="container">
        <div class="row">
            <div class="section-header">
                <h2 class="section-title">@lang(@$destination_three['single']['heading'])</h2>
                <p class="cmn-para-text">@lang(@$destination_three['single']['sub_heading'])</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($destination_three['destinations'] as $item)
                @php
                    $places = $item['place'] ?? [];
                    $totalPlaces = count($places);
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="destination-box3">
                        <a href="{{ route('package',['destination'=>$item->slug]) }}">
                            <div class="image-area">
                                <img src="{{ getFile($item['thumb_driver'], $item['thumb']) }}" alt="{{ @$item['title'] }}">
                                <div class="location-country">{{ @$item['countryTake']['name'] }}</div>
                            </div>
                        </a>
                        <div class="content-area">
                            <h4 class="title"><a href="{{ route('package',['destination'=>@$item->slug]) }}">{{ @$item['title'] }}</a></h4>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</section>
