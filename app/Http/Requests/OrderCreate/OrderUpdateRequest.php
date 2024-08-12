<?php

namespace App\Http\Requests\OrderCreate;

use App\Http\Requests\BaseRequest;
use App\Rules\PaymentCheckRule;
use Illuminate\Validation\Validator;

class OrderUpdateRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            '*' =>[new PaymentCheckRule],
            'payment_method' => 'max:255',
            'total_price' => 'integer',
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

    /**
     * @param Validator $validator
     * @return void
     */

}

