<x-app-layout>
    <x-slot name="navbar_title">
        {{ $warehouse->name }}
    </x-slot>
    <x-slot name="warehouse_id">
        {{ $warehouse->id }}
    </x-slot>

    {{--
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-baseline">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $warehouse->name }}
                </h2>
                <div class="px-1 text-gray-500">
                  &nbsp; | &nbsp; {{ __('Storico ordini') }}
                </div>
            </div>
            <div class="dark:text-gray-400">
                <a href="{{ route('warehouse.order.index', $warehouse) }}" class="">
                    In lavorazione
                </a>
                &nbsp; | &nbsp;
                <a href="{{ route('warehouse.order.index', [$warehouse, 'all']) }}">
                    Tutti
                </a>
            </div>
        </div>
    </x-slot> --}}

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">

            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div
                    class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">
                    <div class=" text-gray-900 text-xl px-3 pt-8 pb-3 font-semibold">
                        Elenco ordini
                    </div>

                    <div class="p-3">
                        <div class="">
                            <table class="table-auto w-full ">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Articolo</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Quantità</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Data</div>
                                        </th>
                                        <th class="p-2 w-40">
                                            <div class="font-semibold">Stato</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">
                                                Azioni
                                            </div>
                                        </th>
                                        <th class="p-2 w-10">
                                            <div class="font-semibold"></div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($orders as $order)
                                        @foreach ($order->products as $product)
                                            <tr>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class=" items-center">
                                                        <a href="{{ route('product.show', $product->id) }}"
                                                            class="font-medium text-gray-800 text-lg dark:text-gray-300 hover:underline">
                                                            {{ $product->name }}
                                                        </a>

                                                        <div class=" text-gray-400 text-xs py-1">
                                                            <div>
                                                                {{ $order->dealer->name }}
                                                            </div>
                                                        </div>


                                                    </div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-center dark:text-gray-300">
                                                        {{ $product->pivot->quantity }}

                                                    </div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-center dark:text-gray-300">
                                                        {{ $order->created_at->translatedFormat('d.m.Y') }}
                                                        <br>
                                                        {{ $order->created_at->translatedFormat('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="p-2 ">
                                                    <div
                                                        class="text-center font-medium uppercase rounded-lg py-2 px-3 text-xs {!! $order->status_color !!}  dark:text-gray-300">
                                                        {!! $order->status !!}
                                                    </div>
                                                </td>
                                                <td class="text-right px-3 py-3 w-40">

                                                    @if ($order->status == 'In attesa')
                                                        <div class="text-center">
                                                            <a href="{{ route('order.completed', $order) }}"
                                                                title="Materiale arrivato"
                                                                class='inline-flex w-11 h-10 items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'>
                                                                <i class="fas fa-box"></i>
                                                            </a>

                                                            {{-- <a href="{{ route('order.completed', $order) }}"
                                                                type="button"
                                                                class="text-xs uppercase p-3 m-3 border rounded-lg bg-blue-400 hover:underline text-white text-center"
                                                                title="Clicca qui per indicare che il materiale è arrivato e ubicato in magazzino">
                                                                <i class="fas fa-box"></i>
                                                            </a> --}}
                                                        </div>
                                                    @else
                                                    @endif
                                                    {{-- <a href=""
                                                        class=" text-right border text-gray-600 rounded-lg py-2 px-3 text-base uppercase">
                                                        <i class="far fa-ellipsis-v"></i>
                                                    </a> --}}
                                                </td>
                                                <td class="text-right px-3 py-3 w-10">
                                                    <a href="{{ route('warehouse.order.show', [$warehouse, $order->id]) }}"
                                                        class="font-medium text-gray-800 text-lg hover:underline dark:text-gray-300">
                                                        <i class="fa-solid fa-angle-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-7xl mx-auto pt-6">
                <?php echo $orders->appends(['search' => $search ?? ''])->links(); ?>
            </div>
        </div>
    </section>

</x-app-layout>
