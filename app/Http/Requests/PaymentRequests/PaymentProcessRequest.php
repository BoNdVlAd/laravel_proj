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
            'number' => 'max:16',
            'cvc' => 'integer|digits:3',
            'description' => 'string|max:255',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.max' => 'The number field must not exceed 16 characters.',
        ];
    }
}

