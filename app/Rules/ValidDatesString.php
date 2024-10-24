<?php

namespace App\Rules;

use App\Models\CarBooking;
use App\Models\CarBookingDate;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDatesString implements ValidationRule
{

    protected $message = '';
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $booking_dates = $value;

        if (
            $this->isValidDates($booking_dates) &&
            $this->availableBookingDates($booking_dates)
        ) {
            //
        } else {
            $fail($this->message);
        }
    }

    /**
     * Checks if the given dates are valid.
     *
     * @param string $booking_dates
     *
     * @return bool
     */
    private function isValidDates($booking_dates)
    {
        $booking_dates = getDatesArrayFromString($booking_dates);


        if (
            empty($booking_dates) || !array_reduce($booking_dates, function ($carry, $date) {
                return $carry && (bool) strtotime($date);
            }, true)
        ) {
            $this->message = __('Invalid Date Selected');
            return false;
        }
        return true;
    }


    /**
     * Check if the given dates are available or not.
     *
     * @param string $booking_dates
     *
     * @return bool
     */
    private function availableBookingDates($booking_dates)
    {
        // TODO : fix bug of updating same dates in carCheckoutController

        $booking_dates = getDatesArrayFromString($booking_dates);

        $invalid_slots = CarBookingDate::query()
            ->whereHas('booking', function ($query) {
                $query->withConfirmedDeposit();
            })
            ->whereIn('date', $booking_dates)
            ->pluck('date')
            ->toArray();

        if (!empty($invalid_slots)) {
            $this->message = __('Dates Not Available: ') . implode(',', $invalid_slots);
            return false;
        }

        return true;
    }

}
