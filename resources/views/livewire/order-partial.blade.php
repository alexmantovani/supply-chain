<div>
    @if (($order->status == 'pending') || ($order->status == 'waiting'))
        <table class="table-auto w-full mb-5">
            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="p-2 whitespace-nowrap w-20">
                        <div class="font-semibold text-left">Codice</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-left px-3">Prodotto</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">Quantità</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">Arrivato</div>
                    </th>
                </tr>
            </thead>

            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($order->products as $product)
                    @if ($product->pivot->received_quantity == $product->pivot->quantity)
                        @continue
                    @endif

                    <tr>
                        <td class="p-2 w-32">
                            <x-product-uuid-cell>
                                {{ $product->uuid }}
                            </x-product-uuid-cell>
                        </td>
                        <td class="p-2 ">
                            <x-product-name-cell :href="route('warehouse.product.show', [$warehouse, $product])">
                                {{ $product->name }}
                            </x-product-name-cell>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center dark:text-gray-300 text-sm md:text-base">
                                {{ $product->pivot->quantity }}
                            </div>
                        </td>

                        <td class="p-2 w-8 text-center">
                            <div class=" items-center">
                                <input type="checkbox"
                                    title="Seleziona qui per indicare che questo articolo è stato consegnato"
                                    wire:model.lazy="selected.{{ $product->id }}" {{-- value=" {{ $product->pivot->quantity }}" --}}
                                    class="w-4 h-4 text-red-600 bg-gray-100 rounded border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="p-3">
            <div class="flex items-center justify-between gap-4">
                <div class=" text-sm  text-gray-600 dark:text-gray-400">
                    Spunta i materiali che ti sono stati consegnati e premi il tasto salva per confermare.
                </div>
                <x-primary-button wire:click="store()">{{ __('Salva') }}
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
    @endif

</div>
