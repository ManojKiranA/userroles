<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return $this->user()->can( 'user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'name' => 'bail|required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages():array
    {
        return [
            'name.required' => ':attribute is Required',
            'email.required'  => ':attribute is Required',
            'email.unique'  => ':attribute is Already Registered',
            'email.email'  => ':attribute is Not Valid Email',
            'password.required'  => ':attribute is Required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes():array
    {
        return [
            'email' => 'Email Address',
            'name' => 'Name',
            'password' => 'Password',
        ];
    }
    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization():void
    {
        throw new AuthorizationException("You Can't Create User");
    }
}
