<x-app-layout>
    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="flex justify-between items-center">
                    <div class="text-xl font-medium">
                        Gestione produttori
                    </div>
                    <div>
                        <a href="{{ route('dealer.create') }}">
                            <x-secondary-button class="">
                                <i class="fa-solid fa-plus"></i> &nbsp; Nuovo produttore
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
                                        <div class="font-semibold text-left">Produttore</div>
                                    </th>
                                    <th class="p-2 ">
                                        <div class="font-semibold text-left">Materiale fornito da</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 items-center">
                                @foreach ($dealers as $dealer)
                                    @livewire('dealer-update-row', ['dealer' => $dealer, 'providers' => $providers])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-app-layout>
