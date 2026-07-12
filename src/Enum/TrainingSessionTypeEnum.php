<?php

namespace App\Enum;

enum TrainingSessionTypeEnum: string
{
    case ENGLISH_BOXING = 'english_boxing';
    case MMA = 'mma';
    case FITNESS = 'fitness';

    public function label(): string
    {
        return match ($this) {
            self::ENGLISH_BOXING => 'Boxe anglaise',
            self::MMA => 'MMA',
            self::FITNESS => 'Fitness',
        };
    }

    public static function choices(): array
    {
        return [
            self::ENGLISH_BOXING->label() => self::ENGLISH_BOXING,
            self::MMA->label() => self::MMA,
            self::FITNESS->label() => self::FITNESS,
        ];
    }
}