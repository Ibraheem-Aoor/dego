<?php

namespace App\Http\Requests\Car;

use App\Rules\ValidDatesString;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProcceedToCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required'  , new ValidDatesString()],
        ];
    }
}
