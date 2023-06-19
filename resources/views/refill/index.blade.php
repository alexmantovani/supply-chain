<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex ml-5 items-center space-x-5">
            <div>
                <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
                    {{ $warehouse->name }}
                </x-navbar-title>
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar', ['warehouse' => $warehouse])
    </x-slot>
    <x-slot name="navbar_right_menu">
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="">
                <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
            </x-secondary-button>
        </a>
    </x-slot>

    @if ($refills->count())
        <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
            <div class="h-full ">

                <form method="post" action="{{ route('warehouse.order.store', $warehouse) }}">
                    @csrf
                    <div class="w-full max-w-7xl mx-auto ">
                        <div class="flex justify-between items-baseline">
                            <div class=" text-gray-900 text-xl p-3 font-semibold">
                                Materiale in esaurimento
                            </div>
                        </div>

                        <div
                            class="bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">

                            <div class="p-3">
                                <div class="">
                                    <table class="table-auto w-full ">
                                        <thead
                                            class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Codice</div>
                                                </th>
                                                <th class="p-2 ">
                                                    <div class="font-semibold text-left">Prodotto</div>
                                                </th>
                                                <th class="p-2 w-28 hidden md:table-cell">
                                                    <div class="font-semibold text-center"></div>
                                                </th>
                                                <th class="p-2 w-8 hidden md:table-cell">
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
                                            @foreach ($refills as $refill)
                                                <tr>
                                                    <td class="p-2 whitespace-nowrap">
                                                        <x-product-uuid-cell>
                                                            {{ $refill->product->uuid }}
                                                        </x-product-uuid-cell>
                                                    </td>
                                                    <td class="p-2">
                                                        <x-product-name-cell class="" :href="route('warehouse.product.show', [
                                                            $warehouse,
                                                            $refill->product,
                                                        ])">
                                                            {{ $refill->product->name }}
                                                        </x-product-name-cell>
                                                    </td>
                                                    <td class="p-2  hidden md:table-cell">
                                                        <div class="text-center dark:text-gray-300 min-w-min">
                                                            <x-product-status
                                                                class="rounded-md text-xs uppercase py-1 px-2 text-center"
                                                                :status="$refill->product->status" />
                                                        </div>
                                                    </td>
                                                    <td class="p-2 hidden md:table-cell">
                                                        <div onclick='handleClick(this);' id="delete_{{ $refill->id }}" data-id="{{ $refill->id }}" class="hover:text-red-500 cursor-pointer">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </div>
                                                        {{-- <form
                                                            action="{{ route('warehouse.refill.destroy', [$warehouse, $refill]) }}"
                                                            class="button block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form> --}}
                                                    </td>
                                                    <td class="p-2 whitespace-nowrap items-right">
                                                        <div class="text-center">
                                                            <x-text-input id="quantity"
                                                                class="block mt-1 w-24 text-right " type="text"
                                                                name="quantity[{{ $refill->id }}]"
                                                                :value="$refill->quantity" />
                                                        </div>
                                                    </td>
                                                    <td class="p-4 w-4">
                                                        <div class="flex items-center">
                                                            <input id="checkbox-table-1" type="checkbox"
                                                                name="refill.{{ $refill->provider_id }}[]"
                                                                value="{{ $refill->id }}"
                                                                title="Seleziona qui per includere l'articolo nell'ordine"
                                                                class="w-4 h-4 text-indigo-600 bg-gray-100 rounded border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="checkbox-table-1"
                                                                class="sr-only">checkbox</label>
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
                </form>

            </div>
        </section>
    @else
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 items-center text-center text-4xl py-16 text-gray-200 dark:text-gray-700 font-medium">
            <div class="text-4xl text-gray-200 dark:text-gray-800 font-medium py-10" style="font-size: 90px">
                <i class="fa-regular fa-circle-exclamation"></i>
            </div>
            <div class="p-2 text-gray-600 dark:text-gray-300">
                Non sono presenti materiali da ordinare
            </div>
            <div class="text-gray-400 dark:text-gray-500 text-lg font-medium">
                Non è stata fatta alcuna richiesta di materiale da ordinare
            </div>

            <div class="text-lg text-gray-400 dark:text-gray-500 py-16">
                Clicca
                <a href="{{ route('warehouse.order.index', $warehouse) }}"
                    class=" text-gray-500 dark:text-gray-300 font-medium hover:underline">qui</a>
                per andare a controllare lo stato degli ordini
            </div>
            <div>
                <a href="{{ route('warehouse.refill.create', $warehouse) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fa-solid fa-plus" title="Aggiungi tra i materiali in esaurimento"></i>&nbsp;
                    {{ __('Aggiungi materiale in via di esaurimento') }}
                </a>
            </div>
        </div>
    @endif


    <script>
        function dropdownFunction(element) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            let list = element.parentElement.parentElement.getElementsByClassName("dropdown-content")[0];
            list.classList.add("target");
            for (i = 0; i < dropdowns.length; i++) {
                if (!dropdowns[i].classList.contains("target")) {
                    dropdowns[i].classList.add("hidden");
                }
            }
            list.classList.toggle("hidden");
        }

        function handleClick(element) {
            var id = $(element).attr('data-id');
            var dati = $('#delete_' + id + ' :input').serialize();
            console.log(id);
            // $.ajax({
            //     url: "{ route('price_list.update.analisys') }?" + dati,
            //        type: 'DELETE'
            // }).done(function(data) {
            //     document.getElementById('commission_' + id).value = data['commission'];
            // });
        }

    </script>

</x-app-layout>
