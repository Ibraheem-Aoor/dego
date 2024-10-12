<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteDestination extends Model
{
    use HasFactory;
    protected $fillable =['id','reaction','user_id','destination_id'];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}
