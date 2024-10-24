<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasLastSeenAttribute
{
    public function getLastSeenActivityAttribute()
    {
        if (Cache::has('user-is-online-' . $this->id) == true) {
            return true;
        } else {
            return false;
        }
    }
}
