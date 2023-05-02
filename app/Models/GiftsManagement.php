<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftsManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'point',
        'reward',
        'img',
        'status',
    ];
}
