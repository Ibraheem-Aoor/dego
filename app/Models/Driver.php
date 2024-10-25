<?php

namespace App\Models;

use App\Traits\HasLastSeenAttribute;
use App\Traits\HasProfilePicture;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Driver extends  Authenticatable
{
    use HasFactory, Notifiable, Notify, SoftDeletes, HasProfilePicture, HasLastSeenAttribute;
    protected $fillable = [
        'name',
        'username',
        'email',
        'country',
        'password',
        'remember_token',
        'status',
        'image',
        'image_driver',
        'phone',
        'last_login',
        'last_seen',
        'to_airport_price',
        'from_airport_price'
    ];
    protected $appends = ['last-seen-activity'];

    protected $hidden = [
        'remember_token',
        'password',
    ];
}
