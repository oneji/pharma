<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'phone' => 'nullable',
            'note' => 'nullable',
            'discount_amount' => 'nullable',
            'status' => 'integer|in:1,0',
            'role' => 'required',
            'responsible_manager_id' => 'nullable',
            'company_id' => 'nullable'
        ];
    }
}
