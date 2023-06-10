<x-app-layout>
    <x-slot name="navbar_title">
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

    {{--
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-baseline">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $warehouse->name }}
                </h2>
                <div class="px-1 text-gray-500">
                  &nbsp; | &nbsp; {{ __('Storico ordini') }}
                </div>
            </div>
            <div class="dark:text-gray-400">
                <a href="{{ route('warehouse.order.index', $warehouse) }}" class="">
                    In lavorazione
                </a>
                &nbsp; | &nbsp;
                <a href="{{ route('warehouse.order.index', [$warehouse, 'all']) }}">
                    Tutti
                </a>
            </div>
        </div>
    </x-slot> --}}

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">

            <div class="w-full max-w-7xl mx-auto">
                <div class="flex justify-between items-baseline">
                    <div class=" text-gray-900 text-xl p-3 font-semibold">
                        Elenco ordini
                    </div>
                    <div class="font-semibold ">
                        <a href="{{ route('warehouse.order.index', $warehouse) }}"
                            class="py-1
                        @if (!Request()->has('all')) text-indigo-500 border-b border-indigo-400 @endif
                        ">

                            In corso
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('warehouse.order.index', [$warehouse, 'all']) }}"
                            class="py-1
                        @if (Request()->has('all')) text-indigo-500 border-b border-indigo-400 @endif
                        ">
                            Tutti

                        </a>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">

                    <div class="p-3">
                        <div class="">
                            <table class="table w-full">
                                <thead
                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left ">
                                                Ordine
                                            </div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Data</div>
                                        </th>
                                        <th class="p-2 w-40">
                                            <div class="font-semibold">Stato</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">
                                                Azioni
                                            </div>
                                        </th>
                                        <th class="p-2 w-10">
                                            <div class="font-semibold"></div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 ">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="p-2 whitespace-nowrap">
                                                <div class=" items-center">
                                                    <a href="{{ route('warehouse.order.show', [$warehouse, $order]) }}">
                                                        {{ $order->uuid }}
                                                    </a>

                                                    @foreach ($order->products as $product)
                                                        <div class=" text-gray-400 text-xs py-1 flex justify-between">
                                                            <div>
                                                                {{ $product->name }}
                                                            </div>
                                                            <div class="text-right">
                                                                {{ $product->pivot->quantity }}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </td>
                                            <td class="p-2">
                                                <div class="text-center dark:text-gray-300">
                                                    {{ $order->created_at->translatedFormat('d.m.Y') }}
                                                    &middot;
                                                    {{ $order->created_at->translatedFormat('H:i') }}
                                                </div>
                                            </td>
                                            <td class="p-2">
                                                <x-order-status
                                                    class="rounded-lg text-xs uppercase py-2 px-3 text-center"
                                                    :status="$order->status" />
                                            </td>
                                            <td class="px-3 py-3 w-8">
                                                @include('order.dropdown')
                                            </td>
                                            <td class="text-right px-3 py-3 w-10">
                                                <a href="{{ route('warehouse.order.show', [$warehouse, $order->id]) }}"
                                                    class="font-medium text-gray-800 text-lg hover:underline dark:text-gray-300">
                                                    <i class="fa-solid fa-angle-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-7xl mx-auto pt-6">
                <?php echo $orders->appends(['search' => $search ?? ''])->links(); ?>
            </div>
        </div>
    </section>

</x-app-layout>
