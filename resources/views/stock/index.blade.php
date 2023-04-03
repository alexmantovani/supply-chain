<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stato magazzino') }}
        </h2>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8">

                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full ">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2 whitespace-nowrap w-20">
                                        <div class="font-semibold text-center">Id</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Prodotto</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Quantità</div>
                                    </th>
                                    <th class="p-2 w-40">
                                        <div class="font-semibold">Stato</div>
                                    </th>

                                    <th class="p-2 w-30 text-center items-center">
                                        <div class="font-semibold">Azioni</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>
                                            <div class="text-center">
                                                {{ $stock->product->id }}
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class=" items-center">
                                                {{-- <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img
                                                class="rounded-full"
                                                src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg"
                                                width="40" height="40" alt="Alex Shatov"></div> --}}
                                                <div class="font-medium text-gray-800 text-lg">
                                                    {{ $stock->product->name }}
                                                </div>
                                                <div class="font-medium text-gray-400">
                                                    {{ $stock->product->dealer->name }}
                                                </div>
                                            </div>


                                            {{-- <div class="flex items-center">
                                                <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img
                                                        class="rounded-full"
                                                        src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg"
                                                        width="40" height="40" alt="Alex Shatov"></div>
                                                <div class="font-medium text-gray-800">
                                                    {{ $stock->product->name }}
                                                </div>
                                            </div> --}}
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ $stock->quantity }}
                                            </div>
                                        </td>
                                        <td class="p-2 ">
                                            <div
                                                class="text-center font-medium uppercase rounded-lg py-2 px-3 text-xs {!! $stock->status_color !!}">
                                                {!! $stock->status !!}
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div>
                                                <a href="{{ route('stock.pickup', $stock) }}"
                                                class="text-xs uppercase p-2 border rounded-lg border-gray-500 text-gray-500">

                                                Preleva
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
