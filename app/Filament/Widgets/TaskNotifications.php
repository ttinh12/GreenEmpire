<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TaskNotifications extends Widget
{
    protected  string $view = 'filament.widgets.task-notifications';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        return [
            'notifications' => auth()->user()
                ? auth()->user()->unreadNotifications()->latest()->limit(10)->get()
                : collect(),
        ];
    }
}