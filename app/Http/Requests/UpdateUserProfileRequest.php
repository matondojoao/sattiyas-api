<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'name'=>['nullable'],
            'email'=>['nullable','email'],
            'phone'=>['nullable'],
            'alternative_phone'=>['nullable'],
            'gender'=>['nullable','in:women,man'],
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
