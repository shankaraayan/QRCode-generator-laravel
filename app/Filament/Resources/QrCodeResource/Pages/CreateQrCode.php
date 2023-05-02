<?php

namespace App\Filament\Resources\QrCodeResource\Pages;

use App\Filament\Resources\QrCodeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CreateQrCode extends CreateRecord
{
    protected static string $resource = QrCodeResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $uuid = $data['uuid'] = uniqid(rand(0000, 9999));
        $qr = "https://chart.googleapis.com/chart?cht=qr&chs=500x500&chl=$uuid&choe=UTF-8";

        $client = new Client();
        $response = $client->get($qr);

        $image_data = $response->getBody();
        $qrCodePath = 'public/qrcodes/' . $uuid . '.png';
        Storage::disk('local')->put($qrCodePath, $image_data);

        $qrCodeUrl = Storage::url($qrCodePath);
        $qrCodeUrl = str_replace('/storage/', '', $qrCodeUrl);
        $data['qrCode'] = $qrCodeUrl;

        return ($data);
    }
}
