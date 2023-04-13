<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'to',
        'otp'
    ];
}
