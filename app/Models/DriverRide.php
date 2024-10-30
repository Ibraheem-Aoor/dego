<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverRide extends Model 
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'from',
        'to',
        'price',
        'status',
    ];

    public function driver() : BelongsTo
    {
        return $this->belongsTo(Driver::class , 'driver_id');
    }

}
