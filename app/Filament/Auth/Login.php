<?php

namespace App\Filament\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Http\Livewire\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;

/**
 * @property ComponentContainer $form
 */
class Login extends BaseLogin
{
    public function render(): View
    {
        return view('filament.auth.login')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament::login.title'),
            ]);
    }
}
