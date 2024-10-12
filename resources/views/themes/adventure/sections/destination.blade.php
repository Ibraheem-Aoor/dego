<section class="destination-section">
    <div class="container">
        <div class="row">
            <div class="section-header">
                <div class="section-subtitle">{{ @$destination['single']['adventure_theme_heading'] }}</div>
                <h2 class="section-title">{{ @$destination['single']['adventure_theme_sub_heading'] }}</h2>
            </div>
        </div>
        <div class="row g-4">
            @foreach(@$destination['destinations'] as $item)
                @php
                    $places = $item['place'] ?? [];
                    $totalPlaces = count($places);
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('package',['destination'=>$item->slug]) }}" class="destination-box">
                        <div class="thumbs-area">
                            <img src="{{ getFile(@$item['thumb_driver'], @$item['thumb']) }}" alt="{{ @$item['title'] }}">
                        </div>
                        <div class="content-area">
                            <h4 class="title">{{@$item['title'] }}</h4>
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
</section>
