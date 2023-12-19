<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'body' => 'nullable|string',
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'shipping_type' => 'nullable|string',
            'delivery' => 'nullable|string',
            'product_id_type' => 'nullable|string',
            'product_id' => 'nullable|string',
            'expiry_date_of_product' => 'nullable|date',
            'sku' => 'nullable',
            'quantity' => 'nullable',
            'is_featured' => 'boolean',
            'manufacturer' => 'nullable|string',
            'weight' => 'nullable|integer|min:0',
            'brand_id' => ['nullable','exists:brands,id'],
            'categories.*' => ['nullable','exists:categories,id'],
            'sizes.*' => ['nullable','exists:sizes,id'],
            'colors.*' => ['nullable','exists:colors,id'],
            'images.*' => ['nullable','mimes:jpeg,jpg,png,gif,webp', 'max:10000'],
        ];
    }
}
