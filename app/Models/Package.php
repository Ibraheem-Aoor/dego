<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Package extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    protected $casts = [
        'facility' => 'object',
        'excluded' => 'object',
        'expected' => 'object',
        'meta_keywords' => 'array'
    ];

    protected function metaKeywords(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => explode(", " , $value),
        );
    }

    public function metaRobots()
    {
        $cleaned = str_replace(['[', ']', '"'], '', $this->meta_robots);
        return explode(",", $cleaned);
    }

    public function getMetaRobotAttribute()
    {
        $cleaned = str_replace(['[', ']', '"'], '', $this->meta_robots);
        return $cleaned;
    }

    protected $appends = ['bookings'];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }
    public function favouriteList()
    {
        return $this->hasMany(FavouriteList::class, 'package_id');
    }

    public function getBookingsAttribute($id)
    {
        $disabledRanges = [];
        $bookings = Booking::select(['id','date', 'package_id', DB::raw('SUM(total_person) as total_person_sum')])
            ->where('package_id', $id)
            ->groupBy(['date'])
            ->get();
        foreach ($bookings as $booking) {
            $package = Package::find($booking->package_id);

            if ($package) {
                $totalPerson = $booking->total_person_sum;
                if ($package->maximumTravelers == $totalPerson) {
                    $disabledRanges[] = [
                        'date' => $booking->date,
                        'message' => "Don't have any space to book this tour.",
                    ];
                }
            }
        }
        return $disabledRanges;
    }
    public function getBookingsSpaceAttribute($id)
    {
        $spaceDate = [];
        $bookings = Booking::select([
            'id',
            'date',
            'package_id',
            DB::raw('SUM(total_person) as total_person_sum')
        ])
            ->where('package_id', $id)
            ->groupBy(DB::raw('DATE(date)'))
            ->get();

        foreach ($bookings as $booking) {
            $package = Package::find($booking->package_id);

            if ($package) {
                $totalPerson = $booking->total_person_sum;
                if ($package->maximumTravelers > $totalPerson) {
                    $spaceDate[] = [
                        'date' => Carbon::parse($booking->date)->toDateString(),
                        'space' => $package->maximumTravelers - $totalPerson,
                    ];
                }
            }
        }
        return $spaceDate;
    }

    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'package_category_id');
    }

    public function media()
    {
        return $this->hasMany(PackageMedia::class, 'package_id');
    }
    public function reaction()
    {
        return $this->hasMany(FavouriteList::class, 'package_id');
    }
    public function visitor()
    {
        return $this->hasMany(PackageVisitor::class, 'package_id');
    }
    public function review()
    {
        return $this->hasMany(Review::class, 'package_id')->where('status', 1)->latest();
    }

    public function reviewSummary()
    {
        return $this->hasOne(Review::class, 'package_id')
            ->selectRaw('package_id, AVG(rating) as average_rating, COUNT(*) as review_count')
            ->groupBy('package_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'package_id')
            ->with([
                'reaction' => function($query) {
                    $query->where('reaction_like', 1);
                }
            ])
            ->withCount([
                'reaction as reaction_like_count' => function($query) {
                    $query->where('reaction_like', 1);
                },
                'reaction as reaction_dislike_count' => function($query) {
                    $query->where('reaction_dislike', 1);
                }
            ]);
    }
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function countryTake()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

    public function stateTake()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }

    public function cityTake()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }
    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getReviewAverageAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }
    public function getFavouriteCountAttribute()
    {
        return $this->reaction()->count();
    }

    public function getVisitorCountAttribute()
    {
        return $this->visitor()->count();
    }

    public function getReviewPercentage($rating)
    {
        $reviewCount = $this->review_count;
        $count = $this->reviews()->where('rating', $rating)->count();
        return ($reviewCount > 0) ? ($count / $reviewCount) * 100 : 0;
    }
    public static function withAllRelations()
    {
        return self::with([
            'category:id,name',
            'destination:id,title,slug',
            'media',
            'countryTake:id,name',
            'stateTake:id,name',
            'cityTake:id,name',
            'reviewSummary',
            'reviews.user:id,firstname,lastname,username,image,image_driver',
        ]);
    }
    public function getBookingDates()
    {
        return $this->getBookingsAttribute($this->id);
    }
    public function getRelatedPackagesAttribute()
    {
        return $this->category->packages
            ->where('id', '!=', $this->id)->take(3) ?? collect();
    }

    public function calculateDiscountedPrice()
    {
        if ($this->discount_type == 0) {
            $amount = $this->adult_price - ($this->adult_price * $this->discount_amount / 100);
        } elseif ($this->discount_type == 1) {
            $amount = $this->adult_price - $this->discount_amount;
        } else {
            $amount = $this->adult_price;
        }

        return $amount;
    }

    public function calculateDiscountedPriceFromArray($item)
    {
        $adult_price = $item['adult_price'] ?? 0;
        $discount_amount = $item['discount_amount'] ?? 0;
        $discount_type = $item['discount_type'] ?? null;

        if ($discount_type === 0) {
            $amount = $adult_price - ($adult_price * $discount_amount / 100);
        } elseif ($discount_type === 1) {
            $amount = $adult_price - $discount_amount;
        } else {
            $amount = $adult_price;
        }

        return $amount;
    }

}
