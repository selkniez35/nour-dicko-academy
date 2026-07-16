<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'ROLE_ADMIN';
    case TEACHER = 'ROLE_TEACHER';
    case STUDENT = 'ROLE_STUDENT';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::TEACHER => 'Enseignant',
            self::STUDENT => 'Étudiant'
        };
    }

    public static function choices(): array
    {
        return [
            'Admin' => self::ADMIN->value,
            'Enseignant' => self::TEACHER->value,
            'Étudiant' => self::STUDENT->value,
        ];
    }
}
