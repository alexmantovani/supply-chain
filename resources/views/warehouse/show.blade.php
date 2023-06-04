<x-app-layout>
    <x-slot name="navbar_title">
        {{ $warehouse->name }}
    </x-slot>
    <x-slot name="warehouse_id">
        {{ $warehouse->id }}
    </x-slot>

    {{-- <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $warehouse->name }}
            </h2>
            <div class="px-1 text-gray-500">
              &nbsp; | &nbsp; {{ $warehouse->description }}
            </div>
        </div>
    </x-slot> --}}

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Materiale in esaurimento -->
            <form method="post" action="{{ route('warehouse.order.store', $warehouse) }}">
                @csrf

                <div
                    class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">
                    <div class=" text-gray-900 text-xl px-3 pt-8 pb-3 font-semibold">
                        Materiale in esaurimento
                    </div>

                    <div class="p-3">
                        <div class="overflow-x-auto">

                            <table class="table-auto w-full ">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Prodotto</div>
                                        </th>
                                        <th class="p-2 w-28">
                                            <div class="font-semibold text-center">Quantità</div>
                                        </th>
                                        <th class="p-2 w-40">
                                            <div class="font-semibold">Stato</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left"></div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($refills as $refill)
                                        <tr>
                                            <td class="p-2 whitespace-nowrap">
                                                <div class=" items-center">
                                                    <div>
                                                        <a href="{{ route('dealer.show', $refill->dealer_id) }}"
                                                            class="font-medium text-gray-400 hover:text-gray-800">
                                                            {{ $refill->name }}
                                                        </a>
                                                    </div>
                                                    <div class="font-medium text-gray-800 text-lg dark:text-gray-300">
                                                        <a href="{{ route('product.show', $refill->product) }}"
                                                            class=" hover:underline">
                                                            {{ $refill->product->name }}
                                                        </a>
                                                    </div>
                                                    <div class="font-medium text-gray-400 pt-0.5">
                                                        Segnalato da {{ $refill->user->name }} &middot;
                                                        {{ $refill->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-2 whitespace-nowrap items-right">
                                                <div class="text-center">
                                                    <x-text-input id="quantity" class="block mt-1 w-24 text-right "
                                                        type="text" name="quantity.{{ $refill->id }}"
                                                        :value="$refill->quantity" required />
                                                </div>
                                            </td>
                                            <td class="p-2 ">
                                                <div
                                                    class="text-center font-medium uppercase rounded-lg bg-yellow-400 text-yellow-700 py-2 px-3 text-xs ">
                                                    {{ $refill->status }}
                                                </div>
                                            </td>
                                            <td class="p-4 w-4">
                                                <div class="flex items-center">
                                                    <input id="checkbox-table-1" type="checkbox"
                                                        name="dealer.{{ $refill->dealer()->id }}[]"
                                                        value="{{ $refill->id }}"
                                                        title="Seleziona qui per includere l'articolo nell'ordine"
                                                        class="w-4 h-4 text-indigo-600 bg-gray-100 rounded border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-center justify-between gap-4">
                        <div class=" text-sm text-gray-500">
                            Spunta tra i materiali in esaurimento quelli che intendi ordinare e premi il tasto
                            qui accanto per avviare l'ordine manualmente
                        </div>
                        <x-primary-button>{{ __('Ordina materiale selezionato') }}</x-primary-button>
                    </div>
                </div>

            </form>


            <!-- Materiale in arrivo -->
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">
                <div class=" text-gray-900 text-xl px-3 pt-8 pb-3 font-semibold">
                    Materiale in arrivo
                </div>

                <div class="p-3">
                    <div class="overflow-x-auto">

                        <table class="table-auto w-full ">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Prodotto</div>
                                    </th>
                                    <th class="p-2 w-28">
                                        <div class="font-semibold text-center">Quantità</div>
                                    </th>
                                    <th class="p-2 w-40">
                                        <div class="font-semibold">Stato</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left"></div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($refills as $refill)
                                    <tr>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class=" items-center">
                                                <div>
                                                    <a href="{{ route('dealer.show', $refill->dealer_id) }}"
                                                        class="font-medium text-gray-400 hover:text-gray-800">
                                                        {{ $refill->name }}
                                                    </a>
                                                </div>
                                                <div class="font-medium text-gray-800 text-lg dark:text-gray-300">
                                                    <a href="{{ route('product.show', $refill->product) }}"
                                                        class=" hover:underline">
                                                        {{ $refill->product->name }}
                                                    </a>
                                                </div>
                                                <div class="font-medium text-gray-400 pt-0.5">
                                                    Segnalato da {{ $refill->user->name }} &middot;
                                                    {{ $refill->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap items-right">
                                            <div class="text-center">
                                                <x-text-input id="quantity" class="block mt-1 w-24 text-right "
                                                    type="text" name="quantity.{{ $refill->id }}"
                                                    :value="$refill->quantity" required />
                                            </div>
                                        </td>
                                        <td class="p-2 ">
                                            <div
                                                class="text-center font-medium uppercase rounded-lg bg-yellow-400 text-yellow-700 py-2 px-3 text-xs ">
                                                {{ $refill->status }}
                                            </div>
                                        </td>
                                        <td class="p-4 w-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-table-1" type="checkbox"
                                                    name="dealer.{{ $refill->dealer()->id }}[]"
                                                    value="{{ $refill->id }}"
                                                    title="Seleziona qui per includere l'articolo nell'ordine"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 rounded border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center justify-between gap-4">
                    <div class=" text-sm text-gray-500">
                        Spunta tra i materiali in esaurimento quelli che intendi ordinare e premi il tasto
                        qui accanto per avviare l'ordine manualmente
                    </div>
                    <x-primary-button>{{ __('Ordina materiale selezionato') }}</x-primary-button>
                </div>
            </div>


        </div>
    </section>

</x-app-layout>
