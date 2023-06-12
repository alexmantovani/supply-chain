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

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <div class="w-full max-w-7xl mx-auto flex">

                <div class="flex-1 ">
                    <div class="flex justify-between items-baseline">
                        <div class=" text-gray-900 text-xl p-3 font-semibold">
                            Ricerca materiale
                        </div>
                    </div>

                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">

                        <div class="mx-3">
                            <form method="GET" action="{{ route('warehouse.product.index', $warehouse) }}">
                                <div class="flex my-4 rounded-md border border-gray-300 items-center">
                                    <div class="w-full">
                                        <input
                                            class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                            type="text" aria-label="Search" placeholder="Cerca..."
                                            value="{{ $search ?? '' }}" name="search" autofocus>
                                    </div>

                                    <div class="p-1">
                                        <x-primary-button class="ml-1 h-12 w-12">
                                            <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($refills->count())

                        <div class="mt-5 flex justify-between items-baseline">
                            <div class=" text-gray-900 text-xl p-3 font-semibold">
                                Materiale in esaurimento pendente
                            </div>
                        </div>

                        <div
                            class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">
                            <table class="table-auto w-full mt-2">
                                <thead
                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Codice</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Prodotto</div>
                                        </th>
                                        <th class="p-2 w-20">
                                            <div class="font-semibold text-center">Default</div>
                                        </th>

                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                        </th>
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
                            default di materiale da ordinare. <br>Tutti i futuri ordini verranno inviati automaticamente
                            utilizzando la quantità che immetterai ora.
                        </div>
                    @endif

                </div>

                <div class="flex-0">
                    <div
                        class="ml-5 bg-white shadow-lg rounded-sm border border-gray-200 p-4 dark:bg-gray-900 dark:border-gray-800">
                        <div class="justify-center">
                            <div class="p-4">
                                <a href="{{ url('warehouse/' . $warehouse->id . '/refill/create') }}">
                                    {!! QrCode::size(150)->generate(url('warehouse/' . $warehouse->id . '/refill/create')) !!}
                                </a>
                            </div>
                            <div class="text-sm min-w-fit">
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
