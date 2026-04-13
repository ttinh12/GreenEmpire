<?php

namespace App\Enums;

enum CustomerStatus: int
{
    case ACTIVE = 1;
    case POTENTIAL = 2;
    case INACTIVE = 3;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Đang hoạt động',
            self::POTENTIAL => 'Tiềm năng',
            self::INACTIVE => 'Ngưng hoạt động',
        };
    }
}

