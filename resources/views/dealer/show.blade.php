<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <div class="pr-3 text-lg cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dettaglio fornitore
            </h2>
        </div>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8">

                    <div class="flex justify-between m-5">
                        <div class="pb-6 grid md:grid-cols-2 w-full">
                            <div class="font-semibold text-2xl pt-4">
                                {{ $dealer->name }}
                            </div>
                            <div class="mt-4 text-gray-400">
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
                <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 py-8">
                    <div class="pb-6 m-5">
                        <div class="font-semibold text-2xl pt-4">
                            Listino
                        </div>
                    </div>

                    <table class="table-auto w-full ">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Id</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Prodotto</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Quantità</div>
                                </th>

                                <th class="p-2 w-20 text-center items-center">
                                    <div class="font-semibold">Azioni</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($products as $product)
                                <tr class=" h-10">
                                    <td>
                                        <div class="text-center">
                                            {{ $product->id }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-left">
                                            {{ $product->name }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center">32</div>
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
                <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 py-8">
                    <div class="pb-6 m-5">
                        <div class="font-semibold text-2xl pt-4">
                            Ordini
                        </div>
                    </div>

                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
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
                        @foreach ($orders as $order)
                            <tr>
                                <td class="p-2 whitespace-nowrap text-gray-600 text-base ">
                                    <div>
                                        {{ $order->created_at->translatedFormat('d.m.Y') }}
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-center text-gray-600 text-base">
                                    <div>
                                        {{ $order->created_at->translatedFormat('H:i') }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    @foreach ($order->products as $product)
                                        <div class=" text-gray-600 text-base py-1">
                                            <div>
                                                {{ $product->name }} &middot;
                                                {{ $product->pivot->quantity }} articoli
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    <div class=" text-gray-600 text-right uppercase">{{ $order->status }}</div>
                                </td>
                                {{-- <td class="p-2 whitespace-nowrap text-gray-500 ">
                                    <div>
                                        {{ $log->description }}
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-gray-500 text-right">
                                    <div>
                                        {{ $log->user->name ?? '' }}
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </table>

                    <div class="w-full max-w-7xl mx-auto pt-6">
                        <?php echo $orders->appends(['search' => $search ?? ''])->links(); ?>
                    </div>
                </div>

            </div>



        </div>
    </section>

</x-app-layout>
