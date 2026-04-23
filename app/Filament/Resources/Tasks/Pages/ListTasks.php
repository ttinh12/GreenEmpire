<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Actions\Action;        // ← Thêm dòng này
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;
class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_overdue_email')
                ->label('Gui Email Canh Bao')
                ->icon('heroicon-o-envelope')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Gui email canh bao task qua han?')
                ->action(function () {
                    Artisan::call('tasks:send-overdue-email');
                    \Filament\Notifications\Notification::make()
                        ->title('Da gui email canh bao!')
                        ->success()
                        ->send();
                }),

            CreateAction::make()
                ->label('Them cong viec moi'),
        ];
    }
}