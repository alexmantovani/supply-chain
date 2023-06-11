<x-app-layout>
    <x-slot name="navbar_title">
        <div
            class="
                sm:-my-px sm:ml-10 sm:flex font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight items-center
                cursor-pointer">
            <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
        </div>
        <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
            {{ $warehouse->name }}
        </x-navbar-title>
    </x-slot>
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar')
    </x-slot>
    <x-slot name="navbar_right_menu">
        {{-- <x-nav-link :href="route('warehouse.refill.simulate', $warehouse->id)" :active="request()->routeIs('warehouse.refill.simulate')">
            {{ __('Simula QR') }}
        </x-nav-link> --}}
    </x-slot>

    <section class="antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="flex justify-center pt-40 text-4xl">
            La tua richiesta è stata rifiutata
        </div>

        @if (session('message'))
            <div class="flex justify-center text-xl text-gray-400 uppercase py-2">
                {{ session('message') }}
            </div>
        @endif

        <div class="text-center text-gray-500 pt-40">
            Grazie per la collaborazione
        </div>
    </section>

</x-app-layout>
