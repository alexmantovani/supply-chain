<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div
                class="
              font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
            cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
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
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="py-20">
            <div class="text-center text-4xl text-green-500 font-medium py-10" style="font-size: 90px">
                <i class="fa-regular fa-check"></i>
            </div>

            @if (isset($product))
                <div class=" text-center text-lg py-4 text-gray-400">
                    <div class=" font-semibold">
                        {{ $product->uuid ?? '???' }}
                    </div>
                    <div class=" text-base">
                        {{ $product->name ?? '???' }}
                    </div>
                </div>
            @endif

            <div class="text-center text-4xl pt-10">
                La tua richiesta è stata inserita
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('warehouse.refill.create', $warehouse) }}"
                class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <i class="fa-solid fa-plus" title="Aggiungi tra i materiali in esaurimento"></i>&nbsp;
                {{ __('Segnala altro matriale') }}
            </a>
        </div>

    </section>

</x-app-layout>
