<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'receipt_id' => [
                'required',
                'uuid',
                Rule::exists('receipts', 'id'),
            ],
            'rating'     => ['required','integer','between:1,5'],
            'text'       => ['nullable','string','max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'receipt_id.required' => 'ID чека обязателен.',
            'receipt_id.exists'   => 'Чек не найден.',
            'rating.between'      => 'Оценка должна быть между 1 и 5.',
        ];
    }
}
