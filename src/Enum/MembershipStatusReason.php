<?php

namespace App\Enum;

enum MembershipStatusReason: string
{
    case UNPAID = 'unpaid';
    case MISSING_MEDICAL_CERTIFICATE = 'missing_medical_certificate';

    case DISCIPLINARY_SANCTION = 'disciplinary_sanction';

    case TRIAL_SESSION = 'trial_session';
    case TRIAL_SESSIONS_REMAINING = 'trial_sessions_remaining';

    public function label(): string
    {
        return match($this) {
            self::UNPAID => 'Paiement non reçu',
            self::MISSING_MEDICAL_CERTIFICATE => 'Certificat médical manquant',
            self::DISCIPLINARY_SANCTION => 'Sanction disciplinaire',
            self::TRIAL_SESSIONS_REMAINING => 'Séances d’essai restantes',
        };
    }
}
