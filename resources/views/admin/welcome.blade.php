<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div class="
      font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
    cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div>
                <div class="text-gray-900 dark:text-gray-100">
                    Pannello di amministrazione
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="navbar_right_menu">
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full space-y-4">
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">
                <div class="text-xl">
                    <a href="{{ url('admin/users') }}">
                        Gestione utenti
                    </a>
                </div>
            </div>
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">

                <div class="text-xl">
                    <a href="{{ url('/admin/provider') }}">
                        Gestione fornitori
                    </a>
                </div>

            </div>
            <div
            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">

            <div class="text-xl">
                <a href="{{ url('/admin/dealer') }}">
                    Gestione produttori
                </a>
            </div>

        </div>
        </div>
    </section>

</x-app-layout>
