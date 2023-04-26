<?php

namespace App\Filament\Resources\GiftsManagementResource\Pages;

use App\Filament\Resources\GiftsManagementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGiftsManagement extends EditRecord
{
    protected static string $resource = GiftsManagementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
