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

                                <div class="overflow-x-auto">
                                    <table class="table-auto w-full">
                                        <thead
                                            class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Produttore</div>
                                                </th>
                                                <th class="p-2 ">
                                                    <div class="font-semibold text-left">Materiale fornito da</div>
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
                                <div class="flex justify-left py-2">
                                    <x-primary-button
                                        title="Crea una pagina da stampare con i QR Code dei prodotti selezionati">
                                        Stampa selezionati
                                    </x-primary-button>
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
