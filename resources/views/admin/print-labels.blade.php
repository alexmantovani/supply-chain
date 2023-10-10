<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- QR adn Barcode scanner -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    {{-- JQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Container holding the image and the text */

        .container-wide {
            position: relative;
            text-align: center;
            color: white;
        }

        img {
            width: 100%;
            height: auto;
        }

        /* Centered text */
        .centered {
            position: absolute;
            top: 10%;
            /* left: 50%;
            width: 60%;
            transform: translate(-50%, -50%); */
        }

        .bottom-right {
            position: absolute;
            top: 90%;
            right: 0%;
            width: auto;
            text-align: right;
            background-color: bg-orange-500;
            transform: translate(-50%, -50%);
        }

        .bottom {
            position: absolute;
            top: 90%;
            width: auto;
        }

        .border-1 {
            border-width: 1px;
        }
    </style>

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class=" ">
        <div class="grid grid-cols-3 h-10">
            @foreach ($products as $product)
                <div class="flex m-1 p-1 rounded border-red-500 border">
                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($product->uuid, 'QRCODE', 64, 64) }}"
                        alt="barcode" class="w-12 h-12" />
                    <div class="pl-2 m-1 text-xs overflow-clip" style="font-size:6px; vertical-align: top;">
                        <div>
                            {{ $product->name }}
                        </div>
                        <div>
                            {{ $product->uuid }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>


</html>
