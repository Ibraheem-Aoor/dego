<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarBookingDate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function booking() : BelongsTo
    {
        return $this->belongsTo(CarBooking::class , 'car_booking_id');
    }

    public function car() : BelongsTo
    {
        return $this->belongsTo(Car::class , 'car_id');
    }
}
