<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class PermissionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can( 'permission_create');
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
            'name' => 'bail|required|unique:permissions',
            'description' => 'required',
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
            'name.unique'  => ':attribute  Already Exists',
            'description.required'  => ':attribute is Required',
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
            'name' => 'Permission Name',
            'description' => 'Permission Description',

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
        throw new AuthorizationException("You Can't Create Permission");
    }
}
