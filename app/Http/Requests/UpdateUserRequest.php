<?php

namespace App\Http\Requests;

use App\Enums\ThemeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['nullable', 'string', 'max:255'],
            'theme'    => ['nullable', new Enum(ThemeType::class)],
        ];
    }

    public function messages(): array
    {
        $themes = array_map(
            fn(ThemeType $t) => $t->value,
            ThemeType::cases()
        );

        return [
            'theme.enum'   => 'Тема должна быть одной из: ' . implode(', ', $themes),
            'username.max' => 'Имя должно быть не длиннее 255 символов.',
        ];
    }
}
