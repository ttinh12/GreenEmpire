<?php
namespace App\Enums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;


enum TicketPriority: string implements HasLabel, HasColor
{
    case LOW = '1';
    case MEDIUM = '2';
    case HIGH = '3';
    public function getLabel(): string
    {
        return match ($this) {
            self::LOW => 'Thấp',
            self::MEDIUM => 'Bình thường',
            self::HIGH => 'Cao',
        };
    }
    public function getColor(): string
    {
        return match ($this) {
            self::LOW => 'primary',
            self::MEDIUM => 'secondary',
            self::HIGH => 'success',
        };
    }
}