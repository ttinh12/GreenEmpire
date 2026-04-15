<?php
namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Icons\Heroicon;

enum TicketStatus: string implements HasLabel, HasIcon, HasColor
{
    case ACTIVE = '1';
    case INACTIVE = '2';
    case BANNED = '3';
    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Chờ xử lý',
            self::INACTIVE => 'Đang xử lý',
            self::BANNED => 'Đã hoàn thành',
        };
    }
    public function getIcon(): string | BackedEnum
    {
        return match ($this) {
            self::ACTIVE => Heroicon::CheckCircle,
            self::INACTIVE => Heroicon::CheckCircle,
            self::BANNED => Heroicon::CheckCircle,
        };
    }
    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'warning',
            self::INACTIVE => 'secondary',
            self::BANNED => 'success',
        };
    }
}