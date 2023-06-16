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
                                {{ $order->uuid }}
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

                    <table class="table-auto w-full mb-5">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-left">Codice</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left px-3">Prodotto</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Quantità</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="p-2 w-32">
                                        <x-product-uuid-cell>
                                            {{ $product->uuid }}
                                        </x-product-uuid-cell>
                                    </td>
                                    <td class="p-2 ">
                                        <x-product-name-cell :href="route('warehouse.product.show', [
                                            $warehouse,
                                            $product,
                                        ])">
                                            {{ $product->name }}
                                        </x-product-name-cell>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center dark:text-gray-300 text-sm md:text-base">
                                            {{ $product->pivot->quantity }}
                                            @php
                                                $total += $product->pivot->quantity;
                                            @endphp
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="  text-gray-700 dark:text-gray-300">
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-md">
                                        Totale
                                    </div>
                                </td>
                                <td></td>
                                <td class=" whitespace-nowrap ">
                                    <div class="text-center text-sm md:text-base">
                                        {{ $total }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full max-w-7xl mx-auto pt-5">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700 py-5">
                    <div class=" m-5">
                        <div class="font-semibold text-2xl pt-4">
                            Log
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
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Descrizione</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-right">Utente</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($order->logs as $log)
                                <tr>
                                    <td class="p-2 whitespace-nowrap text-gray-400 dark:text-gray-300 text-xs ">
                                        <div>
                                            {{ $log->created_at->translatedFormat('d.m.Y') }}
                                        </div>
                                    </td>
                                    <td
                                        class="p-2 whitespace-nowrap text-center text-gray-400 dark:text-gray-300 text-xs">
                                        <div>
                                            {{ $log->created_at->translatedFormat('H:i') }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-gray-500 dark:text-gray-300">
                                        <div>
                                            {{ $log->description }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-gray-500 dark:text-gray-300 text-right">
                                        <div>
                                            {{ $log->user->name ?? '' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</x-app-layout>
