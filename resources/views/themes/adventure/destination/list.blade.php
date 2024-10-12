@extends($theme.'layouts.app')
@section('title',trans('Destination'))

@section('content')
    @include(template().'partials.breadcrumb')
    <section class="destination-section">
        <div class="container">
            <div class="row">
                <div class="section-header">
                    @foreach($content->contentDetails as $item)
                        <div class="section-subtitle">@lang(@$item->description->adventure_theme_heading)</div>
                        <h2 class="section-title">@lang(@$item->description->adventure_theme_sub_heading)</h2>
                    @endforeach
                </div>
            </div>
            <div class="row g-4 d-flex align-items-center justify-content-center">
                @forelse ($destinations as $item)
                    @php
                        $places = $item->place ?? [];
                        $totalPlaces = count($places);
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <a href="{{ route('package',['destination'=>$item->slug]) }}"
                           class="destination-box destinationLink" data-destination-id="{{ $item->slug }}">
                            <div class="thumbs-area">
                                <img src="{{ getFile($item->thumb_driver, $item->thumb) }}" alt="{{ $item->title }}">
                            </div>
                            <div class="content-area">
                                <h4 class="title">{{ $item->title }}</h4>
                                <div class="destination-info">
                                    <div class="item">
                                        <span>{{ $item->package_count }}</span>
                                        @lang('Packages')
                                    </div>
                                    <div class="destination-info-border"></div>
                                    <div class="item">
                                        <span>{{ $totalPlaces }}</span>
                                        @lang('Place')
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="row justify-content-center pt-5">
                        <div class="col-12">
                            <div class="data-not-found text-center">
                                <div class="no_data_image">
                                    <img class="no_image_size" src="{{ asset('assets/global/img/oc-error.svg') }}">
                                </div>
                                <p>@lang('No data found.')</p>
                            </div>
                        </div>
                    </div>
                @endforelse

                {{ $destinations->appends(request()->query())->links($theme.'partials.pagination') }}
            </div>
        </div>
    </section>
    @include(template().'sections.footer')
@endsection

@push('script')
    <script>
        document.querySelectorAll('.destinationLink').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                let destinationId = this.getAttribute('data-destination-id');
                let csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    url: '{{ route('destination.track') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        destination_id: destinationId
                    },
                    success: function (response) {
                        window.location.href = '{{ route('package', ['destination' => '']) }}' + destinationId;
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endpush
