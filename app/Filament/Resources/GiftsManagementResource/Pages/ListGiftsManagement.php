<?php

namespace App\Filament\Resources\GiftsManagementResource\Pages;

use App\Filament\Resources\GiftsManagementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGiftsManagement extends ListRecords
{
    protected static string $resource = GiftsManagementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
