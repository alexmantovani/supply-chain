<x-app-layout>
    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="w-full max-w-7xl mx-auto ">
            <div class="flex justify-between items-center">
                <div class=" text-gray-500 dark:text-gray-600 text-xl p-3 ">
                    Fornitore
                    <span class="text-gray-900 dark:text-gray-300 font-semibold">
                        {{ $provider->name }}
                    </span>
                </div>

                @include('provider.partials.delete-button')
            </div>

            <form method="post" action="{{ route('provider.update', $provider) }}" class="">
                @csrf
                @method('patch')

                <div
                    class="mt-4 w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200  dark:bg-gray-900 dark:border-gray-800 p-4 md:p-8 space-y-4">

                    <div class="">
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $provider->name)" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="">
                        <x-input-label for="description" :value="__('Descrizione')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                            :value="old('description', $provider->description)" />
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                            :value="old('email', $provider->email)" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>

                <div class="my-4 flex justify-end px-8">
                    <x-primary-button>{{ __('Salva') }}</x-primary-button>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>