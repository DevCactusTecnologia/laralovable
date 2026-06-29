<?php
 
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MaskMoney implements CastsAttributes
{
    public function __construct(
        private readonly string $column
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        $money = $attributes[$this->column];

        if (is_null($money)) {
            return '-';
        }

        return 'R$ ' . number_format($money, 2, ',', '.');
    }
 
    public function set(
        Model $model, 
        string $key, 
        mixed $value, 
        array $attributes
    ) {}
}
