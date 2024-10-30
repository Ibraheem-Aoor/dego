<?php

namespace App\Models;

use App\Interface\DepositableInterface;
use App\Interface\NotifableUsers;
use App\Models\Scopes\BelongsToCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Str;

class CarBooking extends Model implements DepositableInterface  , NotifableUsers
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function (CarBooking $booking) {
            $booking->uid = Str::orderedUuid();
        });
        static::addGlobalScope(BelongsToCompanyScope::class);

    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (CarBooking $transaction) {
            if (empty($transaction->trx_id)) {
                $transaction->trx_id = self::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = self::lockForUpdate()->orderBy('id', 'desc')->first();

            if ($lastOrder && isset($lastOrder->trx_id)) {
                $lastOrderNumber = (int) filter_var($lastOrder->trx_id, FILTER_SANITIZE_NUMBER_INT);
                $newOrderNumber = $lastOrderNumber + 1;
            } else {
                $newOrderNumber = strRandomNum(12);
            }

            while (self::where('trx_id', 'CB' . $newOrderNumber)->exists()) {
                $newOrderNumber = (int) $newOrderNumber + 1;
            }

            return 'CB' . $newOrderNumber;
        });
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function bookingDates(): HasMany
    {
        return $this->hasMany(CarBookingDate::class, 'car_booking_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function depositable()
    {
        return $this->morphOne(Deposit::class, 'depositable');
    }

    public function getDatesLabel(): string
    {
        $dates = $this->bookingDates()->pluck('date')->toArray();
        return getBookingDatesLabel($dates);
    }

    public function getDatesString(): string
    {
        $dates = $this->bookingDates()->pluck('date')->toArray();
        asort($dates);
        return implode(',', $dates);
    }

    public function getDatesArray(): array
    {
        $dates = $this->bookingDates()->pluck('date')->toArray();
        return $dates;
    }

    public function maxBookingDate()
    {
        return $this->bookingDates()->max('date');
    }

    public function getDuration($with_label = false)
    {
        $dates = $this->bookingDates()->pluck('date')->toArray();
        return $with_label ? count($dates) . ' ' . __('Days') : count($dates);
    }

    /**
     * Scope a query to only include bookings with a confirmed deposit.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithConfirmedDeposit($query)
    {
        return $query->whereHas('depositable', function ($query) {
            $query->where('status', 1);
        });
    }


    /**
     * Return the title of the booked item.
     *
     * @return string
     */
    public function getBookedItemTitle()
    {
        return $this->car->name;
    }
    public function getActionLinkForAdmin()
    {
        // return route();
    }


    /**
     * Return the list of companies that have booking and will be notified.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company>
     */
    public static function getNotifableUsers(): Collection
    {
        $comapny_ids = self::query()->pluck('company_id');
        $companies = Company::select(['id', 'name' , 'email'])->whereIn('id', $comapny_ids)->get();
        $companies = $companies->map(function (Company $company) {
            $company->notifable_type = Company::class;
            return $company;
        });
        return $companies;
    }
}
