<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'check_in_date' => ['bail', 'required', 'date_format:d/m/Y'],
            'check_out_date' => ['bail', 'required', 'date_format:d/m/Y'],
            'number_of_guests' => ['bail', 'required', 'numeric', 'min:1'],
            'price' => ['bail', 'required', 'numeric', 'min:1'],
            'rent_cost' => ['bail', 'required', 'numeric', 'min:1'],
            'deposit_cost' => ['bail', 'nullable', 'numeric', 'min:0'],
            'amenities_cost' => ['bail', 'nullable', 'numeric', 'min:0'],
            'other_costs' => ['bail', 'nullable']
        ];
    }

}
