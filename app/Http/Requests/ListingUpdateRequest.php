<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add authorization logic here if needed.
        // For example, checking if the authenticated user is the creator of the listing.
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
            'title' => 'required|max:255',
            'description' => 'required',
            'tags' => 'array', // Ensure 'tags' is an array in the request
        ];
    }
}
