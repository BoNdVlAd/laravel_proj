<?php

namespace App\Http\Requests\ProfileRequests;

use App\Http\Requests\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
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

