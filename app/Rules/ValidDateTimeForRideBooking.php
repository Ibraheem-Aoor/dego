<?php

namespace App\Rules;

use App\Models\CarBooking;
use App\Models\CarBookingDate;
use App\Models\DriverRideBooking;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDateTimeForRideBooking implements ValidationRule
{

    protected $message = '';

    public function __construct(protected  $driver_id)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = $value;
        if (
            $this->isValidDates($date) &&
            $this->availableBookingDates( $date)
        ) {
        } else {
            $fail($this->message);
        }
    }

    /**
     * Checks if the given dates are valid.
     *
     * @param string $date
     *
     * @return bool
     */
    private function isValidDates($date)
    {
        if (empty($date) || !strtotime($date)) {
            $this->message = __('Invalid Date Time Selected');
            return false;
        }
        return true;
    }


    /**
     * Check if the given dates are available or not.
     *
     * @param string $date
     *
     * @return bool
     */
    private function availableBookingDates($date)
    {
        $invalid_slots = DriverRideBooking::query()
        ->where('driver_id' , $this->driver_id)
            ->where('date', $date)
            ->whereIn('status' , [1,2]) // if a booking with completed or pending status exists then it is not available
            ->first();

        if (!empty($invalid_slots)) {
            $this->message = __('Booking Date Not Available , Choose another one');
            return false;
        }

        return true;
    }

}
