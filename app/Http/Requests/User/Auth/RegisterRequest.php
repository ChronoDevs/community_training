<?php

namespace App\Http\Requests\User\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'user_name' => ['nullable', 'string', 'unique:users'],
            'nickname' => ['nullable', 'string'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'date_of_birth' => ['nullable', 'date'],
            'contact_number' => ['nullable', 'string'],
            'zip_code' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
        ];
    }
}
