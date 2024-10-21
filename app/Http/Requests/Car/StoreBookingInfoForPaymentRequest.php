<?php

namespace App\Http\Requests\Car;

use App\Rules\ValidDatesString;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingInfoForPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address_one' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'date' => ['required'  , new ValidDatesString()],
            'message' => 'nullable',
        ];
    }
}
