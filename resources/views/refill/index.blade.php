<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materiale in esaurimento') }}
        </h2>
    </x-slot>

    @if ($refills->count())
        <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">

            <div class="h-full ">
                <!-- Table -->
                <form method="post" action="{{ route('order.store') }}">
                    @csrf
                    <div class="w-full max-w-7xl mx-auto ">
                        <div
                            class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800">

                            <div class="p-3">
                                <div class="">
                                    <table class="table-auto w-full ">
                                        <thead
                                            class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
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
                                                                {{ $refill->product->name }}
                                                            </div>
                                                            <div class="font-medium text-gray-400 pt-0.5">
                                                                Segnalato da {{ $refill->user->name }} &middot;
                                                                {{ $refill->created_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-2 whitespace-nowrap items-right">
                                                        <div class="text-center">
                                                            <x-text-input id="quantity"
                                                                class="block mt-1 w-24 text-right " type="text"
                                                                name="quantity" :value="$refill->quantity" required />
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
                                    qui accanto per avviare l'ordine
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
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 items-center text-center text-4xl py-16 text-gray-500 font-medium">
            <div class=" text-4xl text-gray-200 font-medium py-10" style="font-size: 90px">
                <i class="fa-regular fa-thumbs-up"></i>
            </div>
            <div class=" p-2">
                Non sono presenti materiali in esaurimento
            </div>
            <div class=" text-lg text-gray-300 font-medium">
                Il magazzino è perfettamente rifornito
            </div>

            <div class=" text-lg text-gray-300 py-16">
                Clicca
                <a href="{{ route('order.index') }}" class=" text-gray-500 font-medium hover:underline">qui</a>
                per andare a controllare lo stato degli ordini
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
    </script>

</x-app-layout>
