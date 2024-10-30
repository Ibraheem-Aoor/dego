<?php

namespace App\Models;

use App\Models\Scopes\BelongsToCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'long',
        'lat',
        'country',
        'slug',
        'details',
        'state',
        'city',
        'place',
        'title',
        'thumb_driver',
        'thumb',
        'map',
        'status',
        'created-at',
        'company_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope(BelongsToCompanyScope::class);
    }

    protected $casts = [
        'place' => 'object'
    ];
    public function reaction()
    {
        return $this->hasMany(FavouriteDestination::class, 'destination_id');
    }
    public function package()
    {
        return $this->hasMany(Package::class, 'destination_id');
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
    public function visitor()
    {
        return $this->hasMany(DestinationVisitor::class, 'destination_id');
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class  , 'company_id');
    }

}
