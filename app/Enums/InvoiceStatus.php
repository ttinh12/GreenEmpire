<?php

namespace App\Enums;

enum InvoiceStatus: int
{
    case PAID = 1;
    case PENDING = 2;
    case UNPAID = 3;

    public function label(): string
    {
        return match ($this) {
            self::PAID => 'Đã thanh toán',
            self::PENDING => 'Chờ thanh toán',
            self::UNPAID => 'Chưa thanh toán',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PAID => 'success',
            self::PENDING => 'warning',
            self::UNPAID => 'danger',
        };
    }
}
