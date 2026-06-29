<?php

namespace App\Helpers;

final class Sanitize
{
    public static function number($value): array|string|null
    {
        return preg_replace('/[^\d]/', '', $value);
    }
}
