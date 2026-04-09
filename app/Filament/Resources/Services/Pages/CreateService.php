<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Models\Service;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['slug']) && ! empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (empty($data['created_by'])) {
            $data['created_by'] = auth()->id();
        }

        if (empty($data['status'])) {
            $data['status'] = Service::STATUS_ACTIVE;
        }

        if (empty($data['created_at'])) {
            $data['created_at'] = now();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
