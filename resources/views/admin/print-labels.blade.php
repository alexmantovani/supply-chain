<!DOCTYPE html>
<html>

<head>
    <style>
        .qrcode-container {
            display: inline-block;
            width: 31%;
            margin: 1px;
            text-align: left;
            padding: 4px;
        }

        .qrcode-container p {
            font-size: 14px;
            color: #575757;
        }

        .qrcode {
            max-width: auto;
            height: auto;
        }

        body {
            padding: 30px;
        }

        @media print {
            .qrcode-container {
                width: 30%;
                margin: 0.5%;
                text-align: left;
                vertical-align: top;
                display: inline-block;
            }

            .qrcode-container p {
                font-size: 10px;
                color: #575757
            }

            .qrcode {
                max-width: 100%;
                height: auto;
            }

            div {
                font-size: 10px;
                color: #111111
            }

            body {
                margin: 0mm;
                padding: 0mm;
            }
        }
    </style>
</head>

<body>
    @foreach ($products as $product)
        <div class="qrcode-container">
            <img class="qrcode" src="data:image/png;base64,{{ DNS2D::getBarcodePNG($product->uuid, 'QRCODE', 64, 64) }}"
                alt="barcode" style="width: 45px; height: 45px; float:left; padding:0px 5px;" />
            <div style="">
                {{ $product->name }}
                <p style="margin-top: 0;">Cod.: {{ $product->uuid }}</p>
            </div>
        </div>
    @endforeach
</body>

</html>
