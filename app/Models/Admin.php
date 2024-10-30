<?php

namespace App\Models;

use App\Traits\AdminLayerTrait;
use App\Traits\Notify;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Notify, AdminLayerTrait;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'image',
        'image_driver',
        'phone',
        'address',
        'admin_access',
        'last_login',
        'status',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];


    public function blog()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }


}
