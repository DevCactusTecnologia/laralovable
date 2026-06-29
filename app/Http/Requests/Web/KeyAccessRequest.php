<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

final class KeyAccessRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'access_key' => ['required', 'digits:8'],
        ];
    }

    public function attributes(): array
    {
        return [
            'access_key' => '<strong>chave de acesso</strong>',
        ];
    }
}
