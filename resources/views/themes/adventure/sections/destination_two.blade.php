<section class="destination-section">
    <div class="container-fluid">
        <div class="row">
            <div class="section-header text-center">
            <div class="section-subtitle">{{ @$destination_two['single']['heading'] }}</div>
            <h2 class="section-title mx-auto">{{ @$destination_two['single']['sub_heading'] }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme carousel-area1">
                @foreach(@$destination_two['destinations'] as $item)
                    @php
                        $places = $item['place'] ?? [];
                        $totalPlaces = count($places);
                    @endphp
                    <div class="item">
                        <a href="{{ route('package',['destination'=>$item->slug]) }}" class="destination-box">
                            <div class="thumbs-area">
                                <img src="{{ getFile(@$item['thumb_driver'], @$item['thumb']) }}" alt="{{ @$item['title'] }}">
                            </div>
                            <div class="content-area">
                                <h4 class="title">@lang(@$item['title'])</h4>
                                <div class="destination-info">
                                    <div class="item pe-4">
                                        <span>{{ @$item['package_count'] }}</span>
                                        @lang('packages')
                                    </div>
                                    <div class="item ps-0">
                                        <span>{{ $totalPlaces }}</span>
                                        @lang('Place')
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
