<?php

namespace App\Models;

use App\Interface\NotifableUsers;
use App\Traits\AdminLayerTrait;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as SupportCollection;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable implements NotifableUsers
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

    /**
     * Get all admins that can receive notifications.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotifableUsers(): Collection
    {
        $admins = self::select(['id', 'name' , 'email'])->get();
        $admins = $admins->map( function(self $admin) {
            $admin->notifable_type = self::class;
            return $admin;
        });
        return $admins;
    }


}
