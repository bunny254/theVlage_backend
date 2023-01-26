<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'listing_type' => ['bail', 'required'],
            'building_type' => ['bail', 'required'],
            'property_name' => ['bail', 'required', 'string', 'max:255'],
            'unit_size' => ['bail', 'nullable', 'string', 'max:255'],
            'stay_type' => ['bail', 'required'],
            'is_furnished' => ['bail', 'nullable'],
            'rent_cost' => ['bail', 'required', 'numeric', 'min:0'],
            'deposit_months' => ['bail', 'nullable', 'numeric', 'min:0'],
            'utilities_cost' => ['bail', 'nullable', 'numeric', 'min:0'],
            'currency' => ['bail', 'required'],
            'bedrooms' => ['bail', 'required', 'numeric', 'min:0'],
            'bathrooms' => ['bail', 'required', 'numeric', 'min:0'],
            'location' => ['bail', 'required', 'string', 'max:255'],
            'latitude' => ['bail', 'nullable'],
            'longitude' => ['bail', 'nullable'],
            'description' => ['bail', 'required', 'string', 'max:10000'],
            'amenities' => ['bail', 'nullable'],
            'cover_image' => ['bail', 'nullable', 'image', 'max:10240'],
            'available_from' => ['bail', 'required', 'string'],
        ];
    }
}
