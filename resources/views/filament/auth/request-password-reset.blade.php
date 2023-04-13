<form method="POST" action="{{ route('password.email') }}" class="space-y-8">
    @csrf
    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">Submit</x-filament::button>
    <x-filament::button color="secondary" class="w-full" type="button" tag="a" href="{{ route('login') }}">Cancel</x-filament::button>

    <x-filament::notification-manager />
</form>
