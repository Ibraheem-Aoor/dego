<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReaction extends Model
{
    use HasFactory;

    protected $fillable = ['id','reaction_dislike','reaction_like','user_id','package_id','review_id'];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
