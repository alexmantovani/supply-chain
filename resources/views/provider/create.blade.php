<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div
                class="
              font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
            cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div class="text-gray-800 dark:text-gray-200">
                Nuovo fornitore
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_left_menu">

    </x-slot>


    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="w-full max-w-7xl mx-auto ">

            <form method="post" action="{{ route('provider.store') }}" class="" enctype="multipart/form-data">
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
                        <x-input-label for="emails" :value="__('Email')" />
                        <x-text-input id="emails" class="block mt-1 w-full" type="text" name="emails"
                            title="Inserisci una o più email separate da una virgola" :value="old('emails')" />
                        <x-input-error class="mt-2" :messages="$errors->get('emails')" />
                    </div>

                    <div class="">
                        <x-input-label for="provider_code" :value="__('Codice fornitore')" />
                        <x-text-input id="provider_code" class="block mt-1 w-full" type="text" name="provider_code"
                            :value="old('provider_code')" />
                        <x-input-error class="mt-2" :messages="$errors->get('provider_code')" />
                    </div>

                    <div class="flex items-center space-x-6">
                        <x-input-label for="image" :value="__('Logo del fornitore')" />

                        <div class="shrink-0">
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="image"
                                class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-8 file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100" />
                        </label>
                    </div>
                </div>

                <div class="my-4 flex justify-end px-8">
                    <x-primary-button>{{ __('Salva') }}</x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
