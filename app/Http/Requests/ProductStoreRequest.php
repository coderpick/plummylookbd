<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'code' => 'nullable|unique:products',
            'slug' => 'required|unique:products',
            'shop_id' => 'nullable',
            'size' => 'nullable',
            'color' => 'nullable',
            'details' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'price' => 'required|numeric|min:0|not_in:0',
            'new_price' => 'nullable|numeric|min:0|not_in:0',
            'stock' => 'required|numeric|min:0',
            'point' => 'nullable|numeric|min:0|not_in:0',
            'status' => 'required',
            'made_in' => 'nullable|string',
            'images.*' => 'required|image',         
            'category_id' => 'required',
            'brand_id' => 'required',
            'sub_category_id' => 'nullable|integer',
        ];
    }
}
