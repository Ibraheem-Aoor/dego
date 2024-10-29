<div class="col-lg-10">
    @if(isset($package->review) && $package->review->count() > 0)
        <div class="daily-review">
            <h5 class="destination-details-common-title">@lang('Reviews')</h5>
            <p>@lang('Showing '. $package->review_count .' review')</p>
            @if($package->review)
                @foreach($package->review as $item)
                    <div class="daily-review-box wow fadeInUp" data-wow-delay="100ms">
                        <div class="daily-review-image">
                            <img src="{{ getFile($item->user->image_driver, $item->user->image) }}" alt="{{ $item->user->firstname .' '. $item->user->lastname }}">
                        </div>
                        <div class="daily-review-info">
                            <p>{{ dateTime($item->created_at) }}</p>
                            <h6>{{ $item->user->firstname .' '. $item->user->lastname }}</h6>
                            <div class="daily-review-rating">
                                <ul>
                                    {!! displayStarRating($item->rating) !!}
                                </ul>
                            </div>
                            <p>{{ $item->review }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endif
    @if(isset($booking))
        <div class="review-form wow fadeInUp add-review" data-wow-delay="100ms">
            <h5>@lang('Add your reviews')</h5>
            <form action="{{ route('user.review.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="rating pt-2">
                        <input type="radio" id="star5" name="rate" value="5">
                        <label for="star5" title="5 stars"></label>
                        <input type="radio" id="star4" name="rate" value="4">
                        <label for="star4" title="4 stars"></label>
                        <input type="radio" id="star3" name="rate" value="3">
                        <label for="star3" title="3 stars"></label>
                        <input type="radio" id="star2" name="rate" value="2">
                        <label for="star2" title="2 stars"></label>
                        <input type="radio" id="star1" name="rate" value="1">
                        <label for="star1" title="1 star"></label>
                    </div>
                    <input type="hidden" name="package_id" value="{{ $package->id }}"/>
                    @error('rate')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                    <div class="col-lg-12">
                        <textarea name="review" class="review-input" placeholder="@lang('Write your reviews')">{{ old('review') }}</textarea>
                        @error('review')
                            <span class="invalid-feedback d-block pt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn-1">@lang('Submit Review') <span></span></button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
@push('style')
    <style>
        .rating {
            display: flex;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            font-size: 24px;
            color: gray;
            cursor: pointer;
            transition: color 0.3s;
        }
    </style>
@endpush
@push('script')
    <script>
        document.querySelectorAll('.rating input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                let stars = document.querySelectorAll('.rating label');
                stars.forEach(star => star.style.color = 'gray');

                let selectedValue = parseInt(this.value);
                stars.forEach((star, index) => {
                    if (index >= stars.length - selectedValue) {
                        star.style.color = 'gold';
                    }
                });
            });
        });

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
