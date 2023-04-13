<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <x-tables::link href="{{ route('password.request') }}">Forgot password?</x-table::link>
    </div>

    <x-filament::notification-manager />
</form>
