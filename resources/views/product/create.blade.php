<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex">
                <div class="pr-3 text-lg cursor-pointer">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Aggiungi prodotto al listino di') }} {{ $dealer->name }}
                </h2>
            </div>

        </div>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4">

        <div class="w-full max-w-xl mx-auto ">

            <form method="POST" action="{{ route('product.store') }}">
                @csrf
                <input type="hidden" name="dealer_id" value="{{ $dealer->id }}" />

                <div class="pb-3">
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="pb-3">
                    <x-input-label for="description" :value="__('Descrizione')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')"/>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="pb-3">
                    <x-input-label for="note" :value="__('Note')" />
                    <x-text-input id="note" class="block mt-1 w-full" type="text" name="note" :value="old('note')"/>
                    <x-input-error :messages="$errors->get('note')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-3">
                    <x-primary-button class="">{{ __('Salva') }}</x-primary-button>
                </div>
            </form>


        </div>
    </section>

</x-app-layout>
