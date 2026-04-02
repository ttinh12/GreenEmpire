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
            self::ACTIVE => 'Hoạt động',
            self::INACTIVE => 'Không hoạt động',
            self::BANNED => 'Bị cấm',
        };
    }
    public function getIcon(): string | BackedEnum
    {
        return match ($this) {
            self::ACTIVE => Heroicon::CheckCircle,
            self::INACTIVE => Heroicon::XCircle,
            self::BANNED => Heroicon::XCircle,
        };
    }
    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'secondary',
            self::BANNED => 'danger',
        };
    }
}