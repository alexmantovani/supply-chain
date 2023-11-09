<div>
    @if ($refills->count())
        <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-800">
            <div class="h-full ">
                <div class="w-full max-w-7xl mx-auto ">
                    <div class="flex justify-between items-baseline">
                        <div class=" text-gray-900 text-xl p-3 font-semibold">
                            Materiale in esaurimento
                        </div>
                    </div>

                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">
                        <div class="p-1 md:p-3">
                            <div>
                                <table class="table-auto w-full ">
                                    <thead
                                        class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="p-2 whitespace-nowrap">
                                                <div class="font-semibold text-left">Codice</div>
                                            </th>
                                            <th class="w-2 hidden md:table-cell">
                                                <div class="font-semibold text-center"></div>
                                            </th>
                                            <th class="p-2 ">
                                                <div class="font-semibold text-left">Prodotto</div>
                                            </th>
                                            <th class="p-2 hidden md:table-cell">
                                                <div class="font-semibold text-center">Fornitore</div>
                                            </th>
                                            <th class="p-2 hidden md:table-cell">
                                                <div class="font-semibold text-right">Segnalato</div>
                                            </th>
                                            <th class="p-2 w-8 md:table-cell">
                                                <div class="font-semibold text-right"></div>
                                            </th>
                                            <th class="p-2 w-28 whitespace-nowrap">
                                                <div class="font-semibold text-center">Quantità</div>
                                            </th>
                                            <th class="p-2">
                                                <div class="font-semibold text-left"></div>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                        @foreach ($this->refills as $index => $refill)
                                            <tr class="">
                                                <td class="p-2 whitespace-nowrap">
                                                    <x-product-uuid-cell>
                                                        {{ $refill->product->uuid }}
                                                    </x-product-uuid-cell>
                                                </td>
                                                <td class="py-2 w-2 hidden md:table-cell">
                                                    <div class="text-center dark:text-gray-300 min-w-min">
                                                        <x-product-status-ball class="w-2 h-2" :status="$refill->product->status"
                                                            title="{{ $refill->product->status->description }}" />
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <x-product-name-cell class="" :href="route('warehouse.product.show', [
                                                        $warehouse,
                                                        $refill->product,
                                                    ])">
                                                        {{ $refill->product->name }}
                                                    </x-product-name-cell>
                                                </td>
                                                <td class="p-2 hidden md:table-cell text-center">

                                                    @if ($refill->provider)
                                                        <x-product-name-cell class="">
                                                            {{ $refill->provider->name ?? '' }}
                                                        </x-product-name-cell>
                                                    @else
                                                        <div class="flex justify-center mt-0.5"
                                                            title="Fornitore non definito, contatta ufficio acquisti">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6 text-red-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="p-2 hidden md:table-cell text-right">
                                                    <x-product-name-cell class=""
                                                        title="{{ $refill->created_at->translatedFormat('d.m.y H:i') }}">
                                                        {{ Carbon\Carbon::parse($refill->created_at)->diffForHumans() }}
                                                    </x-product-name-cell>
                                                </td>
                                                <td class="p-2 md:table-cell">
                                                    <div wire:click="delete({{ $refill->id }})"
                                                        class="hover:text-red-500 cursor-pointer"
                                                        title="Elimina questo prodotto dalla lista dei materiali in esaurimento">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </div>

                                                </td>
                                                <td class="p-2 whitespace-nowrap items-right">
                                                    <div class="text-center">
                                                        <x-text-input id="quantity"
                                                            class="block mt-1 w-16 md:w-24 text-right " type="text"
                                                            name="quantity[{{ $refill->id }}]" {{-- wire:model.defer="refills.{{ $index }}.quantity" --}}
                                                            wire:model.defer="quantity.{{ $refill->id }}"
                                                            wire:dirty.class="border-red-500" />
                                                    </div>
                                                </td>
                                                <td class="p-4 w-4">
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            title="Seleziona qui per includere l'articolo nell'ordine"
                                                            wire:model.defer="selected.{{ $refill->id }}"
                                                            class="w-4 h-4 text-red-600 bg-gray-100 rounded border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        {{-- <label for="checkbox-table-1" class="sr-only">checkbox</label> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="flex items-center justify-between gap-4">
                            <div class=" text-sm text-gray-500">
                                Spunta tra i materiali in esaurimento quelli che intendi ordinare e premi il tasto
                                qui accanto per avviare l'ordine manualmente
                            </div>
                            <x-primary-button wire:click="sendOrder()">{{ __('Ordina materiale selezionato') }}
                            </x-primary-button>
                        </div>
                    </div>

                    <div>
                        @if (session()->has('message'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">
                                    {{ session('message') }}
                                </span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </section>
    @else
        <div
            class="max-w-7xl mx-auto sm:px-6 px-2 lg:px-8 items-center text-center text-4xl py-8 lg-py-16 text-gray-200 dark:text-gray-700 font-medium">

            <div class="flex justify-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-28 h-28">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>

            <div class="p-2 text-gray-600 dark:text-gray-300">
                Non sono presenti materiali da ordinare
            </div>
            <div class=" text-gray-400 dark:text-gray-500 text-lg font-medium">
                Non è stata fatta alcuna richiesta di materiale da ordinare
            </div>

            @can('handle order')
                <div class="text-lg text-gray-400 dark:text-gray-500 py-16">
                    Clicca
                    <a href="{{ route('warehouse.order.index', $warehouse) }}"
                        class=" text-gray-500 dark:text-gray-300 font-medium hover:underline">qui</a>
                    per andare a controllare lo stato degli ordini
                </div>
            @endcan
            @can('add refill request')
                <div>
                    <a href="{{ route('warehouse.refill.create', $warehouse) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <i class="fa-solid fa-plus" title="Aggiungi tra i materiali in esaurimento"></i>&nbsp;
                        {{ __('Aggiungi materiale in via di esaurimento') }}
                    </a>
                </div>
            @endcan
        </div>
    @endif

</div>
