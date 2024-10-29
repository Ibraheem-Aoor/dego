<?php

namespace App\Http\Requests\Driver;

use App\Enum\DriverDestinationEnum;
use App\Models\Driver;
use App\Rules\ValidDatesString;
use App\Rules\ValidDateTimeForRideBooking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProccedToCheckout extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', new ValidDateTimeForRideBooking(decrypt($this->route('id')))],
            'latitude' => 'required',
            'longitude' => 'required',
            'service' => ['required'  , Rule::enum(DriverDestinationEnum::class)],
            'ride' => ['required_if:service,' . DriverDestinationEnum::BETWEEN_CITIES->value],
        ];
    }

}
