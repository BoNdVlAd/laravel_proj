<?php

namespace App\Http\Requests\ProfileRequests;

use App\Http\Requests\BaseRequest;

class SendResetLinkEmailRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email'
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

