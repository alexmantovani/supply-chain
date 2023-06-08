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

            <div class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="mx-8">
                    <form method="GET" action="{{ route('warehouse.product.index', $warehouse) }}">
                        <div class="flex mt-4 rounded-md border border-gray-300 items-center">
                            <div class="w-full">
                                <input
                                class="mr-3 bg-transparent border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                type="text" aria-label="Search" placeholder="Cerca..." value="{{ $search ?? '' }}"
                                name="search" autofocus>
                            </div>

                            <div class="p-1">
                                <x-primary-button class="ml-3 h-12 w-12">
                                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                                </x-primary-button>
                            </div>

                        </div>
                        <div class="text-xs text-gray-400 text-right pt-1">
                            Trovati {{ $products->total() }} risultati
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
                                        <div class="font-semibold text-left">Prodotto</div>
                                    </th>
                                    <th class="p-2 w-30 text-center items-center">
                                        <div class="font-semibold"></div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="">
                                            <div class="text-left text-gray-300 dark:text-gray-400">
                                                {{ $product->uuid }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class=" items-center">
                                                {{-- <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img
                                                class="rounded-full"
                                                src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg"
                                                width="40" height="40" alt="Alex Shatov"></div> --}}
                                                <div class="font-medium text-gray-800 text-lg dark:text-gray-300">
                                                    <a href="{{ route('warehouse.product.show', [$warehouse, $product]) }}" class=" hover:underline">
                                                        {{ $product->name }}
                                                    </a>
                                                </div>
                                                <div class="f">
                                                    <a href="{{ route('dealer.show', $product->dealer) }}"
                                                        class="font-medium text-gray-400 hover:text-gray-800 hover:underline">
                                                        {{ $product->dealer->name }}
                                                    </a>
                                                </div>
                                            </div>

                                            {{-- <div class="flex items-center">
                                                <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img
                                                        class="rounded-full"
                                                        src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg"
                                                        width="40" height="40" alt="Alex Shatov"></div>
                                                <div class="font-medium text-gray-800">
                                                    {{ $stock->product->name }}
                                                </div>
                                            </div> --}}
                                        </td>

                                        <td class="text-right px-3 py-3 w-10">
                                            <a href="{{ route('warehouse.product.show', [$warehouse, $product->id]) }}"
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

            <div class="w-full max-w-7xl mx-auto pt-6">
                <?php echo $products->appends(['search' => $search ?? ''])->links(); ?>
            </div>
        </div>
    </section>

</x-app-layout>
