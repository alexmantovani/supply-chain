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
                <div>
                    <div class="md:px-5">
                        <div class=" text-gray-400 text-xl font-semibold">
                            Produttore
                        </div>

                        <div class=" ">
                            <div class="pb-6">
                                <div class="font-semibold text-lg py-4 dark:text-gray-200">
                                    <a href="{{ route('warehouse.dealer.show', [$warehouse, $product->dealer->id]) }}"
                                        class=" cursor-pointer hover:underline">
                                        {{ $product->dealer->name }}
                                    </a>
                                </div>
                                <div class="mt-1 dark:text-gray-400 text-sm text-gray-500">
                                    <div class="flex justify-between">
                                        <div>
                                            Codice produttore:
                                        </div>
                                        <span class=" text-gray-800 font-semibold">
                                            {{ $product->dealer->code }}
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
                </div>

                <div class="border-t-2 md:border-t-0 md:border-l-2 border-gray-200 border-dotted">
                    <div class="md:px-5 pt-5 md:pt-0">
                        <div class=" text-gray-400 text-xl font-semibold">
                            Fornitore
                        </div>

                        <div class="">
                            <div class="pb-6">

                                <div class="font-semibold text-xl pt-4 dark:text-gray-200">
                                    {{ $product->dealer->provider->name }}
                                </div>
                                <div class="mt-1 dark:text-gray-400 text-sm text-gray-500">
                                    <a href="mailto:{{ $product->dealer->provider->email }}">
                                        <i class="fa-regular fa-envelope"></i>
                                        <span>
                                            {{ $product->dealer->provider->email }}
                                        </span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="md:flex mt-5 mx-2">
                <div
                    class="flex-1 md:bg-white md:shadow-lg md:rounded-sm md:border border-gray-200 md:px-8 py-8 dark:bg-gray-900 dark:border-gray-700">
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
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Identificativo</div>
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
                                            <x-product-arrived :arrived="$order->pivot->received_quantity"
                                                status="{{ $order->status }}"
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
                                        <td class="p-1 text-center">
                                            <x-product-name-cell class="" :href="route('warehouse.order.show', [$warehouse, $order])">
                                                {{ $order->uuid }}
                                            </x-product-name-cell>
                                        </td>
                                        <td
                                            class="p-1 font-sm md:text-md text-gray-600 dark:text-gray-300 whitespace-nowrap hidden md:table-cell">
                                            <x-product-name-cell class="">
                                                {{ $order->warehouse->name }}
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
                                                <x-order-status
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
                                <select name="warehouse_id" class="form-control w-full rounded bg-yellow-50 mt-1"
                                    required>
                                    @foreach (App\Models\Warehouse::all() as $warehouse_item)
                                        <option value="{{ $warehouse_item->id }}"
                                            {{ $warehouse_item->id == $warehouse->id ? 'selected' : '' }}>
                                            {{ $warehouse_item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pb-3">
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" class="block mt-1 w-full text-right bg-yellow-50"
                                    type="number" name="quantity" :value="old('quantity')" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <x-primary-button class="w-full justify-center">
                                {{ __('Ordina') }}
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>
