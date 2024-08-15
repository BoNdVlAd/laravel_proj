<?php

namespace App\Http\Requests\MediaRequests;

use App\Http\Requests\BaseRequest;

class UploadFileRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ];
    }

    /**
     * @return string[]
     */
    public function messages() : array
    {
        return [
            'file.required' => 'The file is required.',
            'file.file' => 'The file should be file',
            'file.mimes' => 'The file type should be jpg, png, pdf',
            'file.max' => 'The file size should be 2MB',
        ];
    }
}
