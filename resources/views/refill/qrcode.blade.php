<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Simulazione esaurimento prodotto') }}
            </h2>
            <div>
                {{ $product->name }}
            </div>
        </div>
    </x-slot>

    <section class="antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="flex justify-center">

            <div class="h-full py-20">
                {!! QrCode::size(200)->generate('refill/ask?product_id='.$product->id.'&quantity=6') !!}
            </div>
        </div>
        <div class="text-center text-gray-500">
            Inquadra il QR qui sopra per segnalare la richiesta di
            <span class=" text-gray-900 font-semibold">
                {{ $product->name }}
            </span>
        </div>
        <div class="text-center text-gray-500">
            oppure premi
            <a href="{{ url('refill/ask?product_id=' . $product->id .'&quantity=6') }}" class="font-semibold text-gray-900 hover:underline"
            >qui
        </a>
        </div>
    </section>

</x-app-layout>
