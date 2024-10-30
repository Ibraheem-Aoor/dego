<?php

namespace App\Models;

use App\Enum\DriverDestinationEnum;
use App\Traits\AdminLayerTrait;
use App\Traits\HasLastSeenAttribute;
use App\Traits\HasProfilePicture;
use App\Traits\Notify;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class Driver extends  Authenticatable
{
    use HasFactory, Notifiable, Notify, SoftDeletes, HasLastSeenAttribute , AdminLayerTrait;
    protected $fillable = [
        'thumb',
        'thumb_driver',
        'name',
        'username',
        'email',
        'country',
        'password',
        'remember_token',
        'status',
        'image',
        'image_driver',
        'phone',
        'last_login',
        'last_seen',
        'to_airport_price',
        'from_airport_price'
    ];
    protected $appends = ['last-seen-activity'];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    public function car(): HasOne
    {
        return $this->hasOne(DriverCar::class);
    }


    public function rides() : HasMany
    {
        return $this->hasMany(DriverRide::class , 'driver_id');
    }

    public static function minAirportPrice()
    {
        return self::where('status', 1)->min('from_airport_price');
    }
    public static function maxAirportPrice()
    {
        return self::where('status', 1)->min('from_airport_price');
    }

    public static function getTotalPriceFromRequest(Request $request ,  $id)
    {
        $booked_service = $request->service;
        $driver = self::query()->findOrFail($id);
        $price = 0;
        if($booked_service == DriverDestinationEnum::BETWEEN_CITIES->value)
        {
            $ride = $driver->rides->where('status' , 1)->find($request->ride);
            $price  = $ride?->price;
        }else{
            $price_field = $booked_service.'_price';
            $price = $driver->$price_field;
        }
        return $price == 0 ? throw new Exception( 'No Price Found') : $price;
    }
}
