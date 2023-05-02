<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrCodeResource\Pages;
use App\Models\QrCode;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Intervention\Image\ImageManagerStatic as Image;

class QrCodeResource extends Resource
{
    protected static ?string $model = QrCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('points'),
                TextInput::make('uuid')->label('Code')->disabled(),
                FileUpload::make('qrCode')->disabled()->enableDownload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('qrCode'),
                TextColumn::make('points'),
                BadgeColumn::make('used')
                    ->label("Used or Not")
                    ->enum([
                        '0' => 'Not Used',
                        '1' => 'Expired',
                    ]),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')->label('Download QR Code')->icon('heroicon-o-qrcode')
                    ->action(function ($record) {
                        $imagePath = public_path('/storage/' . $record->qrCode);
                        $filename = basename($imagePath);
                        //Extra

                        $image = Image::make($imagePath);
                        $image->text("Montac Plywood QR Code.", 10, 10, function ($font) {
                            $font->file(public_path('/font/ArialCE.ttf'));
                            $font->size(18);
                            $font->color('#000000');
                            $font->align('left');
                            $font->valign('top');
                        });

                        $headers = [
                            'Content-Type' => 'image/png',
                            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                        ];
                        return response()->stream(function () use ($image) {
                            echo $image->encode('png');
                        }, 200, $headers);
                    }),


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
            'index' => Pages\ListQrCodes::route('/'),
            'create' => Pages\CreateQrCode::route('/create'),
            'edit' => Pages\EditQrCode::route('/{record}/edit'),
        ];
    }
}
