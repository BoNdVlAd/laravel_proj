<?php

namespace App\Http\Requests\MediaRequests;

use App\Http\Requests\BaseRequest;

class MediaUpdateRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'filename' => 'required|string|max:255',
            'mime_type' => 'string',
            'size' => 'required|integer',
            'url' => 'required|string|max:255',
        ];
    }

    /**
     * @return string[]
     */
    public function messages() : array
    {
        return [
            'filename.required' => 'The filename field is required.',
            'filename.string' => 'The filename must be a string.',
            'filename.max' => 'The filename must not exceed 255 characters.',
            'filename.unique' => 'The filename has already been used.',

            'mime_type.string' => 'The MIME type must be a string.',

            'size.required' => 'The size field is required.',
            'size.integer' => 'The size must be an integer.',

            'url.required' => 'The URL field is required.',
            'url.string' => 'The URL must be a string.',
            'url.max' => 'The URL must not exceed 255 characters.',
        ];
    }
}
