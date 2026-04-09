<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Icons\Heroicon;

enum TicketPriority: string implements HasLabel, HasIcon, HasColor
{
    case ACTIVE = '1';
    case INACTIVE = '2';
    case BANED = '3';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Thấp',
            self::INACTIVE => 'Trung bình',
            self::BANED => 'Cao',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-o-check-circle',
            self::INACTIVE => 'heroicon-o-x-circle',
            self::BANED => 'heroicon-o-no-symbol',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
            self::BANED => 'danger',
        };
    }
}
