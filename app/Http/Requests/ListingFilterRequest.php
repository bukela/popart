<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingFilterRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable|string|min:3|max:255',
            'category' => 'nullable|integer',
            'location' => 'nullable|string|max:100',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
        ];
    }

    public function messages(): array
    {
        return [
            'max_price.gte' => 'Max price must be greater than or equal to min price',
        ];
    }
}
