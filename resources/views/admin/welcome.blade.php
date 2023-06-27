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
        <div class="grid grid-cols-4 gap-4 h-full">

            <a href="{{ url('admin/users') }}">
                <div
                    class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">
                    <div class="flex justify-between">
                        <div class=" text-4xl">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-medium">
                                Gestione utenti
                            </div>
                            <div class=" text-red-400 text-md">
                                Totale utenti: {{ App\Models\User::all()->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ url('/admin/provider') }}">
                <div
                    class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">
                    <div class="flex justify-between">
                        <div class=" text-4xl">
                            <i class="fa-solid fa-warehouse"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-medium">
                                Gestione fornitori
                            </div>
                            <div class=" text-red-400 text-md">
                                Totale fornitori: {{ App\Models\Provider::all()->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{ url('/admin/dealer') }}">
                <div
                    class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 md:p-8 dark:bg-gray-900 dark:border-gray-800">
                    <div class="flex justify-between">
                        <div class=" text-4xl">
                            <i class="fa-solid fa-industry"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-medium">
                                Gestione produttori
                            </div>
                            <div class=" text-red-400 text-md">
                                Totale produttori: {{ App\Models\Dealer::all()->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>

</x-app-layout>
