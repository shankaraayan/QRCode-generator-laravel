<form method="POST" action="{{ route('password.update') }}" class="space-y-8">
    @csrf
    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">Update password</x-filament::button>

    <x-filament::notification-manager />
</form>
