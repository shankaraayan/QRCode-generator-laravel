<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftsManagementResource\Pages;
use App\Filament\Resources\GiftsManagementResource\RelationManagers;
use App\Models\GiftsManagement;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GiftsManagementResource extends Resource
{
    protected static ?string $model = GiftsManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('point')->label('Points'),
                TextInput::make('reward')->label('Reward'),
                FileUpload::make('img')->label('Image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('img'),
                TextColumn::make('point'),
                TextColumn::make('reward'),
                ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGiftsManagement::route('/'),
            'create' => Pages\CreateGiftsManagement::route('/create'),
            'edit' => Pages\EditGiftsManagement::route('/{record}/edit'),
        ];
    }
}
