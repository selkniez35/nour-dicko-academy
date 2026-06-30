<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CARD = 'card';
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';

    public function label(): string
    {
        return match ($this) {
            self::CARD => 'Carte bancaire',
            self::CASH => 'Espèces',
            self::BANK_TRANSFER => 'Virement bancaire',
        };
    }
}