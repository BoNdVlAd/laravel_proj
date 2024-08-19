<?php

namespace App\Http\Requests\RestaurantRequests;

use App\Http\Requests\BaseRequest;

class RestaurantGetTheNearestRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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

