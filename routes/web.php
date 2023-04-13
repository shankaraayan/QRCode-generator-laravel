<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->middleware('guest')->name('password.update');
