<?php

namespace App\Models;

use App\Interface\DepositableInterface;
use App\Interface\NotifableUsers;
use App\Models\Scopes\BelongsToCompanyScope;
use App\Models\Scopes\BelongsToDriverScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Str;

class DriverRideBooking extends Model implements DepositableInterface, NotifableUsers
{
    use HasFactory;
    protected $guarded = [];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, foreignKey: 'driver_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'driver_id');
    }
    protected static function booted(): void
    {
        static::creating(function (DriverRideBooking $booking) {
            $booking->uid = Str::orderedUuid();
        });
        static::addGlobalScope(BelongsToDriverScope::class);

    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (DriverRideBooking $transaction) {
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

            while (self::where('trx_id', 'RD' . $newOrderNumber)->exists()) {
                $newOrderNumber = (int) $newOrderNumber + 1;
            }

            return 'RD' . $newOrderNumber;
        });
    }

    /**
     * Return the title of the booked item.
     *
     * @return string
     */
    public function getBookedItemTitle()
    {
        return $this->driver->car->name;
    }

    /**
     * The deposit associated with the driver ride booking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function depositable()
    {
        return $this->morphOne(Deposit::class, 'depositable');
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
     * Retrieve a collection of drivers who are associated with this booking and can be notified.
     *
     * The collection contains the id, name, and email of each driver.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotifableUsers()      
    {
        $driver_ids = self::query()->pluck('driver_id');
        $drivers = Driver::select(['id', 'name', 'email'])->whereIn('id', $driver_ids)->get();
        $drivers = $drivers->map(function (Driver $driver) {
            $driver->notifable_type = Driver::class;
            return $driver;
        });
        return $drivers;
    }
}
