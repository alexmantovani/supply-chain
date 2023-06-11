<div class="w-8 text-center">
    @if (in_array($order->status, ['waiting', 'pending']))
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
            class="text-gray-500 border-gray-200 text-center hover:border-gray-500 border focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center"
            type="button">
            <i class="fa-regular fa-ellipsis-vertical"></i>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdown"
            class=" text-left z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="{{ route('order.completed', $order) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ordine
                        completato</a>
                </li>
                {{-- TODO: Gestire anche l'arrivo parziale
            <li>
                <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Arrivo
                    parziale...</a>
            </li> --}}
                <li>
                    <form action="{{ route('warehouse.order.destroy', [$warehouse, $order]) }}"
                        class="button block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500"
                        method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit">
                            Annulla ordine
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @endif
</div>
