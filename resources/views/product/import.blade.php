<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex">
                <div class="pr-3 text-lg cursor-pointer">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $dealer->name }}
                    <span class=" text-gray-400 font-normal">
                        &nbsp;|&nbsp; {{ __('Importa articoli') }}
                    </span>
                </h2>
            </div>

        </div>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4">

        <div class="w-full max-w-xl mx-auto ">

            <form method="POST" action="{{ route('product.import', $dealer) }}" enctype="multipart/form-data">
                @csrf

                <div class="row p-4 d-flex justify-content-around">
                    <label for="file_csv" class="custom-file-upload">
                        <i class="fa fa-upload"></i> &nbsp; Seleziona file CSV contenente gli articoli
                    </label>
                    <input type="file" id="file_csv" name="file_csv"
                        @error('file_csv') is-invalid @enderror />
                </div>

                <div class="flex justify-end mt-3">
                    <x-primary-button class="">{{ __('Salva') }}</x-primary-button>
                </div>
            </form>

        </div>
    </section>

</x-app-layout>
