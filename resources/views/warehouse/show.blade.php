<x-app-layout>
    <x-slot name="navbar_title">
        <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
            {{ $warehouse->name }}
        </x-navbar-title>
    </x-slot>
    <x-slot name="navbar_left_menu">
        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            @include('layouts.nav_left_bar')
        </div>
    </x-slot>
    <x-slot name="navbar_right_menu">
        <x-nav-link :href="route('warehouse.refill.simulate', $warehouse->id)" :active="request()->routeIs('warehouse.refill.simulate')">
            {{ __('Simula QR') }}
        </x-nav-link>
    </x-slot>


    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="p-8">
                    <form method="GET" action="{{ route('warehouse.product.index', $warehouse) }}">
                        <div class="flex mt-4 rounded-md border border-gray-300 items-center">
                            <div class="w-full">
                                <input
                                    class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                    type="text" aria-label="Search" placeholder="Cerca..."
                                    value="{{ $search ?? '' }}" name="search" autofocus>
                            </div>

                            <div class="p-1">
                                <x-primary-button class="ml-3 h-12 w-12">
                                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                                </x-primary-button>
                            </div>
                        </div>
                        {{-- <div class="text-xs text-gray-400 text-right pt-1">
                            Trovati {{ $products->total() }} risultati
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
