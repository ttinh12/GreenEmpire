<?php
namespace App\Filament\Resources\Transactions\Pages;
use App\Filament\Resources\Transactions\TransactionResource;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}