<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
    case COACH = 'ROLE_COACH';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'Utilisateur',
            self::ADMIN => 'Admin',
            self::COACH => 'Coach',
        };
    }

    public static function choices(): array
    {
        return [
            'Utilisateur' => self::USER->value,
            'Admin' => self::ADMIN->value,
            'Coach' => self::COACH->value,
        ];
    }
}