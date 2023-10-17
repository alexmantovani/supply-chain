<x-app-layout>

    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
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
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-800">
        <div class="h-full w-full max-w-7xl mx-auto ">
            <div class="">
                @include('admin.sidebar', ['active' => 'warehouses'])

                <div class="mt-5">
                    <div class="flex justify-between items-center p-2 md:p-0">
                        <div class=" text-gray-900 dark:text-gray-300 text-xl py-3 font-semibold">
                            Gestione magazzini
                        </div>
                        @can('create warehouse')
                            <div>
                                <a href="{{ route('warehouse.create') }}">
                                    <x-secondary-button class="">
                                        <i class="fa-solid fa-plus"></i> &nbsp; Nuovo magazzino
                                    </x-secondary-button>
                                </a>
                            </div>
                        @endcan
                    </div>

                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 mt-2 md:p-4 dark:bg-gray-900 dark:border-gray-800">
                        <div class="md:p-1">

                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <thead
                                        class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="p-2 whitespace-nowrap">
                                                <div class="font-semibold text-left">Nome</div>
                                            </th>
                                            <th class="p-2 hidden md:table-cell">
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
                                                <td class="p-2 hidden md:table-cell">
                                                    {{ $warehouse->description }}
                                                </td>
                                                <td class="p-2">
                                                    {{ $warehouse->emails }}
                                                </td>
                                                <td class="p-2 w-10 text-center items-center">
                                                    @can('edit warehouse')
                                                        <a href="{{ route('warehouse.edit', $warehouse->id) }}"
                                                            class="text-gray-600 hover:text-gray-600">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</x-app-layout>
