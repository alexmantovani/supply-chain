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

        /*
        img {
            max-width: 100%;
        }

        .collapse {
            margin: 0;
            padding: 0;
        } */

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

        /*
        p.lead {
            font-size: 22px;
        }

        p.last {
            margin-bottom: 0px;
        }

        ul li {
            margin-left: 24px;
            list-style-position: inside;
            margin-bottom: 14px;
        }

        ol li {
            margin-left: 32px;
            list-style-position: outside;
            margin-bottom: 14px;
        } */

        .small {
            font-size: 12px;
        }

        /* .grey {
            color: #224a85;
        } */


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
            Con la presente si intende annullare l'ordine
            <strong>
            {{ $order->uuid }}
            </strong>
            effettuato in data
            {{ $order->created_at->translatedFormat('d.m.Y') }} da
            <strong>
                {{ $order->warehouse->name }}.
            </strong>
        </div>
        <div>
            Cordiali saluti<br>
        </div>
    </div>
</body>
