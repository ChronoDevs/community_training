<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Define your authorization logic here.
        // For example, you might check if the user is authenticated or has specific permissions.
        // Return true if authorized, false otherwise.
        return auth()->check(); // Example: Allow only authenticated users to make a reply
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string', // Adjust validation rules as needed
        ];
    }
}
