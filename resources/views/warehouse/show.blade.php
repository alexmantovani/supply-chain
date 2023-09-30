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
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen dark:bg-gray-800">
        <div class="h-full ">



            <div class="container-wide text-white relative pb-3">
                <img class="object-cover" style="height: 400px" src="{{ url('images/bulloni.webp') }}">
                <div class="centered w-screen mx-auto md:px-36 text-center">

                    <form method="GET" action="{{ route('warehouse.product.index', $warehouse) }}">
                        <div
                            class="flex py-3 m-3 p-3 text-stone-900 dark:text-stone-100 bg-white dark:bg-stone-800 shadow-sm md:rounded-lg">
                            <input
                                class="mr-3 border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0 dark:bg-stone-600 dark:text-stone-50"
                                type="text" aria-label="Search" placeholder="Cerca..." name="search" autofocus>

                            {{-- <a href="" class="py-4 px-5 bg-orange-600 text-white rounded-md text-center">
                                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                                </a> --}}
                            <x-primary-button class="mx-0">
                                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>









            <div class="w-full max-w-7xl mx-auto md:flex">

                <div class="flex-1 ">
                    @if ($refills->count())
                        <div class="mt-5 flex justify-between items-baseline">
                            <div class=" text-gray-900 text-xl p-3 font-semibold">
                                Materiale in esaurimento da verificare
                            </div>
                        </div>

                        <div
                            class="bg-white shadow-lg rounded-sm border border-gray-200 px-1 md:px-8 dark:bg-gray-900 dark:border-gray-800">
                            <table class="table-auto w-full mt-2">
                                <thead
                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Codice</div>
                                        </th>
                                        <th class="p-2 ">
                                            <div class="font-semibold text-left">Prodotto</div>
                                        </th>
                                        <th class="p-2 w-20">
                                            <div class="font-semibold text-center">Default</div>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($refills as $refill)
                                        @livewire('refill-quantity', ['warehouse' => $warehouse, 'refill' => $refill])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-sm text-center text-gray-500 py-2 px-3">
                            I prodotti qui sopra al momento non possono essere ordinati perchè manca la quantità di
                            default da ordinare. <br>Tutti gli ordini futuri verranno inviati automaticamente
                            utilizzando la quantità che immetterai ora.
                        </div>
                    @endif

                    @if ($orders->count())
                        <div class="mt-5 flex justify-between items-baseline">
                            <div class=" text-gray-900 text-xl p-3 font-semibold">
                                Ordini in ritardo
                            </div>
                        </div>

                        <div
                            class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">
                            <table class="table-auto w-full mt-2">
                                <thead
                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Data</div>
                                        </th>
                                        <th class="p-2 ">
                                            <div class="font-semibold text-left">Ordine</div>
                                        </th>
                                        <th class="p-2 w-36">
                                            <div class="font-semibold text-center">Stato</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                {{ $order->created_at->translatedFormat('d.m.Y') }}
                                                ({{ $order->created_at->diffForHumans() }})
                                            </td>
                                            <td>
                                                <x-product-name-cell class="" :href="route('warehouse.order.show', [$warehouse, $order])">
                                                    {{ $order->uuid }}
                                                </x-product-name-cell>

                                                {{-- <a href="{{ route('warehouse.order.show', [$warehouse, $order]) }}">
                                                    <div class="font-semibold text-gray-800 pl-1">
                                                        {{ $order->uuid }}
                                                    </div>
                                                </a> --}}
                                            </td>
                                            <td class="p-2 w-36">
                                                <x-order-status
                                                    class="rounded-lg text-xs uppercase font-semibold py-2 px-3 text-center"
                                                    :status="$order->status" />
                                            </td>
                                            <td class="p-2 w-2">
                                                @include('order.dropdown')
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif

                </div>

                <div class="md:flex-0">
                    <div
                        class="mt-5 md:mt-0 md:ml-5 bg-white shadow-lg rounded-sm border border-gray-200 p-3 dark:bg-gray-900 dark:border-gray-800">
                        <div class="text-center p-3">
                            <div class="p-3 flex justify-center bg-white">
                                <a href="{{ url('warehouse/' . $warehouse->id . '/refill/create') }}">
                                    {!! QrCode::size(150)->generate(url('warehouse/' . $warehouse->id . '/refill/create')) !!}
                                </a>
                            </div>
                            <div class="text-sm min-w-fit pt-2">
                                Inquadra col tuo smartphone <br> il QRCode qui sopra per poter <br> aggiungere nuove
                                richieste di <br> materiale.
                            </div>
                            <div class="pt-3 text-center">
                                <x-primary-button class="ml-1" title="Stampa il QR Code del magazzino">
                                    <i class="fa-regular fa-print"></i>
                                    &nbsp; Stampa
                                </x-primary-button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
