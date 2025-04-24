<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class StoreReceiptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'receipt' => ['required', 'file', File::types(['jpg', 'jpeg', 'png', 'pdf', 'tiff', 'heic'])->max(10240)],
        ];
    }
}
