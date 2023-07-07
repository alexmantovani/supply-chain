<x-app-layout>
    <x-slot name="warehouse_id">
        {{ $warehouse->id }}
    </x-slot>

    {{-- <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Simulazione esaurimento prodotto') }}
            </h2>
            <div class="dark:text-gray-300">
                {{ $product->name }}
            </div>
        </div>
    </x-slot> --}}

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div
            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800 p-8">

            <div class=" text-gray-900 text-xl font-semibold text-center items-center">
                <div>
                    {{ $product->name }}
                </div>
                <p class="text-gray-500 text-lg font-normal">
                    {{ $product->dealer->name }}
                </p>
                <div class="flex justify-center py-2">
                    <div>
                        <x-product-status class=" rounded-lg text-xs uppercase py-1 px-2 text-center"
                            :status="$product->status" />
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="h-full p-10 m-10 dark:bg-gray-100 rounded-xl">
                    {!! QrCode::size(200)->generate(url('warehouse/' . $warehouse->id . '/refill/request/' . $product->uuid)) !!}
                </div>
            </div>
            <div class="text-center text-gray-500 dark:text-gray-400">
                Inquadra il QR code qui sopra per richiedere questo prodotto oppure premi
                <a href="{{ url('warehouse/' . $warehouse->id . '/refill/request/' . $product->uuid) }}"
                    class="font-semibold text-gray-900 dark:text-gray-200 hover:underline">qui
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
