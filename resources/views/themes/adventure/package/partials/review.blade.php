<div id="review-section" class="review-section">
    @if(isset($package->review) && $package->review->count() > 0)
        <div class="average-review">
            <div class="row">
                <div class="col-4">
                    <div class="card-box">
                        @if($package->review_average > 0)
                            <h2 class="mb-2">{{'('. $package->review_average .')'}}</h2>
                            <div class="rating mb-2" data-rating="{{$package->review_average}}">
                                <span>( {{$package->review_count}} @lang('reviews') )</span>
                            </div>
                        @else
                            <h2 class="reviewZero mb-2">{{'('. 0 .')'}}</h2>
                            <span> @lang('0 reviews') </span>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="progress-wrapper">
                        @for ($rating = 5; $rating >= 1; $rating--)
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <span class="index">@lang($rating)</span>
                                <div class="progress" role="progressbar" aria-label="Basic example"
                                     aria-valuenow="{{ $data['percentage'.$rating] }}" aria-valuemin="0"
                                     aria-valuemax="100">
                                    <div class="progress-bar"
                                         style="width: {{ $data['percentage'.$rating] }}%"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="all-review mb-5">
                <h4 class="title">@lang('Reviews ('. $package->review_count .')')</h4>
                @foreach($package->review as $item)
                    @php
                        $isLike = false;
                        $isDislike = false;
                        $user = auth()->user() ? auth()->user()->id : null;

                        foreach ($item->reaction as $reaction) {
                            if ($reaction->user_id == $user) {
                                if ($reaction->reaction_like == 1) {
                                    $isLike = true;
                                }
                                if ($reaction->reaction_dislike == 1) {
                                    $isDislike = true;
                                }
                            }
                        }
                    @endphp
                    <div class="review-box">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ getFile($item->user?->image_driver, $item->user?->image) }}" alt=" {{ $item->user?->firstname .' '. $item->user?->lastname }}">
                        </div>
                        <div class="text-box">
                            <h5 class="name">{{ $item->user?->firstname .' '. $item->user?->lastname }}</h5>
                            <p class="date">{{ dateTime($item->created_at) }}</p>
                            <div class="rating">
                                <div class="star-rating" data-rating="{{$item->rating}}">
                                </div>
                            </div>
                            <p class="mt-3">
                                {{ $item->review }}
                            </p>

                        </div>
                    </div>
                @endforeach
            </div>
    @endif
    @if(isset($booking))
        <div class="add-review">
            <form action="{{ route('user.review.store') }}" method="post">
                @csrf
                <h4>@lang('Add review')</h4>
                <div class="row g-3">
                    <div class="rating">
                        <input type="radio" id="star1" name="rate" value="5">
                        <label for="star1" title="text"></label>
                        <input type="radio" id="star2" name="rate" value="4">
                        <label for="star2" title="text"></label>
                        <input type="radio" id="star3" name="rate" value="3">
                        <label for="star3" title="text"></label>
                        <input type="radio" id="star4" name="rate" value="2">
                        <label for="star4" title="text"></label>
                        <input type="radio" id="star5" name="rate" value="1">
                        <label for="star5" title="text"></label>
                    </div>
                    @error('rate')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                    <input type="hidden" name="package_id" value="{{ $package->id }}"/>
                    <div class="input-box col-12">
                    <textarea class="form-control" cols="30" name="review" rows="5"
                              placeholder="Write Message"></textarea>
                    @error('review')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="input-box col-12">
                        <button class="cmn-btn" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
@push('style')
    <style>
        .input-box{
            width: 100% !important;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function () {
            $('.star-rating').each(function () {
                let rating = parseFloat($(this).data('rating'));
                let fullStars = Math.floor(rating);
                let halfStar = (rating % 1 !== 0);

                for (let i = 1; i <= fullStars; i++) {
                    $(this).append('<i class="fas fa-star"></i>');
                }

                if (halfStar) {
                    $(this).append('<i class="fas fa-star-half-alt half"></i>');
                }

                let unfilledStars = 5 - Math.ceil(rating);
                for (let j = 1; j <= unfilledStars; j++) {
                    $(this).append('<i class="far fa-star"></i>');
                }
            });
        });
    </script>
@endpush
