<x-app-layout>
    <x-slot name="navbar_right_menu">
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full w-full max-w-7xl mx-auto ">
            <div class="flex justify-between items-center">
                <div class=" text-gray-900 dark:text-gray-300 text-xl py-3 font-semibold">
                    Elenco utenti
                </div>
                <div class="">
                    <a href="{{ route('invite.create') }}">
                        <x-secondary-button title="Potrai invitare altri tuoi colleghi ad utilizzare ReFiller">
                            Invita utente
                        </x-secondary-button>
                    </a>
                </div>
            </div>


            <div
                class="bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full ">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">Utente</div>
                                    </th>
                                    @foreach ($roles as $role)
                                        @if ($role->name == 'super-admin')
                                            @continue
                                        @endif

                                        <th class="p-2 ">
                                            <div class="font-semibold text-center">{{ $role->name }}</div>
                                        </th>
                                    @endforeach
                                    <th class="p-2 ">
                                        <div class="font-semibold text-left">Magazzino di riferimento</div>
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($users as $user)
                                    @livewire('user-update-row', ['user' => $user, 'roles' => $roles, 'company' => $company, 'warehouses' => $warehouses])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-app-layout>