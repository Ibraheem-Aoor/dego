<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['id','iso2','name','status','send_to','receive_from','image','image_driver','phone_code','iso3','region','subregion'];

    public function state(){
        return $this->hasMany(State::class,'country_id');
    }

    public function city(){
        return $this->hasMany(City::class,'country_id');
    }

}
