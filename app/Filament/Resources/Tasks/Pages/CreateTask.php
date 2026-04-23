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
        // 🟢 LUÔN có start
        if (empty($data['started_at'])) {
            $data['started_at'] = now(); // fallback thôi
        }

        // 🔴 Nếu tạo DONE → phải có completed_at
        if (($data['status'] ?? null) == Task::STATUS_DONE) {
            $data['completed_at'] = $data['completed_at'] ?? now();
        }

        // 📊 sort cuối list
        $data['sort'] = (Task::max('sort') ?? 0) + 1;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
