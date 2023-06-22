<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div
                class="
              font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
            cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div>
                Nuovo magazzino
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_left_menu">

    </x-slot>


    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="w-full max-w-7xl mx-auto ">
            <div>
                <div class=" text-gray-900 dark:text-gray-300 text-xl p-3 font-semibold">
                    Crea nuovo magazzino
                </div>
            </div>

            <form method="post" action="{{ route('warehouse.store') }}" class="">
                @csrf
                <div
                    class="mt-4 w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200  dark:bg-gray-900 dark:border-gray-800 p-4 md:p-8 space-y-4">

                    <div class="">
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name')" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="">
                        <x-input-label for="description" :value="__('Descrizione')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                            :value="old('description')" />
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="">
                        <x-input-label for="emails" :value="__('Emails')" />
                        <x-text-input id="emails" class="block mt-1 w-full" type="text" name="emails"
                            :value="old('emails')" />
                        <x-input-error class="mt-2" :messages="$errors->get('email_array.*')" />
                    </div>
                </div>

                <div class="mt-4 flex justify-end px-8">
                    <x-primary-button>{{ __('Salva') }}</x-primary-button>
                </div>
            </form>
        </div>

    </section>
</x-app-layout>
