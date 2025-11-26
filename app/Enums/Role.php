<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::CUSTOMER => 'Customer',
        };
    }
}
