<x-app-layout>

    <x-slot name="navbar_right_menu">
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    @livewire('refill-index', ['warehouse' => $warehouse, 'refills' => $refills])
</x-app-layout>
