<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can( 'user_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required',
            'email' => 'required|unique:users,email,'.$this->user->id,
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => ':attribute is Required',
            'email.required'  => ':attribute is Required',
            'email.unique'  => ':attribute is Already Registered',
            'password.required'  => ':attribute is Required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'Email Address',
            'name' => 'Name',
            'password' => 'Password',
        ];
    }
}
