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

                <div id="reader-container">
                    <div id="qr-reader" style="position: relative; padding: 0px;">
                        {{-- <div style="text-align: left; margin: 0px;">
                            <div id="reader__header_message"
                                style="display: none; text-align: center; font-size: 14px; padding: 2px 10px; margin: 4px; border-top-width: 1px; border-top-style: solid; border-top-color: rgb(246, 246, 246); background-color: rgba(0, 0, 0, 0); color: rgb(17, 17, 17);">
                                Richiedi permessi per utilizzare fotocamera...</div>
                        </div> --}}

                        {{-- <div id="reader__dashboard" style="width: 100%;">
                            <div id="reader__dashboard_section"
                                style="width: 100%; padding: 10px 0px; text-align: left;"> --}}
                        {{-- <div>
                                    <div id="reader__dashboard_section_csr"
                                        style="display: block; margin-bottom: 20px; text-align: center;">
                                        <div style="display: none; padding: 5px 10px; text-align: center;"><input
                                                id="html5-qrcode-input-range-zoom" class="html5-qrcode-element"
                                                type="range" min="1" max="5" step="0.1"
                                                style="display: inline-block; width: 50%; height: 5px; background-color: rgb(211, 211, 211); outline: none; opacity: 0.7;"><span
                                                style="margin-right: 10px;">1x zoom</span></div><span
                                            style="margin-right: 10px; display: none;"><select
                                                id="html5-qrcode-select-camera" class="html5-qrcode-element">
                                                <option value="63F300FC6FAA8BEDE35BDF710A9E91D932290302">Fotocamera HD
                                                    FaceTime</option>
                                            </select></span><span><button id="html5-qrcode-button-camera-start"
                                                class="html5-qrcode-element" type="button"
                                                style="opacity: 1; display: inline-block;">Start
                                                Scanning</button><button id="html5-qrcode-button-camera-stop"
                                                class="html5-qrcode-element" type="button" disabled=""
                                                style="display: none;">Stop
                                                Scanning</button></span>
                                    </div>
                                    <div
                                        style="text-align: center; margin: auto auto 10px; width: 80%; max-width: 600px; border: 6px dashed rgb(235, 235, 235); padding: 10px; display: none;">
                                        <label for="html5-qrcode-private-filescan-input"
                                            style="display: inline-block;"><button
                                                id="html5-qrcode-button-file-selection" class="html5-qrcode-element"
                                                type="button">Choose Image - No image
                                                choosen</button><input id="html5-qrcode-private-filescan-input"
                                                class="html5-qrcode-element" type="file" accept="image/*"
                                                style="display: none;"></label>
                                        <div style="font-weight: 400;">Or drop an image to scan</div>
                                    </div>
                                </div> --}}
                        {{-- <div style="text-align: center;"><span id="html5-qrcode-anchor-scan-type-change"
                                        class="html5-qrcode-element"
                                        style="text-decoration: underline; cursor: pointer; display: inline-block;">Scan
                                        an
                                        Image File</span></div> --}}
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

                        <x-text-input id="code_text" class="block mx-3 flex-1" type="text" name="code_text" />

                        <x-input-error :messages="$errors->get('code_text')" class="" />
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
            let ware = document.getElementById('warehouse_select');

            function onScanSuccess(decodedText, decodedResult) {
                // console.log('Warehouse= ' + ware.value + '  ' + ware.text);
                // console.log(`Code scanned aaa= ${decodedText} ${warehouse_select}.val()`, ware );
                window.location.href = '{{ url('warehouse/' . $warehouse->id . '/refill/request') }}/' + decodedText;
            }
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250,
                    rememberLastUsedCamera: true
                });
            html5QrcodeScanner.render(onScanSuccess);
        </script>
    </section>

</x-app-layout>
