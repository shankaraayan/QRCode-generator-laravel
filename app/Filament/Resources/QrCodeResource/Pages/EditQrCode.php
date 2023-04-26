<?php

namespace App\Filament\Resources\QrCodeResource\Pages;

use App\Filament\Resources\QrCodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQrCode extends EditRecord
{
    protected static string $resource = QrCodeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }
}
