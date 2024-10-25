<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverCar extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'model',
        'number',
        'max_passengers',
        'driver_id',
        'thumb',
        'thumb_driver',
    ];

    public function driver() : BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
