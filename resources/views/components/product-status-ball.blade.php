@props(['status'])

@if ($status->code != 'OK')
    @switch($status->code)
        @case('ANN')
            <div {{ $attributes->merge(['class' => 'fill-red-600']) }} title='Annullato'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>
            </div>
        @break

        @case('ANR')
            <div {{ $attributes->merge(['class' => 'fill-red-600 ']) }} title='Annullato ricambi'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>
            </div>
        @break

        @case('ANPV')
            <div {{ $attributes->merge(['class' => 'fill-red-600']) }} title='Annullato post vendita'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>

            </div>
        @break

        @case('NOO')
            <div {{ $attributes->merge(['class' => 'fill-red-600']) }} title='Non ordinabile'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>
            </div>
        @break

        @case('ESA')
            <div {{ $attributes->merge([
                'class' => 'fill-yellow-400',
            ]) }} title='In esaurimento'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>

            </div>
        @break

        @case('ESR')
            <div {{ $attributes->merge([
                'class' => 'fill-yellow-400',
            ]) }}
                title='In esaurimento ricambi'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>

            </div>
        @break

        @case('ESPV')
            <div {{ $attributes->merge([
                'class' => 'fill-yellow-400',
            ]) }}
                title='In esaurimento post vendita'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>

            </div>
        @break

        @case('PHO')
            <div {{ $attributes->merge([
                'class' => 'fill-yellow-400',
            ]) }}
                title='Eliminare gradualmente'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>

            </div>
        @break

        @case('PFO')
            <div {{ $attributes->merge([
                'class' => 'fill-yellow-400',
            ]) }}
                title='Problemi di fornitura'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>

            </div>
        @break

        @case('TST')
            <div {{ $attributes->merge([
                'class' => 'fill-yellow-400',
            ]) }} title='In test'>
                <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
                    xml:space="preserve">
                    <style type="text/css">
                    </style>
                    <path class=""
                        d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
                </svg>
            </div>
        @break

        @default
    @endswitch
{{-- @else
    <div {{ $attributes->merge([
        'class' => 'fill-green-400',
    ]) }} title='In test'>
        <svg version="1.1" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88"
            xml:space="preserve">
            <style type="text/css">
            </style>
            <path class=""
                d="M61.44,0c33.93,0,61.44,27.51,61.44,61.44s-27.51,61.44-61.44,61.44S0,95.37,0,61.44S27.51,0,61.44,0L61.44,0z" />
        </svg>
    </div> --}}
@endif
