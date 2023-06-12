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
                        <div style="text-align: left; margin: 0px;">
                            <div id="reader__header_message"
                                style="display: none; text-align: center; font-size: 14px; padding: 2px 10px; margin: 4px; border-top-width: 1px; border-top-style: solid; border-top-color: rgb(246, 246, 246); background-color: rgba(0, 0, 0, 0); color: rgb(17, 17, 17);">
                                Requesting camera permissions...</div>
                        </div>
                        <div id="reader__scan_region"
                            style="width: 100%; min-height: 100px; text-align: center; position: relative;"><br><img
                                width="64"
                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNzEuNjQzIDM3MS42NDMiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM3MS42NDMgMzcxLjY0MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZD0iTTEwNS4wODQgMzguMjcxaDE2My43Njh2MjBIMTA1LjA4NHoiLz48cGF0aCBkPSJNMzExLjU5NiAxOTAuMTg5Yy03LjQ0MS05LjM0Ny0xOC40MDMtMTYuMjA2LTMyLjc0My0yMC41MjJWMzBjMC0xNi41NDItMTMuNDU4LTMwLTMwLTMwSDEyNS4wODRjLTE2LjU0MiAwLTMwIDEzLjQ1OC0zMCAzMHYxMjAuMTQzaC04LjI5NmMtMTYuNTQyIDAtMzAgMTMuNDU4LTMwIDMwdjEuMzMzYTI5LjgwNCAyOS44MDQgMCAwIDAgNC42MDMgMTUuOTM5Yy03LjM0IDUuNDc0LTEyLjEwMyAxNC4yMjEtMTIuMTAzIDI0LjA2MXYxLjMzM2MwIDkuODQgNC43NjMgMTguNTg3IDEyLjEwMyAyNC4wNjJhMjkuODEgMjkuODEgMCAwIDAtNC42MDMgMTUuOTM4djEuMzMzYzAgMTYuNTQyIDEzLjQ1OCAzMCAzMCAzMGg4LjMyNGMuNDI3IDExLjYzMSA3LjUwMyAyMS41ODcgMTcuNTM0IDI2LjE3Ny45MzEgMTAuNTAzIDQuMDg0IDMwLjE4NyAxNC43NjggNDUuNTM3YTkuOTg4IDkuOTg4IDAgMCAwIDguMjE2IDQuMjg4IDkuOTU4IDkuOTU4IDAgMCAwIDUuNzA0LTEuNzkzYzQuNTMzLTMuMTU1IDUuNjUtOS4zODggMi40OTUtMTMuOTIxLTYuNzk4LTkuNzY3LTkuNjAyLTIyLjYwOC0xMC43Ni0zMS40aDgyLjY4NWMuMjcyLjQxNC41NDUuODE4LjgxNSAxLjIxIDMuMTQyIDQuNTQxIDkuMzcyIDUuNjc5IDEzLjkxMyAyLjUzNCA0LjU0Mi0zLjE0MiA1LjY3Ny05LjM3MSAyLjUzNS0xMy45MTMtMTEuOTE5LTE3LjIyOS04Ljc4Ny0zNS44ODQgOS41ODEtNTcuMDEyIDMuMDY3LTIuNjUyIDEyLjMwNy0xMS43MzIgMTEuMjE3LTI0LjAzMy0uODI4LTkuMzQzLTcuMTA5LTE3LjE5NC0xOC42NjktMjMuMzM3YTkuODU3IDkuODU3IDAgMCAwLTEuMDYxLS40ODZjLS40NjYtLjE4Mi0xMS40MDMtNC41NzktOS43NDEtMTUuNzA2IDEuMDA3LTYuNzM3IDE0Ljc2OC04LjI3MyAyMy43NjYtNy42NjYgMjMuMTU2IDEuNTY5IDM5LjY5OCA3LjgwMyA0Ny44MzYgMTguMDI2IDUuNzUyIDcuMjI1IDcuNjA3IDE2LjYyMyA1LjY3MyAyOC43MzMtLjQxMyAyLjU4NS0uODI0IDUuMjQxLTEuMjQ1IDcuOTU5LTUuNzU2IDM3LjE5NC0xMi45MTkgODMuNDgzLTQ5Ljg3IDExNC42NjEtNC4yMjEgMy41NjEtNC43NTYgOS44Ny0xLjE5NCAxNC4wOTJhOS45OCA5Ljk4IDAgMCAwIDcuNjQ4IDMuNTUxIDkuOTU1IDkuOTU1IDAgMCAwIDYuNDQ0LTIuMzU4YzQyLjY3Mi0zNi4wMDUgNTAuODAyLTg4LjUzMyA1Ni43MzctMTI2Ljg4OC40MTUtMi42ODQuODIxLTUuMzA5IDEuMjI5LTcuODYzIDIuODM0LTE3LjcyMS0uNDU1LTMyLjY0MS05Ljc3Mi00NC4zNDV6bS0yMzIuMzA4IDQyLjYyYy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi0xLjMzM2MwLTUuNTE0IDQuNDg2LTEwIDEwLTEwaDE1djIxLjMzM2gtMTV6bS0yLjUtNTIuNjY2YzAtNS41MTQgNC40ODYtMTAgMTAtMTBoNy41djIxLjMzM2gtNy41Yy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi0xLjMzM3ptMTcuNSA5My45OTloLTcuNWMtNS41MTQgMC0xMC00LjQ4Ni0xMC0xMHYtMS4zMzNjMC01LjUxNCA0LjQ4Ni0xMCAxMC0xMGg3LjV2MjEuMzMzem0zMC43OTYgMjguODg3Yy01LjUxNCAwLTEwLTQuNDg2LTEwLTEwdi04LjI3MWg5MS40NTdjLS44NTEgNi42NjgtLjQzNyAxMi43ODcuNzMxIDE4LjI3MWgtODIuMTg4em03OS40ODItMTEzLjY5OGMtMy4xMjQgMjAuOTA2IDEyLjQyNyAzMy4xODQgMjEuNjI1IDM3LjA0IDUuNDQxIDIuOTY4IDcuNTUxIDUuNjQ3IDcuNzAxIDcuMTg4LjIxIDIuMTUtMi41NTMgNS42ODQtNC40NzcgNy4yNTEtLjQ4Mi4zNzgtLjkyOS44LTEuMzM1IDEuMjYxLTYuOTg3IDcuOTM2LTExLjk4MiAxNS41Mi0xNS40MzIgMjIuNjg4aC05Ny41NjRWMzBjMC01LjUxNCA0LjQ4Ni0xMCAxMC0xMGgxMjMuNzY5YzUuNTE0IDAgMTAgNC40ODYgMTAgMTB2MTM1LjU3OWMtMy4wMzItLjM4MS02LjE1LS42OTQtOS4zODktLjkxNC0yNS4xNTktMS42OTQtNDIuMzcgNy43NDgtNDQuODk4IDI0LjY2NnoiLz48cGF0aCBkPSJNMTc5LjEyOSA4My4xNjdoLTI0LjA2YTUgNSAwIDAgMC01IDV2MjQuMDYxYTUgNSAwIDAgMCA1IDVoMjQuMDZhNSA1IDAgMCAwIDUtNVY4OC4xNjdhNSA1IDAgMCAwLTUtNXpNMTcyLjYyOSAxNDIuODZoLTEyLjU2VjEzMC44YTUgNSAwIDEgMC0xMCAwdjE3LjA2MWE1IDUgMCAwIDAgNSA1aDE3LjU2YTUgNSAwIDEgMCAwLTEwLjAwMXpNMjE2LjU2OCA4My4xNjdoLTI0LjA2YTUgNSAwIDAgMC01IDV2MjQuMDYxYTUgNSAwIDAgMCA1IDVoMjQuMDZhNSA1IDAgMCAwIDUtNVY4OC4xNjdhNSA1IDAgMCAwLTUtNXptLTUgMjQuMDYxaC0xNC4wNlY5My4xNjdoMTQuMDZ2MTQuMDYxek0yMTEuNjY5IDEyNS45MzZIMTk3LjQxYTUgNSAwIDAgMC01IDV2MTQuMjU3YTUgNSAwIDAgMCA1IDVoMTQuMjU5YTUgNSAwIDAgMCA1LTV2LTE0LjI1N2E1IDUgMCAwIDAtNS01eiIvPjwvc3ZnPg=="
                                style="opacity: 0.8;" alt="Camera based scan"></div>
                        <div id="reader__dashboard" style="width: 100%;">
                            <div id="reader__dashboard_section"
                                style="width: 100%; padding: 10px 0px; text-align: left;">
                                <div>
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
                                </div>
                                <div style="text-align: center;"><span id="html5-qrcode-anchor-scan-type-change"
                                        class="html5-qrcode-element"
                                        style="text-decoration: underline; cursor: pointer; display: inline-block;">Scan
                                        an
                                        Image File</span></div>
                            </div>
                        </div>
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
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);
        </script>
    </section>

</x-app-layout>
