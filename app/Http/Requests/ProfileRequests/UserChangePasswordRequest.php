<?php

namespace App\Http\Requests\ProfileRequests;

use App\Http\Requests\BaseRequest;

class UserChangePasswordRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'old_password.min' => 'The old_password field must be at least 8 characters.',
            'old_password.required' => 'The old_password field is required.',

            'new_password.min' => 'The new_password field must be at least 8 characters.',
            'new_password.required' => 'The new_password field is required.',
        ];
    }
}

