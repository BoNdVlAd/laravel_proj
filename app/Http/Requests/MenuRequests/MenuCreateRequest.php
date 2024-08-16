<?php

namespace App\Http\Requests\MenuRequests;

use App\Http\Requests\BaseRequest;

class MenuCreateRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'dishes' => 'required|array',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [

        ];
    }
}
