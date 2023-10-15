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

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-1 md:p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div
                class="md:bg-white md:shadow-lg rounded-sm md:border border-gray-200 md:px-8 dark:bg-gray-900 dark:md:bg-gray-900 dark:border-gray-700">

                    <div class="flex justify-between my-2 md:my-4">
                        <div class="pb-6">
                            <div class="text-xl md:text-2xl font-light pt-4 text-gray-400 dark:text-gray-300">
                                Ordine
                                <span class="font-semibold text-gray-700 dark:text-gray-100">
                                    {{ $order->uuid }}
                                </span>
                            </div>
                            <div class="text-sm md:text-base text-gray-400">
                                effettuato il
                                <span class="text-gray-600 dark:text-gray-200 font-semibold">
                                    {{ $order->created_at->translatedFormat('d M Y') }}
                                </span>
                                alle
                                <span class="text-gray-600 dark:text-gray-200 font-semibold">
                                    {{ $order->created_at->translatedFormat('H.i') }}
                                </span>
                            </div>
                        </div>

                        <div class="my-4 flex items-top align-top">
                            <div class="md:w-40 mt-1">
                                <x-order-status-gradient
                                    class="text-xs font-semibold uppercase py-1 border-r-4 text-gray-700 text-right px-2"
                                    :status="$order->status" />
                            </div>
                            <div class="text-center align-top h-4 m-1">
                                @include('order.dropdown')
                            </div>

                        </div>
                    </div>

                    <table class="table-auto w-full mb-5">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-left">Codice</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Articolo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Produttore</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-right">Quantità</div>
                                </th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @php
                                $total = 0;
                                $total_received = 0;
                            @endphp
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="p-2 w-32">
                                        <x-product-uuid-cell>
                                            {{ $product->uuid }}
                                        </x-product-uuid-cell>
                                    </td>
                                    <td class="p-2 ">
                                        <x-product-name-cell :href="route('warehouse.product.show', [$warehouse, $product])">
                                            {{ $product->name }}
                                        </x-product-name-cell>
                                    </td>
                                    <td class="p-2  hidden md:table-cell">
                                        <x-product-name-cell :href="route('warehouse.dealer.show', [$warehouse, $product->dealer])">
                                            {{ $product->dealer->name }}
                                        </x-product-name-cell>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-right dark:text-gray-300 text-sm md:text-base">
                                            {{ $product->pivot->quantity }}
                                            @php
                                                $total += $product->pivot->quantity;
                                            @endphp
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center dark:text-gray-300 text-sm md:text-base">
                                            <x-product-arrived :arrived="$product->isArrived()" :status="$order->status" class="text-xs" />
                                            @php
                                                $total_received += $product->pivot->received_quantity;
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
                                <td>
                                </td>
                                <td class=" hidden md:table-cell">
                                </td>
                                <td class=" p-2 ">
                                    <div class="text-right text-sm md:text-base">
                                        {{ $total }}
                                    </div>
                                </td>
                                <td class="p-2 ">
                                    <div class="text-center text-xs text-gray-400">
                                        {{ round((100 * $total_received) / $total, 1) }}%
                                    </div>
                                    {{--
                                    <div class="text-center text-sm md:text-base">
                                        {{ $total_received }}
                                    </div> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full max-w-7xl mx-auto md:pt-5">
                <div
                    class="md:bg-white md:shadow-lg md:rounded-sm md:border border-gray-200 px-1 md:px-8 dark:bg-gray-900 dark:md:bg-gray-900 dark:border-gray-700 py-5">
                    <div class="mb-5 md:m-5">
                        <div class="font-semibold text-2xl">
                            Log
                        </div>
                    </div>

                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Data</div>
                                </th>
                                <th class="p-2 whitespace-nowrap w-20 ">
                                    <div class="font-semibold text-center">Ora</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Descrizione</div>
                                </th>
                                <th class="p-2 whitespace-nowrap hidden md:table-cell">
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
                                    <td class="p-2 text-gray-500 dark:text-gray-300">
                                        <div>
                                            {{ $log->description }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-gray-500 dark:text-gray-300 text-right hidden md:table-cell">
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
