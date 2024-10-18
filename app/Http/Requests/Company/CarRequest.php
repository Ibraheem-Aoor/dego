<?php

namespace App\Http\Requests\Company;

use App\Enum\EngineTypeEnum;
use App\Enum\TransmissionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CarRequest extends BaseCompanyRequest
{
    protected $stopOnFirstFailure = false;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $thumb_rules = ['required', 'mimes:png,jpeg,gif', 'max:2048'];
        $images_rules = ['required', 'array'];
        $images_elements_rules = ['required', 'image', 'mimes:jpeg,png,jpg', 'max:10240'];
        if($this->route()->name('company.car.update')) {
            $thumb_rules = ['sometimes', 'mimes:png,jpeg,gif', 'max:2048'];
            $images_rules = ['required_without:preloaded', 'array'];
            $images_elements_rules = ['required_without:preloaded', 'image',  'max:10240'];
        }
        return [
            'name' => ['required', 'string', 'max:255'],
            'engine_type' => ['required', 'string', 'max:255', Rule::enum(EngineTypeEnum::class)],
            'transmission_type' => ['required', 'string', 'max:255', Rule::enum(TransmissionTypeEnum::class)],
            'doors_count' => ['required', 'integer'],
            'passengers_count' => ['required', 'integer'],
            'storage_bag_count' => ['required', 'integer'],
            'rent_price' => ['required', 'integer'],
            'insurance_price' => ['required', 'integer'],
            'pickup_location' => ['required', 'url'],
            'drop_location' => ['required', 'url'],
            'fuel_policy' => ['required', 'string'],
            'insurance_info' => ['required', 'string'],
            'thumb' => $thumb_rules,
            'images' => $images_rules,
            'images.*' => $images_elements_rules
        ];
    }
}
