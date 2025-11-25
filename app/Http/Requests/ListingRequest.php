<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|in:new,used',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
        ];
    }
}
