<?php

namespace App\Casts;

use App\Helpers\Fill;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MaskCpf implements CastsAttributes
{
    public function __construct(
        private readonly string $column
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        $cpf = $attributes[$this->column];

        if (is_null($cpf) || empty($cpf)) {
            return '-';
        }

        return Fill::maskCpf($cpf);
    }
 
    public function set(
        Model $model, 
        string $key, 
        mixed $value, 
        array $attributes
    ) {}
}
