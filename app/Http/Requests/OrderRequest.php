<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'delivery_option_id' => ['required', 'uuid', 'exists:delivery_options,id'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_method_id' => ['required', 'uuid', 'exists:payment_methods,id'],
        ];
    }
}
