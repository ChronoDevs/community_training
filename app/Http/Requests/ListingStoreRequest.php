<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // The authorization logic should be implemented here based on your application's requirements.
        // You can define the authorization rules that allow or deny the request.
        // If the method returns 'true', the request is authorized; otherwise, it's denied.
        // For example, you might restrict this request to authenticated users only:
        // return auth()->check();
        // If you want to allow all requests (no authorization check), you can return 'true'.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Define the validation rules for the listing creation request.
        // In this example, 'title' is required and limited to 255 characters,
        // 'description' is required, and 'tags' should be an array.
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'tags' => 'array', // Ensure 'tags' is an array in the request
        ];
    }
}
