<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum TicketPriority: string implements HasLabel, HasIcon, HasColor
{
    case ACTIVE = '1';
    case INACTIVE = '2';
    case BANED = '3';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'hoat dong',
            self::INACTIVE => 'khong hoat dong',
            self::BANED => 'bi ban',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-o-check-circle',
            self::INACTIVE => 'heroicon-o-x-circle',
            self::BANED => 'heroicon-o-ban',
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
