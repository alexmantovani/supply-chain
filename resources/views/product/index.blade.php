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

            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="mx-3">
                    <form method="GET" action="{{ route('warehouse.product.index', $warehouse) }}">
                        <div class="flex mt-4 rounded-md border border-gray-300 items-center">
                            <div class="w-full">
                                <input
                                    class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                    type="text" aria-label="Search" placeholder="Cerca..." value="{{ $search ?? '' }}"
                                    name="search" autofocus>
                            </div>

                            <div class="p-1">
                                <x-secondary-button class="ml-3 h-12 w-12" title="Filtra ricerca"
                                    id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio">
                                    <i class="fas fa-filter"></i>
                                </x-secondary-button>

                                <x-product-filter-dropdown :filters="$filters" />
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

                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full ">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-2 whitespace-nowrap w-30">
                                        <div class="font-semibold text-left">CODICE</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Articolo</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Stato</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Produttore</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="">
                                            <x-product-uuid-cell class="" :href="route('warehouse.product.show', [$warehouse, $product])">
                                                {{ $product->uuid }}
                                            </x-product-uuid-cell>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <x-product-name-cell class="" :href="route('warehouse.product.show', [$warehouse, $product])">
                                                {{ $product->name }}
                                            </x-product-name-cell>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <x-product-status class="rounded-md text-xs uppercase py-1 px-2 text-center"
                                                :status="$product->status" />
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <x-product-dealer-cell class="" :href="route('warehouse.dealer.show', [$warehouse, $product->dealer])">
                                                {{ $product->dealer->name }}
                                            </x-product-dealer-cell>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-7xl mx-auto pt-6">
                <?php echo $products->appends(['search' => $search ?? '', 'filters' => $filters])->links(); ?>
            </div>
        </div>
    </section>

</x-app-layout>
