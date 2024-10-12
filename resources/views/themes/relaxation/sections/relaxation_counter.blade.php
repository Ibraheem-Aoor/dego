<section class="counter-section">
    <div class="container">
        <div class="row">
            @php
                $chunks = array_chunk(@$relaxation_counter['multiple']->toArray(), 2);
            @endphp

            @foreach(array_slice($chunks, 0, 1) as $chunk)
                @foreach($chunk as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-section-single">
                            <div class="odometer-box">
                                <h5 class="odometer" data-count="{{ @$item['media']->count_number }}">00</h5>
                                <div class="odometer-text"><span>+</span></div>
                            </div>
                            <p>{{ @$item['topic'] }}</p>
                        </div>
                    </div>
                @endforeach
            @endforeach

            @foreach(array_slice($chunks, 1, 1) as $chunk)
                @foreach($chunk as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-section-single">
                            <div class="odometer-box">
                                <h5 class="odometer" data-count="{{ @$item['media']->count_number }}">00</h5>
                                <div class="odometer-text">k<span>+</span></div>
                            </div>
                            <p>{{ @$item['topic'] }}</p>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
