<?php

use Filament\Schemas\Components\Concerns\HasChildComponents;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

enum UserStatus: string implements HasLabel, HasChildComponents
{
    case ACTIVE = '1';
    case INACTIVE = '3';
    case BANNED = '2';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Thấp',
            self::INACTIVE => 'Trung bình',
            self::BANNED => 'Cao',
        };
    }
    public function getIcon
}