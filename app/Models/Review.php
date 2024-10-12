<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable =['id','package_id','review','rating','user_id','status'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
    public function reaction()
    {
        return $this->hasMany(ReviewReaction::class, 'review_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
