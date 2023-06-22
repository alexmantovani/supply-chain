<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex ml-5 items-center space-x-5">
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
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="">
                <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
            </x-secondary-button>
        </a>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 md:px-8 dark:bg-gray-900 dark:border-gray-700">

                    <div class="flex justify-between m-5">
                        <div class="pb-6">
                            <div class="font-semibold text-2xl pt-4 dark:text-gray-200">
                                Ordine:
                                <a href="{{ route('warehouse.order.show', [$warehouse, $order]) }}">{{ $order->uuid }}</a>

                            </div>
                            <div class="text-lg text-gray-400 dark:text-gray-200">
                                effettuato il
                                {{ $order->created_at->translatedFormat('d.m.Y') }}
                                alle
                                {{ $order->created_at->translatedFormat('H.i') }}

                            </div>
                        </div>

                        <div class="my-4 flex items-center">
                            <div class="px-3">
                                <x-order-status class="rounded-lg text-sm uppercase py-2 px-3 text-center"
                                    :status="$order->status" />
                            </div>
                            @include('order.dropdown')
                        </div>
                    </div>

                    @livewire('order-partial', ['warehouse' => $warehouse, 'order' => $order])

                </div>
            </div>

        </div>
    </section>

</x-app-layout>
