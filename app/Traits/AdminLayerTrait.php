<?php
namespace App\Traits;

use App\Models\FireBaseToken;
use App\Models\InAppNotification;

trait AdminLayerTrait
{
    /**
     * Common Methods for admin - agent - company - driver
     */

    public function fireBaseToken()
    {
        return $this->morphMany(FireBaseToken::class, 'tokenable');
    }


    public function inAppNotification()
    {
        return $this->morphOne(InAppNotification::class, 'inAppNotificationable', 'in_app_notificationable_type', 'in_app_notificationable_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="' . url('admin/password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
        ]);
    }

    public function profilePicture()
    {
        $disk = $this->image_driver;
        $image = $this->image ?? 'unknown';
        $active = $this->LastSeenActivity == false ? 'warning' : 'success';

        if ($disk == 'local') {
            $localImage = asset('/assets/upload') . '/' . $image;
            $url = \Illuminate\Support\Facades\Storage::disk($disk)->exists($image) ? $localImage : asset(config('filelocation.default'));
        } else {
            $url = \Illuminate\Support\Facades\Storage::disk($disk)->exists($image) ? \Illuminate\Support\Facades\Storage::disk($disk)->url($image) : asset(config('filelocation.default'));
        }
        return '<div class="avatar avatar-sm avatar-circle">
                    <img class="avatar-img" src="' . $url . '" alt="Image Description">
                    <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                 </div>';
        try {
        } catch (\Exception $e) {
            return asset(config('location.default'));
        }
    }
}
