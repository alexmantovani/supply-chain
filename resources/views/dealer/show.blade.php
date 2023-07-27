<x-app-layout>
    <x-slot name="navbar_right_menu">
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 md:px-8 dark:bg-gray-900 dark:border-gray-700">

                    <div class="flex justify-between m-5 items-center">
                        <div class="pb-6 grid md:grid-cols-2 w-full">
                            <div class="font-semibold text-xl md:text-2xl pt-4 dark:text-gray-200">
                                {{ $dealer->name }}
                            </div>
                            <div class="mt-4 text-gray-400 dark:text-gray-300">
                                {{ $dealer->address }}
                                <p>
                                    {{ $dealer->zip }}
                                    {{ $dealer->city }}
                                </p>
                            </div>
                        </div>
                        <div class="">
                            {{-- @can('delete dealer') --}}
                            @include('dealer.partials.delete-dealer-button')
                            {{-- @endcan --}}
                        </div>
                    </div>

                </div>
            </div>


            <div class="w-full max-w-7xl mx-auto pt-5">
                <div
                    class="px-2 md:px-8 bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                    <div class="pb-6 md:m-5 flex space-x-4 justify-between items-baseline">
                        <div class="flex space-x-3">
                            <div class="font-semibold text-xl md:text-2xl pt-4 dark:text-gray-200">
                                Listino
                            </div>
                            <div class="mt-2">
                                <x-secondary-button :href="route('product.create', $dealer->id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        title="Aggiunge un nuovo prodotto al listino del costruttore" class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                            d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </x-secondary-button>
                            </div>
                            <div class="mt-2">
                                <x-secondary-button :href="route('product.showImportPage', $dealer->id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        title="Imposta dal CSV del costruttore uno o più articoli" class="w-6 h-6">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </x-secondary-button>
                            </div>
                        </div>

                        <div>
                            <form method="GET" action="{{ route('warehouse.dealer.show', [$warehouse, $dealer]) }}">
                                <div class="flex items-center">

                                    <div class="flex mt-4 rounded-md border border-gray-300 items-center">
                                        <div class="w-full">
                                            <input
                                                class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                                type="text" aria-label="Search" placeholder="Cerca..."
                                                value="{{ $search ?? '' }}" name="search" autofocus>
                                        </div>

                                        <div class="p-1">
                                            <x-secondary-button class="ml-3 h-12 w-12" title="Filtra ricerca"
                                                id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio">
                                                <i class="fas fa-filter"></i>
                                            </x-secondary-button>

                                            <x-product-filter-dropdown :filters="$filters" />
                                        </div>

                                        <div class="p-1">
                                            <x-primary-button class="h-12 w-12">
                                                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table-auto w-full ">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-left">Codice</div>
                                </th>
                                <th class="p-2 w-2">
                                    <div class="font-semibold text-left"></div>
                                </th>
                                <th class="p-2 ">
                                    <div class="font-semibold text-left">Prodotto</div>
                                </th>
                                <th class=" hidden md:table-cell">
                                    <div class="font-semibold text-right">Ordinati</div>
                                </th>
                                <th class=" hidden md:table-cell">
                                    <div class="font-semibold text-right">Ricevuti</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($products as $product)
                                <tr class="align-middle h-8">
                                    <td class="p-1 whitespace-nowrap">
                                        <x-product-uuid-cell>
                                            {{ $product->uuid }}
                                        </x-product-uuid-cell>
                                    </td>
                                    <td class="p-1 md:p-2 w-2">
                                        <div>
                                            <x-product-status-ball class="w-2 h-2" :status="$product->status"
                                                title="{{ $product->status->description }}" />
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <x-product-name-cell :href="route('warehouse.product.show', [$warehouse, $product])">
                                            {{ $product->name }}
                                        </x-product-name-cell>
                                    </td>
                                    <td class="p-1 text-right hidden md:table-cell">
                                        <div>
                                            <x-product-quantity-cell class="w-2 h-2" :quantity="$product->ordered" />
                                        </div>
                                    </td>
                                    <td class="p-1 text-right hidden md:table-cell">
                                        <div>
                                            <x-product-quantity-cell class="w-2 h-2" :quantity="$product->received" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="w-full max-w-7xl mx-auto p-6">
                        <?php echo $products->appends(['search' => $search ?? ''])->links(); ?>
                    </div>

                </div>
            </div>

        </div>
    </section>

</x-app-layout>
