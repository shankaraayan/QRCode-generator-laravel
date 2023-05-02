<?php

namespace App\Filament\Resources\WinnerListResource\Pages;

use App\Filament\Resources\WinnerListResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWinnerList extends EditRecord
{
    protected static string $resource = WinnerListResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
