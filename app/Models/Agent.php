<?php

namespace App\Models;

use App\Traits\AdminLayerTrait;
use App\Traits\HasLastSeenAttribute;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Agent extends Authenticatable
{
    use HasFactory, Notifiable, Notify , SoftDeletes  , HasLastSeenAttribute , AdminLayerTrait;
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
    ];
    protected $appends = ['last-seen-activity'];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleted(function (Agent $agent) {
            $agent->companies()->update(['deleted_at' =>now()]);
        });
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }





}
