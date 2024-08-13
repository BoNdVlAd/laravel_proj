<?php

namespace App\Http\Requests\PaymentRequests;

use App\Http\Requests\BaseRequest;
use App\Rules\PaymentCheckRule;

class PaymentProcessRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' =>[new PaymentCheckRule],
            'number' => 'max:255',
            'description' => 'string|max:255',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must not exceed 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'status.string' => 'status String'
        ];
    }
}

