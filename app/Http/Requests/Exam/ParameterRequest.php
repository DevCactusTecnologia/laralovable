<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

final class ParameterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parameter' => ['nullable'],
            'type' =>['nullable'],
            'formula' =>['nullable'],
            'size' => ['nullable'],
            'minimum' => ['nullable'],
            'maximum' => ['nullable'],
            'decimal_places' => ['nullable'],
            'required' => ['nullable'],
            'with_previous_result' => ['nullable'],
            'with_printed_map' => ['nullable'],
            'is_active' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'parameter' => 'parâmetro (##NOME##)',
            'type' => 'tipo',
            'fórmula' => 'fórmula',
            'size' => 'quantidade de caracteres',
            'minimum' => 'valor mínimo',
            'maximum' => 'valor máximo',
            'decimal_places' => 'casas decimais',
            'required' => 'obrigatório',
            'with_previous_result' => 'com resultado anterior',
            'with_printed_map' => 'impresso no mapa',
            'is_active' => 'status',
        ];
    }

    protected function prepareForValidation(): void
    {   
        $actionName = $this->id ? 'atualizado' : 'criado';

        $this->merge([
            'parameter' => trim(mb_strtoupper($this->parameter)),
            'message' => "Parâmetro {$actionName} com sucesso!",
        ]);
    }
}
