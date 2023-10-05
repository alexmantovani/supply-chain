<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div class="
      font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
    cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div>
                <a href="{{ url('admin') }}">
                    <div class="text-gray-900 dark:text-gray-100">
                        Pannello di amministrazione
                    </div>
                </a>
            </div>
        </div>
    </x-slot>

    <x-slot name="navbar_right_menu">

    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="flex justify-between items-center">
                    <div class="text-xl font-medium">
                        Gestione magazzini
                    </div>
                    <div>
                        <a href="{{ route('warehouse.create') }}">
                            <x-secondary-button class="">
                                <i class="fa-solid fa-plus"></i> &nbsp; Nuovo magazzino
                            </x-secondary-button>
                        </a>
                    </div>
                </div>

                <div class="py-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full my-3">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Nome</div>
                                    </th>
                                    <th class="p-2 ">
                                        <div class="font-semibold text-left">Descrizione</div>
                                    </th>
                                    <th class="p-2 ">
                                        <div class="font-semibold text-left">Email</div>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 items-center">
                                @foreach ($warehouses as $warehouse)
                                    <tr class="">
                                        <td class="p-2">
                                            <x-product-name-cell class="text-lg">
                                                {{ $warehouse->name }}
                                            </x-product-name-cell>
                                        </td>
                                        <td class="p-2">
                                            {{ $warehouse->description }}
                                        </td>
                                        <td class="p-2">
                                            {{ $warehouse->emails }}
                                        </td>
                                        <td class="p-2 w-10 text-center items-center">
                                            <a href="{{ route('warehouse.edit', $warehouse->id) }}"
                                                class="text-gray-600 hover:text-gray-600">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
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
