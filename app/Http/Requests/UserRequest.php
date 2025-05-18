<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user')?->id ?? null;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        return [
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $isUpdate ? 'nullable' : 'required|min:8|confirmed',
            'roles' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The user name is required.',
            'name.max' => 'Username must be less than thirty characters.',
            'email.required' => 'The user email is required.',
            'email.unique' => 'The entered user email is already in use.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least eight characters long.',
            'password.confirmed' => 'No password match',
            'roles.required' => 'A role must be selected for the user.',
        ];
       
    }
}
