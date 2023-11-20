@if ($getState())
    <x-filament::button color="info"
        href="{{ route('filament.admin.resources.transactions.view', ['record' => $getState()]) }}" tag="a">
        Detail Transaction
    </x-filament::button>
@else
    -
@endif
