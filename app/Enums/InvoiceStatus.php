<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum InvoiceStatus: int implements HasLabel, HasColor
{
    case PAID = 1;
    case PENDING = 2;
    case UNPAID = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::PAID => 'Đã thanh toán',
            self::PENDING => 'Chờ thanh toán',
            self::UNPAID => 'Chưa thanh toán',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PAID => 'success',
            self::PENDING => 'warning',
            self::UNPAID => 'danger',
        };
    }
}
