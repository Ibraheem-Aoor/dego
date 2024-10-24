<?php
namespace App\Traits;
trait HasProfilePicture
{
    public function profilePicture()
    {
        $image = $this->image;
        if (!$image) {
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            $firstLetter = substr($this->name, 0, 1);
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
}
