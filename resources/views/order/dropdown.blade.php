<div class="w-3 md:w-6 h-5">
    @if (in_array($order->status, ['waiting', 'pending']))
        <button id="dropdownDefaultButton_{{ $order->id }}" data-dropdown-toggle="dropdown_{{ $order->id }}"
            class="w-full text-gray-500"
            type="button">

            <svg height="20" xmlns="http://www.w3.org/2000/svg" class=" fill-gray-500 dark:fill-gray-300">
                <g transform="scale(0.35)">
                    <path stroke="null" id="svg_1"
                        d="m20,32a4,4 0 1 1 -4,-4a4.00458,4.00458 0 0 1 4,4zm0,16a4,4 0 1 1 -4,-4a4.00458,4.00458 0 0 1 4,4zm0,-32a4,4 0 1 1 -4,-4a4.00458,4.00458 0 0 1 4,4z" />
                </g>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdown_{{ $order->id }}"
            class=" text-left z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="{{ route('order.completed', $order) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        title="Tutto il materiale ordinato è stato ricevuto">Ordine
                        completato</a>
                </li>
                <li>
                    <a href="{{ route('warehouse.order.edit', [$warehouse, $order]) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        title="E' arrivata solo una parte del materiale ordinato">Arrivo
                        parziale...</a>
                </li>
                @if (in_array($order->status, ['pending']))
                    <li>
                        <a href="{{ route('order.closed', $order) }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            title="Dichiara concluso l'ordine anche se del materiale non è stato consegnato">Chiudi
                            ordine</a>
                    </li>
                @else
                    <li>
                        <form action="{{ route('warehouse.order.destroy', [$warehouse, $order]) }}"
                            class="button block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" title="L'ordine verrà annullato">
                                Annulla ordine
                            </button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    @endif
</div>
