<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case CASH = 1;
    case BANK = 2;
    case TRANSFER = 3;

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Tiền mặt',
            self::BANK => 'Chuyển khoản',
            self::TRANSFER => 'Chuyển khoản ngân hàng',
        };
    }
}
