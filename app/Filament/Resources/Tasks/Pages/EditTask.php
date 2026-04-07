<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $task = $this->getRecord();

        // Auto track time khi chuyển sang In Progress
        if (($data['status'] ?? null) == Task::STATUS_IN_PROGRESS && !$task->started_at) {
            $data['started_at'] = now();
        }

        // Auto track time khi chuyển sang Done
        if (($data['status'] ?? null) == Task::STATUS_DONE && !$task->completed_at) {
            $data['completed_at'] = now();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}