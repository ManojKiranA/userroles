<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return bool
     */
    public function authorize():bool
    {
        return $this->user()->can( 'user_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return array
     */
    public function rules():array
    {
        return [
            'name' => 'bail|required',
            'email' => 'required|unique:users,email,'.$this->user->id,
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return array
     */
    public function messages():array
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization(): void
    {
        throw new AuthorizationException("You Can't Update User");
    }
}
