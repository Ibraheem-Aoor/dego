<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class Booking extends Model
{
    use HasFactory , Prunable;

    protected $fillable =['id','message','adult_info','uid','startPoint','startMessage','endPoint','endMessage','child_info','infant_info','cupon_number','coupon','phone','date','trx_id','address_two','address_one','country','state','city','postal_code','email','lname'.'fname','duration','package_title','discount_amount','user_id','deposit_id','total_price','total_person','total_infant','start_price','package_id','cupon_status','status'];


    protected $casts = [
        'adult_info'=> 'array',
        'child_info'=> 'array',
        'infant_info'=> 'array',
    ];
    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->uid = Str::orderedUuid();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function depositable()
    {
        return $this->morphOne(Deposit::class, 'depositable');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Booking $transaction) {
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
                $lastOrderNumber = (int)filter_var($lastOrder->trx_id, FILTER_SANITIZE_NUMBER_INT);
                $newOrderNumber = $lastOrderNumber + 1;
            } else {
                $newOrderNumber = strRandomNum(12);
            }

            while (self::where('trx_id', 'B'.$newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }

            return 'B' . $newOrderNumber;
        });
    }

    public function prunable(): Builder
    {
        return static::where('date', '<=', now()->subDays(5))->where('status', 0);
    }
}
