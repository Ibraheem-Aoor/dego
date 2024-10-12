<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable =['id','country_id','name','country_code','status'];

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function cities(){
        return $this->hasMany(City::class,'state_id');
    }
}
