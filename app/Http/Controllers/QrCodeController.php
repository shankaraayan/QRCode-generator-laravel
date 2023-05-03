<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->id;

        $qrCode = $request->qr_code;
        validate()->make([
            'qr_code' => 'string|exists:qr_codes,uuid',
        ]);


        $result = QrCode::where('uuid', $qrCode)->update([
            'user_id' => $user,
            'used' => 1,
        ]);

        return success('Point Successfully Claimed.')->response();
    }
}
