<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarBooking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function car() : BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function bookingDates() : HasMany
    {
        return $this->hasMany(CarBookingDate::class , 'car_booking_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
