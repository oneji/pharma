<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'name' => 'required|max:255',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'nullable',
            'note' => 'nullable',
            'discount_amount' => 'integer|nullable',
            'role' => 'required',
            'responsible_manager_id' => 'nullable',
            'company_id' => 'nullable'
        ];
    }
}
