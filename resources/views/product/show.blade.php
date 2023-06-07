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
        <x-nav-link :href="route('warehouse.refill.simulate', $warehouse->id)" :active="request()->routeIs('warehouse.refill.simulate')">
            {{ __('Simula QR') }}
        </x-nav-link>
    </x-slot>


    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">

        <div class="w-full max-w-7xl mx-auto ">
            <div
                class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 py-8 dark:bg-gray-900 dark:border-gray-700">
                <div class="mx-5">
                    <div class="font-semibold text-2xl dark:text-gray-200">
                        {{ $product->name }}
                    </div>
                    @if ($product->description)
                        <div class="text-lg text-gray-500 dark:text-gray-200">
                            {{ $product->description }}
                        </div>
                    @endif

                    <div class="text-lg text-gray-500 dark:text-gray-200">
                        Codice: {{ $product->uuid }}
                    </div>

                    @if ($product->note)
                        <div class="text-lg text-gray-500 dark:text-gray-200 pt-3">
                            Note: {{ $product->note }}
                        </div>
                    @endif

                </div>

            </div>

            <div class="grid grid-cols-2 gap-4 h-full">
                <div class="flex justify-between items-baseline pt-3 px-5">
                    <div class=" text-gray-900 text-xl p-3 font-semibold">
                        Produttore
                    </div>
                </div>

                <div class="flex justify-between items-baseline pt-3 px-5">
                    <div class=" text-gray-900 text-xl p-3 font-semibold">
                        Fornitore
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 h-full mb-5">
                <div
                    class="bg-white  shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700">

                    <div class="m-5">
                        <div class="pb-6">
                            <div class="font-semibold text-xl pt-4 dark:text-gray-200">
                                {{ $product->dealer->name }}
                            </div>
                            <div class="mt-1 dark:text-gray-400 text-sm text-gray-500">
                                {{ $product->dealer->address }}
                                <p>
                                    {{ $product->dealer->city }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>


                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700">
                    <div class="m-5">
                        <div class="pb-6">

                            <div class="font-semibold text-xl pt-4 dark:text-gray-200">
                                {{ $product->dealer->provider->name }}
                            </div>
                            <div class="mt-1 dark:text-gray-400 text-sm text-gray-500">
                                <a href="mailto:{{ $product->dealer->provider->email }}">
                                    <i class="fa-regular fa-envelope"></i>
                                    <span>
                                        {{ $product->dealer->provider->email }}
                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="flex">


                <div
                    class="flex-1 mr-4 bg-white shadow-lg rounded-sm border border-gray-200 px-8 py-8 dark:bg-gray-900 dark:border-gray-700">
                    <div class="pb-6 mx-5">
                        <div class="font-semibold text-2xl dark:text-gray-200">
                            Ordini
                        </div>
                    </div>

                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Data</div>
                                </th>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Ora</div>
                                </th>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">identificativo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Magazzino</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-right">Stato</div>
                                </th>
                            </tr>
                        </thead>
                        @foreach ($product->orders as $order)
                            <tr>
                                <td class="p-2 whitespace-nowrap text-gray-400 dark:text-gray-300 text-xs ">
                                    <div>
                                        {{ $order->created_at->translatedFormat('d.m.Y') }}
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-center text-gray-400 dark:text-gray-300 text-xs">
                                    <div>
                                        {{ $order->created_at->translatedFormat('H:i') }}
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-xs text-gray-500 dark:text-gray-300">
                                    <div>
                                        <a href="{{ route('warehouse.order.show', [$order->warehouse, $order]) }}">
                                            {{ $order->uuid }}
                                        </a>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-xs text-gray-500 dark:text-gray-300">
                                    <div>
                                        {{ $order->warehouse->name }}
                                    </div>
                                </td>
                                <td class="p-2 text-xs text-gray-500 dark:text-gray-300 text-right">
                                    <div class="flex justify-end">
                                        <x-order-status class="rounded-lg text-xs uppercase py-2 px-3 text-center"
                                            :status="$order->status" />
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>


                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 py-8 dark:bg-gray-900 dark:border-gray-700 max-h-min">
                    <div class="pb-6 mx-5">
                        <div class="font-semibold text-2xl dark:text-gray-200">
                            Ordina al volo
                        </div>
                    </div>

                    <form method="GET" action="{{ route('warehouse.refill.ask', $warehouse ) }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="pb-3">
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" class="block mt-1 w-full text-right" type="text" name="quantity"
                                :value="old('quantity')" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <x-primary-button class="w-full justify-center">
                            {{ __('Ordina') }}
                        </x-primary-button>
                    </form>
                </div>

            </div>


            <div class="pt-4 flex justify-between">
                <x-primary-button class="mx-4">
                    {{ __('Elimina da listino') }}
                </x-primary-button>

            </div>
        </div>
    </section>

</x-app-layout>
