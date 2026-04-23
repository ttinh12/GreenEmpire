<?php

use Filament\Schemas\Components\Concerns\HasChildComponents;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

enum UserStatus: string implements HasLabel
{
    case ACTIVE = '1';
    case INACTIVE = '2';
    case BANNED = '3';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Hoạt động',
            self::INACTIVE => 'Không hoạt động',
            self::BANNED => 'Bị khóa',
        };
    }
}