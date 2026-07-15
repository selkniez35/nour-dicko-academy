<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
    case TEACHER = 'ROLE_TEACHER';
    case STUDENT = 'ROLE_STUDENT';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'Utilisateur',
            self::ADMIN => 'Admin',
            self::TEACHER => 'Enseignant',
            self::STUDENT => 'Étudiant'
        };
    }

    public static function choices(): array
    {
        return [
            'Utilisateur' => self::USER->value,
            'Admin' => self::ADMIN->value,
            'Enseignant' => self::TEACHER->value,
            'Étudiant' => self::STUDENT->value,
        ];
    }
}
