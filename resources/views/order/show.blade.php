<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <div class="pr-3 text-lg cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dettaglio ordine') }} # {{ $order->id }}
            </h2>
        </div>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8">

                    <div class="flex justify-between m-5">
                        <div class="pb-6">
                            <div class="font-semibold text-2xl pt-4">
                                {{ $order->dealer->name }}
                            </div>
                            <div class="mt-4">
                                {{ $order->dealer->address }}
                                <p>
                                    {{ $order->dealer->zip }}
                                    {{ $order->dealer->city }}
                                </p>
                            </div>
                        </div>

                        <div class="my-4">
                            <div class=" text-center bg-red-600 text-white rounded-lg text-xs uppercase py-2 px-3">
                                {{ $order->status }}
                            </div>
                            {{-- <div class=" text-gray-400">
                                {{ $order->created_at }}
                            </div> --}}
                        </div>

                    </div>




                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap w-20">
                                    <div class="font-semibold text-center">Id</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left px-3">Articolo</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Quantità</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm divide-y divide-gray-100">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="p-3 text-center">
                                            {{ $product->id }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="p-3">
                                            {{ $product->name }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap">
                                        <div class="text-center">
                                            {{ $product->pivot->quantity }}
                                            @php
                                                $total += $product->pivot->quantity;
                                            @endphp
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class=" font-semibold text-gray-800">
                                <td class="p-2 whitespace-nowrap">
                                    <div class="p-3">
                                        Totale
                                    </div>
                                </td>
                                <td></td>
                                <td class="p-2 whitespace-nowrap ">
                                    <div class="text-center">
                                        {{ $total }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>

</x-app-layout>
