<x-app-layout>
    <x-slot name="navbar_title">
        <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
            {{ $warehouse->name }}
        </x-navbar-title>
    </x-slot>
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar')
    </x-slot>
    <x-slot name="navbar_right_menu">
        <x-nav-link :href="route('warehouse.refill.simulate', $warehouse->id)" :active="request()->routeIs('warehouse.refill.simulate')">
            {{ __('Simula QR') }}
        </x-nav-link>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div
            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800 p-8">

            {{-- <div class=" text-gray-900 text-xl font-semibold text-center items-center">
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
            </div> --}}

            {{-- <div class="flex justify-center">
                <div class="h-full p-10 m-10 dark:bg-gray-100 rounded-xl">
                    {!! QrCode::size(200)->generate(url('api/warehouse/' . $warehouse->id . '/refill/' . $product->uuid)) !!}
                </div>
            </div> --}}

            <div class="h-full p-10 m-10 dark:bg-gray-100 rounded-xl">
                <div id="qr-reader" style="width: 600px"></div>
            </div>
            <script>
                function onScanSuccess(decodedText, decodedResult) {
                    console.log(`Code scanned = ${decodedText}`, decodedResult);
                }
                var html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: 250
                    });
                html5QrcodeScanner.render(onScanSuccess);
            </script>

            <div class="text-center text-gray-500 dark:text-gray-400">
                Inquadra il QR qui sopra per richiedere questo prodotto oppure premi
                {{-- <a href="{{ url('api/warehouse/' . $warehouse->id . '/refill/' . $product->uuid) }}"
                    class="font-semibold text-gray-900 dark:text-gray-200 hover:underline">qui
                </a> --}}
            </div>
        </div>
    </section>

</x-app-layout>
