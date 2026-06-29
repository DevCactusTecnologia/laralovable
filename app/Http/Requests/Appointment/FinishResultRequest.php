<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

final class FinishResultRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'message' => 'Atendimento finalizado com sucesso, documento pronto para ser visualizado e impresso.',
        ]);
    }
}
