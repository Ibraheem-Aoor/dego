<?php

namespace App\Models;

use App\Interface\DepositableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class DriverRideBooking extends Model implements DepositableInterface
{
    use HasFactory;
    protected $guarded = [];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
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

}
