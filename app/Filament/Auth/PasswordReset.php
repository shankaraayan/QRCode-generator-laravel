<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PasswordReset extends Component implements HasForms
{
    use InteractsWithForms;

    public $email = '';
    public $password = '';
    public $token = '';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();

        if (session('status')) {
            Filament::notify('success', session('status'), true);
        }

        if (session('errors')) {
            foreach (session('errors')->all() as $error) {
                Filament::notify('danger', $error, true);
            }
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email_label')
                ->label('Email address')
                ->afterStateHydrated(fn ($component) => $component->state(request()->get('email')))
                ->disabled(),
            TextInput::make('password')
                ->extraInputAttributes(['name' => 'password'])
                ->label('Password')
                ->password()
                ->required()
                ->rules(['confirmed'])
                ->autocomplete('new-password'),
            TextInput::make('password_confirmation')->label('Confirm password')
                ->extraInputAttributes(['name' => 'password_confirmation'])
                ->password()
                ->autocomplete('new-password')
                ->required(),
            Hidden::make('email')
                ->extraAttributes(['name' => 'email'])
                ->afterStateHydrated(fn ($component) => $component->state(request()->get('email'))),
            Hidden::make('token')
                ->extraAttributes(['name' => 'token'])
                ->afterStateHydrated(fn ($component) => $component->state(request()->route('token'))),
        ];
    }

    public function render(): View
    {
        return view('filament.auth.password-reset')
            ->layout('filament::components.layouts.card', [
                'title' => 'Reset password',
            ]);
    }
}
