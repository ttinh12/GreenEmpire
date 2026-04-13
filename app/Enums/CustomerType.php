<?php

namespace App\Enums;

enum CustomerType: int
{
    case COMPANY = 1;
    case SCHOOL = 2;
    case GOVERNMENT = 3;
    case INDIVIDUAL = 4;

    public function label(): string
    {
        return match ($this) {
            self::COMPANY => 'Công ty',
            self::SCHOOL => 'Trường học',
            self::GOVERNMENT => 'Cơ quan nhà nước',
            self::INDIVIDUAL => 'Cá nhân',
        };
    }
}
