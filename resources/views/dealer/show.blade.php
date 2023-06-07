<x-app-layout>
    <x-slot name="navbar_title">
        <div
            class="
                sm:-my-px sm:ml-10 sm:flex font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight items-center
                cursor-pointer">
            <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
        </div>
        <x-navbar-title>
            Informazioni sul produttore
        </x-navbar-title>
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
                        <a href="{{ route('product.create', $dealer->id) }}">

                            <x-secondary-button title="{{ __('Aggiungi un nuovo prodotto a listino') }}">
                                <i class="fa-sharp fa-solid fa-plus"></i> &nbsp;
                                {{ __('Aggiungi') }}
                            </x-secondary-button>
                        </a>
                    </div>

                    <table class="table-auto w-full ">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Id</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prodotto</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center"
                                        title="Numero di articoli che vengono riordinati di default">Quantità</div>
                                </th>

                                <th class="p-2 w-20 text-center items-center">
                                    <div class="font-semibold">Azioni</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($products as $product)
                                <tr class=" h-10">
                                    <td>
                                        <div class="text-center dark:text-gray-300">
                                            {{ $product->id }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-left dark:text-gray-300">
                                            {{ $product->name }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap dark:text-gray-300">
                                        <div class="text-center">{{ $product->refill_quantity }}</div>
                                    </td>
                                    <td class="p-2 w-20 text-center items-center">
                                        <x-primary-button>
                                            {{ __('Ordina') }}
                                        </x-primary-button>
                                    </td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="w-full max-w-7xl mx-auto pt-6">
                        <?php echo $products->appends(['search' => $search ?? ''])->links(); ?>
                    </div>

                </div>
            </div>


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
                            {{--
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
                            @endforeach --}}
                        </tbody>
                    </table>

                    <div class="w-full max-w-7xl mx-auto pt-6">
                        {{-- <?php echo $orders->appends(['search' => $search ?? ''])->links(); ?> --}}
                    </div>
                </div>

            </div>



        </div>
    </section>

</x-app-layout>
