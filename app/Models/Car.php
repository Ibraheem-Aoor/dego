<?php

namespace App\Models;

use App\Models\Scopes\BelongsToCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(BelongsToCompanyScope::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function media()
    {
        return $this->hasMany(CarMedia::class, 'car_id');
    }
}
