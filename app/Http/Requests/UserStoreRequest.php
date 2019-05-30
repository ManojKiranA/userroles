<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can( 'user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     */
    public function rules(): array
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     */
    public function messages(): array
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     */
    public function attributes(): array
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization(): void
    {
        throw new AuthorizationException("You Can't Create User");
    }
}
