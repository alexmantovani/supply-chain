<x-app-layout>
    <x-slot name="navbar_left_menu">
    </x-slot>

    <x-slot name="navbar_right_menu">
        @can('create warehouse')
            <a href="{{ route('warehouse.create') }}">
                <x-secondary-button class="">
                    <i class="fa-solid fa-plus"></i> &nbsp; Magazzino
                </x-secondary-button>
            </a>
        @endcan
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:px-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full ">
                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td class="p-2 ">
                                            <div class=" items-center">
                                                <a href="{{ route('warehouse.show', $warehouse->id) }}">
                                                    <div
                                                        class="flex justify-between items-center font-medium text-gray-800 text-lg dark:text-gray-300">
                                                        {{-- <a href="{{ route('product.show', $stock->product) }}"
                                                        class=" hover:underline"> --}}
                                                        {{ $warehouse->name }}
                                                    </div>
                                                </a>
                                                <div class=" text-sm text-gray-400">
                                                    {{ $warehouse->description }}
                                                </div>

                                            </div>
                                        </td>

                                        @can('edit warehouse')
                                            <td class="p-2 w-10 text-center items-center">
                                                <a href="{{ route('warehouse.edit', $warehouse->id) }}"
                                                    class="font-medium text-gray-400 hover:text-gray-800 text-lg">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            </td>
                                        @endcan

                                        @can('change warehouse')
                                            <td class="p-2 w-20 text-center items-center">
                                                <a href="{{ route('warehouse.show', $warehouse->id) }}"
                                                    class="font-medium text-gray-400 hover:text-gray-800 hover:underline">
                                                    <x-primary-button class="ml-3">
                                                        {{ __('Entra') }}
                                                    </x-primary-button>
                                                </a>
                                            </td>
                                        @endcan

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
