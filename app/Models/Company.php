<?php

namespace App\Models;

use App\Traits\AdminLayerTrait;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Company extends Authenticatable
{
    use HasFactory, Notifiable, Notify ,  SoftDeletes , AdminLayerTrait;
    protected $fillable = [
        'name',
        'username',
        'email',
        'agent_id',
        'password',
        'remember_token',
        'status',
        'image',
        'image_driver',
        'phone',
        'last_login',
        'last_seen',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];




    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
