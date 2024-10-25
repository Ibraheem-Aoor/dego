<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverAirportPrice extends BaseDriverRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from_airport_price' => 'integer|numeric|gt:0',
            'to_airport_price' => 'integer|numeric|gt:0',
        ];
    }
}
