<?php

namespace App\Observers;

use App\Models\NotificationSettings;
use App\Models\NotificationTemplate;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        $template_keys = NotificationTemplate::where('notify_for', 0)
            ->where(function ($query) {
                $query->whereNotNull('email')
                    ->orWhereNotNull('push')
                    ->orWhereNotNull('sms')
                    ->orWhereNotNull('in_app');
            })
            ->pluck('template_key');

        $notifyFor = new NotificationSettings();
        $notifyFor->notifyable_id = $user->id;
        $notifyFor->notifyable_type = User::class;
        $notifyFor->template_email_key = $template_keys;
        $notifyFor->template_sms_key = $template_keys;
        $notifyFor->template_push_key = $template_keys;
        $notifyFor->template_in_app_key = $template_keys;
        $notifyFor->save();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
