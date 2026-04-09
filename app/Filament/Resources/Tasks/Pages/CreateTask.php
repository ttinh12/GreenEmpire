<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        // Auto set started_at nếu tạo thẳng In Progress
        if (($data['status'] ?? null) == Task::STATUS_IN_PROGRESS && empty($data['started_at'])) {
            $data['started_at'] = now();
        }

        // Auto set completed_at nếu tạo thẳng Done
        if (($data['status'] ?? null) == Task::STATUS_DONE && empty($data['completed_at'])) {
            $data['completed_at'] = now();
        }

        // Auto tính sort (đẩy xuống cuối)
        $data['sort'] = (Task::max('sort') ?? 0) + 1;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}