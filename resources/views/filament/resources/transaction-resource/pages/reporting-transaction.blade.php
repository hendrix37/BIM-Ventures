<x-filament-panels::page>
    <x-filament-panels::form wire:submit="export">
        {{ $this->form }}
        <x-filament::button
        type="submit"
        size="sm"
    >
        Export Report
    </x-filament::button>
    </x-filament-panels::form>
</x-filament-panels::page>
