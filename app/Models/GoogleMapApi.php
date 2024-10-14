<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleMapApi extends Model
{
    use HasFactory;

    protected $fillable = ['id','status','api_key'];
}