<?php

namespace App\Filament\Resources\LeadershipBoardResource\Pages;

use App\Filament\Resources\LeadershipBoardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeadershipBoards extends ListRecords
{
    protected static string $resource = LeadershipBoardResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
