<?php

namespace App\Enum;
enum StudentLevelEnum: string
{
    case LEVEL_1 = "Lire l'arabe et le Coran de manière fluide";
    case LEVEL_2 = "Lire l'arabe et le Coran mais avec quelques difficultés";
    case LEVEL_3 = "Reconnaître quelques lettres";
    case LEVEL_4 = "Je ne sais pas lire l'arabe ni le Coran";

    function label(): string
    {
        return match ($this) {
            self::LEVEL_1 => "Lire l'arabe et le Coran de manière fluide",
            self::LEVEL_2 => "Lire l'arabe et le Coran mais avec quelques difficultés",
            self::LEVEL_3 => "Reconnaître quelques lettres",
            self::LEVEL_4 => "Je ne sais pas lire l'arabe ni le Coran",
        };
    }
}
