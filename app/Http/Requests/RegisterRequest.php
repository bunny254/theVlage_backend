<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class RegisterRequest extends FormRequest
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
            'role' => ['bail', 'required'],
            'first_name' => ['bail', 'required', 'string', 'max:255'],
            'last_name' => ['bail', 'nullable', 'string', 'max:255'],
            'surname' => ['bail', 'required', 'string', 'max:255'],
            'id_number' => ['bail', 'required', 'string', 'max:255'],
            'id_type' => ['bail', 'required', Rule::in(['ALIEN_CARD', 'NATIONAL_ID', 'PASSPORT'])],
            'gender' => ['bail', 'required', 'string'],
            'email' => [
                'bail', 'required', 'email',
                Rule::unique('users')
            ],
            'phone_number' => [
                'bail', 'required', 'string', 'min:10', 'max:15',
                Rule::unique('users')
            ],
            'password' => ['bail', 'required', 'string', new Password],
        ];
    }
}
