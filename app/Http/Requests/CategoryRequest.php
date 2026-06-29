<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return [
                'abbreviation' => ['required', 'max:191', 'unique:categories'],
                'name' =>['required', 'max:191', 'unique:categories'],
            ];
        }

        return [
            'abbreviation' => ['required', 'max:191', Rule::unique('categories')->ignore($this->category->id)],
            'name' => ['required', 'max:191', Rule::unique('categories')->ignore($this->category->id)],
            'is_active' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'abbreviation' => 'abreviação',
            'name' => 'nome',
        ];
    }

    protected function prepareForValidation(): void
    {
        $actionName = $this->isMethod('POST') ? 'criado' : 'alterado';

        $this->merge([
            'abbreviation' => trim(mb_strtoupper($this->abbreviation)),
            'name' => trim(mb_strtoupper($this->name)),
            'message' => "Setor {$actionName} com sucesso!",
        ]);
    }
}
