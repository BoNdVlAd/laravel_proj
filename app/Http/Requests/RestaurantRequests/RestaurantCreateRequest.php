<?php

namespace App\Http\Requests\RestaurantRequests;

use App\Http\Requests\BaseRequest;

class RestaurantCreateRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
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

