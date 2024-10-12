<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CurrentPassword implements Rule
{
    public function passes($attribute, $value)
    {
        $user = Auth::user();

        return Hash::check($value, $user->password);
    }

    public function message()
    {
        return 'The current password is incorrect.';
    }
}
