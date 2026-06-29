<?php
 
namespace App\Casts;

use App\Helpers\Fill;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MaskCns implements CastsAttributes
{
    public function __construct(
        private readonly string $column
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        $cns = $attributes[$this->column];

        if (is_null($cns) || empty($cns)) {
            return '-';
        }

        return Fill::maskCns($cns);
    }
 
    public function set(
        Model $model, 
        string $key, 
        mixed $value, 
        array $attributes
    ) {}
}
