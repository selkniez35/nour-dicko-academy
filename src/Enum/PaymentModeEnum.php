<?php

namespace App\Enum;

enum PaymentModeEnum: string
{
    case ONE_TIME = '1fois';
    case TWO_TIMES = '2fois';
    case FOUR_TIMES = '4fois';
    case TEN_TIMES = '10fois';

    public function label(): string
    {
        return match ($this) {
            self::ONE_TIME => 'En 1 fois',
            self::TWO_TIMES => 'En 2 fois',
            self::FOUR_TIMES => 'En 4 fois',
            self::TEN_TIMES => 'En 10 fois',
        };
    }
}
