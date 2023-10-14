<!DOCTYPE html>
<html>

<head>
    <title>QR Code Page</title>
    <style>
        .qrcode-container {
            display: inline-block;
            width: 31%;
            margin: 1%;
            text-align: left;
        }

        .qrcode {
            max-width: auto;
            height: auto;
        }

        @media print {
            .qrcode-container {
                width: 30%;
                /* Regola la larghezza delle colonne in base alle tue esigenze */
                margin: 1%;
                text-align: left;
                vertical-align: top;
                display: inline-block;
            }

            .qrcode-container p{
                font-size: 6px;
                color: #5f5f5f
            }

            .qrcode {
                max-width: 100%;
                height: auto;
            }

            div{
                font-size: 10px;
                color: #222222
            }

        }
    </style>
</head>

<body>
    @foreach ($products as $product)
        <div class="qrcode-container">
            <img class="qrcode" src="data:image/png;base64,{{ DNS2D::getBarcodePNG($product->uuid, 'QRCODE', 64, 64) }}"
                alt="barcode" style="width: 40px; height: 40px; float:left; padding:0px 5px;" />
                <div style="">
                    {{ $product->name }}
                    <p style="margin-top: 0;">{{ $product->uuid }}</p>
                </div>
        </div>
    @endforeach
</body>

</html>
