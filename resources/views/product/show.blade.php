<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex">
                <div class="pr-3 text-lg cursor-pointer text-gray-800 dark:text-gray-200">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dettaglio prodotto') }} # {{ $product->id }}
                </h2>
            </div>


        </div>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">

        <div class="w-full max-w-7xl mx-auto ">

            <div class="grid grid-cols-2 gap-4">

                <div class="">
                    <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-700">

                        <div class="m-5">
                            <div class="pb-6">
                                <div class="font-semibold text-2xl pt-4 dark:text-gray-200">
                                    {{ $product->name }}
                                </div>
                                <div class="mt-1 dark:text-gray-400">
                                    {{ $product->dealer->name }}
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="pt-4 flex justify-between">
                        <x-primary-button class="mx-4">
                            {{ __('Elimina da listino') }}
                        </x-primary-button>
                        <x-primary-button class="mx-4">
                            {{ __('Ordina') }}
                        </x-primary-button>

                    </div>

                </div>


                <div class="">
                    <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8 py-8 dark:bg-gray-900 dark:border-gray-700">
                            <div class="pb-6 mx-5">
                            <div class="font-semibold text-2xl dark:text-gray-200">
                                Ordini
                            </div>
                        </div>

                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-2 whitespace-nowrap w-20">
                                        <div class="font-semibold text-center">Data</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap w-20">
                                        <div class="font-semibold text-center">Ora</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Stato</div>
                                    </th>
                                </tr>
                            </thead>
                            @foreach ($product->orders as $order)
                                <tr>
                                    <td class="p-2 whitespace-nowrap text-gray-400 dark:text-gray-300 text-xs ">
                                        <div>
                                            {{ $order->created_at->translatedFormat('d.m.Y') }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-center text-gray-400 dark:text-gray-300 text-xs">
                                        <div>
                                            {{ $order->created_at->translatedFormat('H:i') }}
                                        </div>
                                    </td>
                                    <td class="p-2 whitespace-nowrap text-xs text-gray-500 dark:text-gray-300">
                                        <div>
                                            {{ $order->status }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-app-layout>
