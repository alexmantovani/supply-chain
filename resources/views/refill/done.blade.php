<x-app-layout>

    <x-slot name="navbar_right_menu">
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="antialiased bg-gray-100 dark:bg-gray-900 dark:text-gray-400 text-gray-600 min-h-screen p-4">
        <div class="py-20">
            @if (count($errors))
                <div class="flex justify-center text-yellow-400 py-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-40 h-40">
                        <path fill-rule="evenodd"
                            d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                            clip-rule="evenodd" />
                    </svg>

                </div>


                <div class="flex justify-center text-4xl dark:text-gray-200">
                    La tua richiesta contiene errori:
                </div>

                <div class="text-center text-lg text-gray-400 dark:text-gray-500 uppercase py-5 font-semibold">
                    @foreach ($errors as $error)
                        <div>
                            {{ $error['error'] }}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex justify-center text-green-500 py-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-40 h-40">
                        <path fill-rule="evenodd"
                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="text-center text-4xl pt-10">
                    La tua richiesta è stata inserita
                </div>
            @endif
        </div>

        <div class="text-center">
            <a href="{{ route('warehouse.refill.create', $warehouse) }}"
                class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <i class="fa-solid fa-plus" title="Aggiungi tra i materiali in esaurimento"></i>&nbsp;
                {{ __('Richiedi altro matriale') }}
            </a>
        </div>

    </section>

</x-app-layout>
