<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div>
                <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
                    {{ $warehouse->name }}
                </x-navbar-title>
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar', ['warehouse' => $warehouse])
    </x-slot>
    <x-slot name="navbar_right_menu">
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="">
                <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
            </x-secondary-button>
        </a>
    </x-slot>

    @livewire('refill-index', ['warehouse' => $warehouse, 'refills' => $refills])
</x-app-layout>
