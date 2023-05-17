<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Situazione magazzino') }}
        </h2>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="p-3">
                    <div class="overflow-x-auto">
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
                                        <div class="font-semibold text-center">Quantità</div>
                                    </th>
                                    <th class="p-2 w-40">
                                        <div class="font-semibold">Stato</div>
                                    </th>

                                    <th class="p-2 w-30 text-center items-center">
                                        <div class="font-semibold">Azioni</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>
                                            <div class="text-center text-gray-300 dark:text-gray-400">
                                                {{ $stock->product->id }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class=" items-center">
                                                {{-- <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img
                                                class="rounded"
                                                src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg"
                                                width="40" height="40" alt="Alex Shatov"></div> --}}
                                                <div
                                                    class="flex justify-between items-center font-medium text-gray-800 text-lg dark:text-gray-300">
                                                    <a href="{{ route('product.show', $stock->product) }}"
                                                        class=" hover:underline">
                                                        {{ $stock->product->name }}
                                                    </a>
                                                    @if ($stock->product->isLow())
                                                        <div
                                                            class=" text-xs px-2 py-1 align-middle bg-indigo-400 text-white rounded uppercase">
                                                            in esaurimento
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="f">
                                                    <a href="{{ route('dealer.show', $stock->product->dealer) }}"
                                                        class="font-medium text-gray-400 hover:text-gray-800 hover:underline">
                                                        {{ $stock->product->dealer->name }}
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
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center dark:text-gray-300">
                                                {{ $stock->quantity }}
                                            </div>
                                        </td>
                                        <td class="p-2 ">
                                            <div
                                                class="text-center font-medium uppercase rounded-lg py-2 px-3 text-xs {!! $stock->status_color !!}">
                                                {!! $stock->status !!}
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            @if ($stock->quantity > 0)
                                                <div>
                                                    <a href="{{ route('stock.pickup', $stock) }}"
                                                        class="text-xs uppercase p-2 border rounded-lg border-gray-500 text-gray-500 dark:text-gray-300">

                                                        Preleva
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
