<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between p-6 text-gray-900 dark:text-gray-100">
                    {{-- <x-nav-link :href="route('stock.index')" :active="request()->routeIs('stock.index')">
                        {{ __('Magazzino') }}
                    </x-nav-link> --}}
                    {{-- <x-nav-link :href="route('refill.index')" :active="request()->routeIs('refill.index')">
                        {{ __('In esaurimento') }}
                    </x-nav-link>
                    <x-nav-link :href="route('order.index')" :active="request()->routeIs('order.index')">
                        {{ __('Ordini') }}
                    </x-nav-link> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
