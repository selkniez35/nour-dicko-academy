<?php

namespace App\Enum;
enum MembershipStatus: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case PENDING = 'pending';
    case TRIAL = 'trial';

    function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Actif',
            self::SUSPENDED => 'Suspendu',
            self::PENDING => 'En attente',
            self::TRIAL => 'Séance d’essai',
        };
    }
}
