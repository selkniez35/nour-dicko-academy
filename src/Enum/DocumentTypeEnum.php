<?php

namespace App\Enum;

enum DocumentTypeEnum: string
{
    case CERTIFICATE_MEDICAL = 'medical_certificate';
    case PHOTO_IDENTITY = 'identity_photo';
    case PIECE_IDENTITY = 'identity_document';

    public function label(): string
    {
        return match ($this) {
            self::CERTIFICATE_MEDICAL => 'Certificat médical',
            self::PHOTO_IDENTITY => "Photo d'identité",
            self::PIECE_IDENTITY => "Pièce d'identité",
        };
    }

    public static function choices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->label()] = $case->value;
        }
        return $choices;
    }
}