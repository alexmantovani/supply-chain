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
                Modifica magazzino
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_left_menu">

    </x-slot>


    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="w-full max-w-7xl mx-auto ">
            <div class="flex justify-between items-center">
                <div class=" text-gray-500 dark:text-gray-600 text-xl p-3 ">
                    Modifica
                    <span class="text-gray-900 dark:text-gray-300 font-semibold">
                        {{ $warehouse->name }}
                    </span>
                </div>

                @can('delete warehouse')
                    @include('warehouse.partials.delete-warehouse-button')
                @endcan

            </div>

            <form method="post" action="{{ route('warehouse.update', $warehouse) }}" class="">
                @csrf
                @method('patch')

                <div
                    class="mt-4 w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200  dark:bg-gray-900 dark:border-gray-800 p-4 md:p-8 space-y-4">

                    <div class="">
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $warehouse->name)" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="">
                        <x-input-label for="description" :value="__('Descrizione')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                            :value="old('description', $warehouse->description)" />
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="">
                        <x-input-label for="emails" :value="__('Emails')" />
                        <x-text-input id="emails" class="block mt-1 w-full" type="text" name="emails"
                            title="Inserisci una o più email separate da una virgola" :value="old('emails', $warehouse->emails)" />
                        <x-input-error class="mt-2" :messages="$errors->get('email_array.*')" />
                    </div>

                    <div class="">
                        <x-input-label for="fallback_emails" :value="__('Email per ordini senza fornitore')" />
                        <x-text-input id="fallback_emails" class="block mt-1 w-full" type="text" name="fallback_emails"
                            title="Inserisci una o più email separate da una virgola" :value="old('fallback_emails', $warehouse->fallback_emails)" />
                        <x-input-error class="mt-2" :messages="$errors->get('email_array.*')" />
                            <div class="text-xs text-gray-600 py-2">
                                Nel caso di ordini in cui nel prodotto ordinato non sia presente il fornitore, l'ordine verrà inviato a questo indirizzo email.
                            </div>
                    </div>
                </div>

                <div class="my-4 flex justify-end px-8">
                    <x-primary-button>{{ __('Salva') }}</x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
