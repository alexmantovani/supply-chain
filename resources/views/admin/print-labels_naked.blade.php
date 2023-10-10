<!DOCTYPE html>
<html>

<head>
    <style>
        /* Regola CSS per ridurre la dimensione del font */
        div {
            font-size: 6px;
        }

        name {
            font-size: 10px;
            color: red;
        }
    </style>
</head>

<body>
    <div>
        <table style="width:100%;border-collapse: collapse;margin-top:10px;">
            <tbody>
                @for ($i = 0; $i < $products->count(); $i++)
                    <tr>
                        @for ($j = 0; $j < 3; $j++)
                            <td
                                style="padding-top: 23px; padding-bottom: 8px; text-align: center; border: 1px dotted #ddd; width:25%">
                                <div class="" style="">
                                    @if ($i < $products->count())
                                        <div>
                                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($products[$i]->name, 'QRCODE', 1, 1) }}"
                                                alt="barcode" />
                                            <span class="" style="vertical-align: top">
                                                    {{ $products[$i]->name }}
                                            </span>
                                        </div>
                                    @else
                                        &nbsp;
                                        <div class="" style="">
                                            &nbsp;
                                        </div>
                                    @endif
                                </div>
                            </td>

                            @php
                                if ($j < 3) {
                                    $i++;
                                }
                            @endphp
                        @endfor
                    </tr>

                    {{-- Ogni pagina contiene 48 etichette (4 etichette per 12 righe) --}}
                    @if (($i + 1) % 48 == 0)
            </tbody>
        </table>
        {{-- Footer --}}
        <div class="footer">
            <div class="">
                <h6>
                    Tray labels &nbsp; &nbsp; &#183; &nbsp; &nbsp; Page <span class="pagenum"></span> &nbsp; &nbsp;
                    &#183; &nbsp; &nbsp; {{ env('APP_URL'
                </h6>
            </div>
        </div>

        {{-- Fine pagina --}}
        <div class="page-break"></div>

        <table style="width:100%;border-collapse: collapse;margin-top:10px;">
            <tbody>
@endif

                @endfor

            </tbody>
        </table>
    </div>
</body>

</html>
