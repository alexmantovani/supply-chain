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
                @include('admin.sidebar', ['active' => 'users'])

                <div class="mt-5">
                    <div class="flex justify-between items-center p-2 md:p-0">
                        <div class=" text-gray-900 dark:text-gray-300 text-xl py-3 font-semibold">
                            Elenco utenti
                        </div>
                        {{-- <div class="">
                            <x-secondary-button>
                                <i class="fa-solid fa-plus"></i> &nbsp; Nuovo utente
                            </x-secondary-button>
                        </div> --}}
                    </div>


                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 mt-2 md:p-4 dark:bg-gray-900 dark:border-gray-800">

                        <div class="md:p-1">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full ">
                                    <thead
                                        class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="p-2 whitespace-nowrap">
                                                <div class="font-semibold text-left">Utente</div>
                                            </th>
                                            @foreach ($roles as $role)
                                                <th class="p-2 ">
                                                    <div class="font-semibold text-center">{{ $role->name }}</div>
                                                </th>
                                            @endforeach
                                            <th class="p-2 ">
                                                <div class="font-semibold text-left">Magazzino di riferimento</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                        @foreach ($users as $user)
                                            @livewire('user-update-row', ['user' => $user, 'roles' => $roles])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
