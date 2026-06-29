<?php

namespace App\Casts;

use App\Helpers\Fill;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MaskCnpj implements CastsAttributes
{
    public function __construct(
        private readonly string $column
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        $cnpj = $attributes[$this->column];

        if (is_null($cnpj) || empty($cnpj)) {
            return '-';
        }

        return Fill::maskCnpj($cnpj);
    }
 
    public function set(
        Model $model, 
        string $key, 
        mixed $value, 
        array $attributes
    ) {}
}
