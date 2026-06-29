<?php
 
namespace App\Casts;

use App\Helpers\Fill;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MaskNis implements CastsAttributes
{
    public function __construct(
        private readonly string $column
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        $nis = $attributes[$this->column];

        if (is_null($nis) || empty($nis)) {
            return '-';
        }

        return Fill::maskNis($nis);
    }
 
    public function set(
        Model $model, 
        string $key, 
        mixed $value, 
        array $attributes
    ) {}
}
