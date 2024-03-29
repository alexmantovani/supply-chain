<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div
                class="
              font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
            cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div>
                <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
                    {{ $warehouse->name }}
                </x-navbar-title>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    </x-slot>
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar', ['warehouse' => $warehouse])
    </x-slot>
    <x-slot name="navbar_right_menu">
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-800">

        <div class="w-full max-w-7xl mx-auto ">
            <div
                class="bg-white shadow-lg rounded-sm border border-gray-200 md:px-8 dark:bg-gray-900 dark:border-gray-700">
                <div class="m-5">
                    <div class="flex justify-between">
                        <div class="font-semibold text-xl md:text-2xl dark:text-gray-200">
                            {{ $product->name }}
                        </div>
                        <x-product-status class=" border-r-4 text-xs uppercase py-2 px-3 w-40 text-right"
                            :status="$product->status" />
                    </div>
                    @if ($product->description)
                        <div class="text-lg text-gray-500 dark:text-gray-200">
                            {{ $product->description }}
                        </div>
                    @endif

                    <div class="text-lg text-gray-500 dark:text-gray-200">
                        Codice: {{ $product->uuid }}
                    </div>

                    @if ($product->note)
                        <div class="text-lg text-gray-500 dark:text-gray-200 pt-3">
                            Note: {{ $product->note }}
                        </div>
                    @endif

                </div>

            </div>

            <div class="md:grid md:grid-cols-2 md:gap-4 h-full pt-8 mx-2">
                <div class="bg-white p-5 md:shadow-lg md:rounded-sm md:border border-gray-200 dark:bg-gray-900">
                    <div class="font-semibold text-2xl dark:text-gray-200 pb-6 md:mx-5">
                        Trend ordini
                    </div>
                    <canvas id="myChart" width="400" height="150"></canvas>
                </div>

                <div class="border-t-2 md:border-t-0 md:border-l-2 border-gray-200 border-dotted">
                    <div class="md:px-5">
                        <div class=" text-gray-400 text-xl font-semibold">
                            Produttore
                        </div>

                        <div class=" ">
                            <div class="pb-6">
                                <div class="font-semibold text-xl md:text-2xl py-2 dark:text-gray-200">
                                    <a href="{{ route('warehouse.dealer.show', [$warehouse, $product->dealer->id]) }}"
                                        class=" cursor-pointer hover:underline">
                                        {{ $product->dealer->name ?? '' }}
                                    </a>
                                </div>
                                <div class="mt-1 dark:text-gray-400 text-sm text-gray-500">
                                    <div class="flex justify-between">
                                        <div>
                                            Codice produttore:
                                        </div>
                                        <span class=" text-gray-800 font-semibold">
                                            {{ $product->code }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1 dark:text-gray-400 text-sm text-gray-500">
                                    <div class="flex justify-between">
                                        <div>
                                            Modello produttore:
                                        </div>
                                        <span class=" text-gray-800 font-semibold">
                                            {{ $product->dealer->model }}
                                        </span>
                                    </div>
                                    {{ $product->dealer->address }}
                                    <p>
                                        {{ $product->dealer->city }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:px-5 pt-4">
                        <div class=" text-gray-400 text-xl md:text-2xl font-semibold">
                            Fornitore
                        </div>

                        <div class="pt-2">
                            @if ($provider)
                                @if ($provider->image_url)
                                    <img src="{{ asset('/provider_images/' . $provider->image_url) }}" alt=""
                                        class="w-40 mr-2 object-contain">
                                @else
                                    <div class="font-semibold text-2xl pt-2 dark:text-gray-200">
                                        {{ $provider->name }}
                                    </div>
                                @endif

                                <div class="pb-2 mt-3">
                                    <div class=" dark:text-gray-400 text-sm text-gray-500">
                                        Codice fornitore:
                                        <span>
                                            {{ $provider->provider_code }}
                                        </span>
                                    </div>

                                    <div class=" dark:text-gray-400 text-sm text-gray-500">
                                        <a href="mailto:{{ $provider->email }}">
                                            Email:
                                            <span>
                                                {{ $provider->email }}
                                            </span>
                                        </a>
                                    </div>

                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="md:flex mt-5 mx-2">
                <div
                    class="flex-1 md:bg-white md:shadow-lg md:rounded-sm md:border border-gray-200 md:px-8 py-8 dark:bg-gray-900 dark:md:bg-gray-900 dark:border-gray-700">
                    <div class="pb-6 md:mx-5">
                        <div class="font-semibold text-2xl dark:text-gray-200">
                            Ordini
                        </div>
                    </div>

                    @if ($product->orders->count())
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-2 w-5">
                                        <div class="font-semibold text-center"></div>
                                    </th>
                                    <th class="p-2 w-20">
                                        <div class="font-semibold text-center">Data</div>
                                    </th>
                                    <th class="p-2 hidden md:w-20">
                                        <div class="font-semibold text-center">Ora</div>
                                    </th>
                                    <th>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Identificativo</div>
                                    </th>
                                    <th class="p-2 hidden md:table-cell">
                                        <div class="font-semibold text-left">Magazzino</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap hidden md:table-cell">
                                        <div class="font-semibold text-right">Quantità</div>
                                    </th>
                                    <th class="p-2 w-30">
                                        <div class="font-semibold text-right">Stato</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">

                                @foreach ($product->orders as $order)
                                    <tr class="">
                                        <td
                                            class="p-1 font-sm md:text-md whitespace-nowrap text-gray-400 dark:text-gray-300  ">
                                            <x-product-arrived :arrived="$order->pivot->received_quantity" status="{{ $order->status }}"
                                                class="text-xs" />
                                        </td>
                                        <td
                                            class="p-1 font-sm md:text-md whitespace-nowrap text-gray-400 dark:text-gray-300  ">
                                            <div>
                                                {{ $order->created_at->translatedFormat('d.m.Y') }}
                                            </div>
                                        </td>
                                        <td
                                            class="p-1 font-sm md:text-md hidden text-center text-gray-400 dark:text-gray-300 ">
                                            <div>
                                                {{ $order->created_at->translatedFormat('H:i') }}
                                            </div>
                                        </td>
                                        <td class=" text-right">
                                            @if ($order->urgent)
                                                <div title="Ordine urgente">
                                                    🔥
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-1 text-left">
                                            <x-product-name-cell class="" :href="route('warehouse.order.show', [$warehouse, $order])">
                                                {{ $order->uuid }}
                                            </x-product-name-cell>
                                        </td>
                                        <td
                                            class="p-1 font-sm md:text-md text-gray-600 dark:text-gray-300 whitespace-nowrap hidden md:table-cell">
                                            <x-product-name-cell class="">
                                                {{ $order->warehouse->name ?? '' }}
                                            </x-product-name-cell>
                                        </td>
                                        <td
                                            class="p-1 font-sm md:text-md  whitespace-nowrap text-gray-500 dark:text-gray-300 hidden md:table-cell">
                                            <div class=" text-right">
                                                {{ $order->pivot->quantity }}
                                            </div>
                                        </td>
                                        <td
                                            class="p-1 whitespace-nowrap text-xs text-gray-500 dark:text-gray-300 text-right md:w-40 ">
                                            <div class="mt-1">
                                                <x-order-status-gradient
                                                    class="text-xs font-semibold uppercase py-1 border-r-4 text-gray-700 text-right px-2"
                                                    :status="$order->status" />
                                            </div>
                                            {{-- <x-order-status class="rounded-md text-xs uppercase py-1 px-1 md:py-2 md:px-3 text-center"
                                            :status="$order->status" /> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class=" text-center text-2xl text-gray-300 pt-16">
                            Non ci sono ordini relativi a questo prodotto.
                        </div>
                    @endif

                </div>

                @can('add refill request')

                    @if ($product->isOrdinable())
                        <div
                            class=" bg-yellow-100 shadow-lg md:ml-4 rounded-sm border border-gray-200 px-8 my-4 md:my-0 py-8 dark:bg-gray-900 dark:border-gray-700 max-h-min">
                            <div class="pb-4 mx-5">
                                <div class="font-semibold text-2xl dark:text-gray-200">
                                    Ordina al volo
                                </div>
                            </div>

                            <form method="POST" action="{{ route('warehouse.refill.store', $warehouse) }}">
                                @csrf
                                <input type="hidden" name="codes" value="{{ $product->uuid }}">

                                <div class="pb-3">
                                    <x-input-label for="warehouse_id" :value="__('Magazzino')" />
                                    <select name="warehouse_id"
                                        class="form-control w-full rounded bg-yellow-50 dark:bg-transparent dark:text-white mt-1"
                                        required disabled>
                                        @foreach (App\Models\Warehouse::all() as $warehouse_item)
                                            <option value="{{ $warehouse_item->id }}"
                                                {{ $warehouse_item->id == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse_item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="pb-3">
                                    <div class="flex space-x-1 items-baseline">
                                        <x-input-label for="package" :value="__('Confezioni')" />
                                    </div>
                                    <x-text-input id="package" class="block mt-1 w-full text-right bg-yellow-50"
                                        type="text" name="package" :value="old('package', $product->package)" disabled required />
                                    <x-input-error :messages="$errors->get('package')" class="mt-2" />
                                </div> --}}

                                <div class="pb-3">
                                    <div class="flex space-x-1 items-baseline">
                                        <x-input-label for="quantity" :value="__('Quantità')" />
                                        @if (strlen($product->unit_of_measure))
                                            <div class="font-medium text-sm text-gray-700 dark:text-gray-300">
                                                ({{ $product->unit_of_measure }})
                                            </div>
                                        @endif
                                    </div>

                                    <x-text-input id="quantity" class="block mt-1 w-full text-right bg-yellow-50" min="{{ $product->refillQuantity($warehouse->id) }}"
                                        type="number" name="quantity" :value="old('quantity', $product->refillQuantity($warehouse->id))" required />
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />

                                    <div class="flex space-x-1 items-baseline justify-center text-xs pt-1 text-gray-700 dark:text-gray-300">
                                        <div>
                                            Pezzi per confezione:
                                            {{ $product->pieces_in_package }}
                                        </div>
                                    </div>
                                </div>

                                <x-primary-button class="w-full justify-center">
                                    {{ __('Ordina') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </section>


    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var data = @json($ordersTrend); // Converte l'array PHP in un oggetto JavaScript

        var years = Object.keys(data); // Dati asse X
        var values = Object.values(data); // Dati asse Y

        var chart = new Chart(ctx, {
            type: 'bar',
            responsive: true,
            data: {
                labels: years,
                datasets: [{
                    label: 'Ordinati',
                    data: values,
                    backgroundColor: '#dc2626', // Colore delle barre
                    borderRadius: 10, // Imposta il raggio desiderato per arrotondare gli angoli delle barre
                    barThickness: 10 // Imposta la larghezza desiderata delle barre
                }]
            },
            options: {
                scales: {
                    y: {
                        display: false, // Imposta a "false" per nascondere l'asse Y
                    },
                    x: {
                        grid: {
                            display: false // Imposta a "false" per nascondere la griglia sull'asse X
                        },
                        ticks: {
                            display: true, // Imposta a "false" per nascondere i testi sull'asse X
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Imposta a "false" per nascondere la legenda
                    }
                }
            }
        });
    </script>

</x-app-layout>
