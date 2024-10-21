<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDatesString implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $booking_dates = array_map('trim' , explode(',', $value));
        if (empty($booking_dates) || !array_reduce($booking_dates, function ($carry, $date) {
            return $carry && (bool) strtotime($date);
        }, true)) {
            $fail(__("Invalid Date Selected"));
        }
    }
}
