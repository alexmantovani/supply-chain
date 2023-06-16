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
    <x-slot name="navbar_right_menu">
        <x-nav-link :href="route('warehouse.refill.simulate', $warehouse->id)" :active="request()->routeIs('warehouse.refill.simulate')">
            {{ __('Simula QR') }}
        </x-nav-link>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700">

                    <div class="flex justify-between m-5">
                        <div class="pb-6 grid md:grid-cols-2 w-full">
                            <div class="font-semibold text-2xl pt-4 dark:text-gray-200">
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

                    </div>

                </div>
            </div>


            <div class="w-full max-w-7xl mx-auto pt-5">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700">
                    <div class="pb-6 m-5 flex justify-between items-center">
                        <div class="font-semibold text-2xl pt-4 dark:text-gray-200">
                            Listino
                        </div>
                        <div>
                            <form method="GET" action="{{ route('warehouse.dealer.show', [$warehouse, $dealer]) }}">
                                <div class="flex items-center">

                                    <div class="w-30 items-right pt-1 pr-5">
                                        <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio"
                                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-md h-11 text-sm px-3 py-3 mt-3 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            type="button">
                                            <i class="fa-regular fa-filter"></i> &nbsp;
                                            Filtra
                                            <svg class="w-3 h-3 ml-2" aria-hidden="true" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <x-product-filter-dropdown :filters="$filters" />
                                    </div>


                                    <div class="flex mt-4 rounded-md border border-gray-300 items-center">
                                        <div class="w-full">
                                            <input
                                                class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                                type="text" aria-label="Search" placeholder="Cerca..."
                                                value="{{ $search ?? '' }}" name="search" autofocus>
                                        </div>

                                        <div class="p-1">
                                            <x-primary-button class="">
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
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prodotto</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Stato</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Produttore</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($products as $product)
                                <tr class="h-10">
                                    <td class="p-2 whitespace-nowrap">
                                        <x-product-uuid-cell>
                                            {{ $product->uuid }}
                                        </x-product-uuid-cell>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <x-product-name-cell class="" :href="route('warehouse.product.show', [$warehouse, $product])">
                                            {{ $product->name }}
                                        </x-product-name-cell>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center dark:text-gray-300 min-w-min">
                                            <x-product-status class="rounded-md text-xs uppercase py-1 px-2 text-center"
                                                :status="$product->status" />
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <x-product-dealer-cell class="">
                                            {{ $product->dealer->name }}
                                        </x-product-dealer-cell>
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


            {{--
            <div class="w-full max-w-7xl mx-auto pt-5">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700">
                    <div class="pb-6 m-5">
                        <div class="font-semibold text-2xl pt-4 dark:text-gray-200">
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
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prodotto</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-right">Stato ordine</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="p-2 whitespace-nowrap text-gray-600 dark:text-gray-300 text-base ">
                                        <div>
                                            {{ $order->created_at->translatedFormat('d.m.Y') }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-center text-gray-600 dark:text-gray-300 text-base">
                                        <div>
                                            {{ $order->created_at->translatedFormat('H:i') }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        @foreach ($order->products as $product)
                                            <div class=" text-gray-600 dark:text-gray-300 text-base py-1">
                                                <div>
                                                    {{ $product->name }} &middot;
                                                    {{ $product->pivot->quantity }} articoli
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div
                                            class=" text-gray-600 text-center w-30 uppercase text-xs p-2 rounded-md border">
                                            {{ $order->status }}</div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="w-full max-w-7xl mx-auto pt-6">
                        <?php echo $orders->appends(['search' => $search ?? ''])->links(); ?>
                    </div>
                </div>

            </div>

            --}}

        </div>
    </section>

</x-app-layout>
