<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$this->user()->id,
            'image' => 'image|mimes:png,jpeg|max:2048',
        ];
    }
}
