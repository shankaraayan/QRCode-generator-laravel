<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'points',
        'single_use',
        'uuid',
        'qrCode',
        'used',
        'used_count',
    ];
}
