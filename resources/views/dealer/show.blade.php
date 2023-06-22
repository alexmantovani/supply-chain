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
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="">
                <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
            </x-secondary-button>
        </a>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto">
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
                    class="px-1 md:px-8 bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                    <div class="pb-6 md:m-5 flex justify-between items-center">
                        <div class="font-semibold text-2xl pt-4 dark:text-gray-200">
                            Listino
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
                                            <x-product-status-ball class="w-2 h-2"
                                                :status="$product->status" title="{{ $product->status->description }}" />
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <x-product-name-cell :href="route('warehouse.product.show', [$warehouse, $product])">
                                            {{ $product->name }}
                                        </x-product-name-cell>
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
