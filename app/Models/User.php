<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Notify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'referral_id',
        'language_id',
        'email',
        'country_code',
        'country',
        'phone_code',
        'phone',
        'balance',
        'image',
        'image_driver',
        'state',
        'city',
        'zip_code',
        'address_one',
        'address_two',
        'provider',
        'provider_id',
        'status',
        'identity_verify',
        'address_verify',
        'two_fa',
        'two_fa_verify',
        'two_fa_code',
        'email_verification',
        'sms_verification',
        'verify_code',
        'time_zone',
        'sent_at',
        'last_login',
        'last_seen',
        'password',
        'email_verified_at',
        'remember_token',
        'about_me'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['last-seen-activity'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('userRecord');
        });
    }

    public function funds()
    {
        return $this->hasMany(Fund::class)->latest()->where('status', '!=', 0);
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class)->latest();
    }


    public function getLastSeenActivityAttribute()
    {
        if (Cache::has('user-is-online-' . $this->id) == true) {
            return true;
        } else {
            return false;
        }
    }


    public function inAppNotification()
    {
        return $this->morphOne(InAppNotification::class, 'inAppNotificationable', 'in_app_notificationable_type', 'in_app_notificationable_id');
    }

    public function fireBaseToken()
    {
        return $this->morphMany(FireBaseToken::class, 'tokenable');
    }

    public function profilePicture()
    {
        $image = $this->image;
        if (!$image) {
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            $firstLetter = substr($this->firstname, 0, 1);
            return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                        <span class="avatar-initials">' . $firstLetter . '</span>
                        <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                     </div>';

        } else {
            $url = getFile($this->image_driver, $this->image);
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            return '<div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                        <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                     </div>';

        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="' . url('password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
        ]);
    }

    public function notifypermission()
    {
        return $this->morphOne(NotificationSettings::class, 'notifyable');
    }

    public function reaction()
    {
        return $this->hasMany(FavouriteList::class, 'user_id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'user_id')->whereIn('status', [1, 2, 4]);
    }

    public function getBookingForPackage($packageId)
    {
        return $this->booking()
            ->where('package_id', $packageId)
            ->whereIn('status', [1,2])
            ->first();
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function notifySetting()
    {
        return $this->morphOne(NotificationSettings::class, 'notifyable');
    }

    public function rideBookings() : HasMany
    {
        return $this->hasMany(DriverRideBooking::class  , 'user_id');
    }
}
