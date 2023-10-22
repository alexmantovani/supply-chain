<head>
    <title>Richiesta materiale</title>

    <style>
        {
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Roboto", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            font-size: 18px;
            line-height: 1.6;
            color: #30373D;
        }

        table,
        th,
        td {
            border: 1px solid rgb(199, 199, 199);
            border-collapse: collapse;
            padding: 10px;
            margin: 10 0 10 0
        }

        h1 small,
        h2 small,
        h3 small,
        h4 small,
        h5 small,
        h6 small {
            font-size: 60%;
            color: #6f6f6f;
            line-height: 1.1;
            text-transform: none;
        }

        h1 {
            font-weight: 500;
            font-size: 44px;
        }

        h2 {
            font-weight: 500;
            font-size: 36px;
            margin-top: -10px;
        }

        h3 {
            font-weight: 500;
            font-size: 27px;
        }

        h4 {
            font-weight: 500;
            font-size: 23px;
        }

        h5 {
            font-weight: 900;
            font-size: 17px;
        }

        h6 {
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
            color: #444;
        }

        .collapse {
            margin: 0 !important;
        }

        p,
        ul,
        ol {
            margin-bottom: 30px;
            font-weight: normal;
            color: #30373D;
            font-size: 18px;
            line-height: 1.6;
        }

        .small {
            font-size: 12px;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            /* makes it centered */
            clear: both !important;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }

        .content table {
            width: 100%;
        }

        .clear {
            display: block;
            clear: both;
        }
    </style>
</head>


<body>
    <div class="grey pt-2">
        <center>
            <img src="{{ url('/images/logo_mg.png') }}" alt="Marchesini Group" height=170>
        </center>
        <p>
        <div>
            Buongiorno,
        </div>
        <div>
            Di seguito l'elenco del materiale richiesto da
            <strong>
                {{ $order->warehouse->name }}.
            </strong>

            <br>

            @if ($order->hasMissingQuantity())
                <br>
                <strong>
                    <h3 style="color: red">
                        ⚠️ Sono stati ordinati articoli con informazioni mancanti pertanto il file tracciato non è stato
                        allegato.
                        ⚠️
                    </h3>
                </strong>
                <br>
            @endif

            <table>
                <thead class="small ">
                    <tr>
                        <th style="text-align: left ">
                            Codice
                        </th>
                        <th style="text-align: left ">
                            Prodotto
                        </th>
                        <th style="text-align: left ">
                            Fornitore
                        </th>
                        <th style="text-align: right ">
                            Quantità
                        </th>
                    </tr>
                </thead>

                @foreach ($order->products as $product)
                    <tr>
                        <td style="text-align: left ">
                            {{ $product->uuid }}
                        </td>
                        <td style="text-align: left ">
                            {{ $product->name }}
                        </td>
                        <td style="text-align: left ">
                            {{-- {{ $product->provider}}   {{ $product->provider_name }} --}}
                            {{ $order->provider_name }}
                        </td>
                        <td style="text-align: right ">
                            {{ $product->pivot->quantity }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div>
            Cordiali saluti<br>
        </div>
    </div>
</body>
