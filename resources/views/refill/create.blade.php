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
        <div class="w-full max-w-7xl mx-auto ">
            <div>
                <div class=" text-gray-900 text-xl p-3 font-semibold">
                    Aggiungi al materiale in esaurimento
                </div>
            </div>
            <div
                class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800 p-8">

                <div class="pb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xl font-medium text-gray-800">
                                {{ $warehouse->name }}
                            </div>
                            <div class="text-md font-medium text-gray-400">
                                {{ $warehouse->description }}
                            </div>
                        </div>
                        <div class="uppercase">
                            <x-primary-button>
                                <a href="{{ route('warehouse.index') }}">
                                    Cambia
                                </a>
                            </x-primary-button>
                        </div>
                    </div>
                </div>

                <div id="reader-container" class=" ">
                    <div id="qr-reader" class="">
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between gap-4">
                    <div class=" text-sm text-gray-500">
                        Inquadra con la camera il codice del prodotto da inserire tra i materiali in esaurimento.
                    </div>
                </div>
            </div>


            <div
                class="mt-4 w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px-8 dark:bg-gray-900 dark:border-gray-800 p-8">
                <form method="post" action="{{ route('warehouse.refill.store', $warehouse) }}" class="p-6">
                    @csrf

                    <div class="flex items-center">
                        <div class="flex-0">
                            {{ __('Codice prodotto') }}
                        </div>

                        <x-text-input id="codes" class="block mx-3 flex-1" type="text" name="codes" />

                        <x-input-error :messages="$errors->get('codes')" class="" />
                        <x-primary-button>
                            Richiedi
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4">
                <div class="flex items-center justify-between gap-4">
                    <div class=" text-sm text-gray-500">
                        Oppure inserisci manualmente il codice del prodotto da inserire tra i materiali in esaurimento.
                    </div>
                </div>
            </div>
        </div>

        <script>
            const html5QrCode = new Html5Qrcode("qr-reader", {
                formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.EAN_8
                ]
            });
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                // console.log(`Scan result: ${decodedText}`, decodedResult);
                // html5QrcodeScanner.clear();

                window.location.href = '{{ url('warehouse/' . $warehouse->id . '/refill/request') }}?code=' + decodedText;
            };

            let config = {
                fps: 10,
                qrbox: {
                    width: 800,
                    height: 200
                },
            };

            html5QrCode.start({
                facingMode: {
                    exact: "environment"
                }
            }, config, qrCodeSuccessCallback);
        </script>

    </section>
</x-app-layout>
