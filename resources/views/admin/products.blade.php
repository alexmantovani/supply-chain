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

    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full w-full max-w-7xl mx-auto ">
            <div class="flex space-x-5">
                @include('admin.sidebar')

                <div class="flex-1 border-l-2 border-gray-200 p-5 border-dotted">

                    @if (session('alert'))
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{ session('alert') }}
                            </div>
                        </div>
                    @endif


                    <div class="flex justify-between items-center">
                        <div class=" text-gray-900 dark:text-gray-300 text-xl py-3 font-semibold">
                            Gestione prodotti
                        </div>
                        <div class="">
                            <form method="GET" action="{{ route('admin.products', $warehouse) }}">
                                <div class="flex rounded-md border border-gray-300 items-center bg-white">
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
                                <div class="text-xs text-gray-400 text-right pt-1">
                                    {{-- Trovati {{ $products->total() }} risultati --}}
                                </div>
                            </form>
                        </div>
                    </div>

                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 mt-2 md:p-4 dark:bg-gray-900 dark:border-gray-800">
                        <div class="p-1">
                            <form method="POST" action="{{ route('admin.print-labels') }}">
                                @csrf
                                <div class="flex justify-left pb-2">
                                    <x-primary-button
                                        title="Crea una pagina da stampare con i QR Code dei prodotti selezionati dalla lista qui sotto">
                                        {{-- Stampa selezionati --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>

                                    </x-primary-button>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="table-auto w-full">
                                        <thead
                                            class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Prodotto</div>
                                                </th>
                                                <th class="p-2 w-6 ">
                                                    <div class="font-semibold text-center">Quantità</div>
                                                </th>
                                                <th class="p-2 ">
                                                    <div class="font-semibold text-left">Fornitore</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="text-sm divide-y divide-gray-100 dark:divide-gray-800 items-center">
                                            @foreach ($products as $product)
                                                @livewire('product-update-row', ['product' => $product, 'providers' => $providers, 'warehouse' => $warehouse])
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="w-full max-w-7xl mx-auto pt-6">
                        <?php echo $products->appends(['search' => $search ?? ''])->links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
