<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverCar extends BaseDriverRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'type' => 'string|max:255',
            'model' => 'string|max:255',
            'number' => 'string|max:255',
            'max_passengers' => 'integer',
            'thumb' => 'required', 'mimes:png,jpeg,gif', 'max:2048',
        ];
    }
}
