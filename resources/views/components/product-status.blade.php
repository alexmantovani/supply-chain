@props(['status'])

@switch($status->code)
    @case('ANN')
        <div {{ $attributes->merge(['class' => 'font-semibold border-red-600 bg-red-100']) }} title='Annullato 1'>
            {{-- <i class="fa-solid fa-ban"></i>
    &nbsp; --}}
            Annullato
        </div>
    @break

    @case('ANR')
        <div {{ $attributes->merge(['class' => 'font-semibold border-red-600 bg-red-100 ']) }} title='Annullato ricambi'>
            Annullato
        </div>
    @break

    @case('ANPV')
        <div {{ $attributes->merge(['class' => 'font-semibold border-red-600 bg-red-100 ']) }} title='Annullato post vendita'>
            Annullato
        </div>
    @break

    @case('NOO')
        <div {{ $attributes->merge(['class' => 'font-semibold border-red-600 bg-red-100 ']) }} title='Non ordinabile'>
            Non ordinabile
        </div>
    @break

    @case('ESA')
        <div {{ $attributes->merge([
            'class' => 'font-semibold border-yellow-300 bg-yellow-100',
        ]) }}
            title='In esaurimento'>
            In esaurimento
        </div>
    @break

    @case('ESR')
        <div {{ $attributes->merge([
            'class' => 'font-semibold border-yellow-300 bg-yellow-100',
        ]) }}
            title='In esaurimento ricambi'>
            In esaurimento
        </div>
    @break

    @case('ESPV')
        <div {{ $attributes->merge([
            'class' => 'font-semibold border-yellow-300 bg-yellow-100',
        ]) }}
            title='In esaurimento post vendita'>
            In esaurimento
        </div>
    @break

    @case('PHO')
        <div {{ $attributes->merge([
            'class' => 'font-semibold border-yellow-300 bg-yellow-100',
        ]) }}
            title='Eliminare gradualmente'>
            Phase out
        </div>
    @break

    @case('PFO')
        <div {{ $attributes->merge([
            'class' => 'font-semibold border-yellow-300 bg-yellow-100',
        ]) }}
            title='Problemi di fornitura'>
            Fornitura
        </div>
    @break

    @case('TST')
        <div {{ $attributes->merge([
            'class' => 'font-semibold border-yellow-300 bg-yellow-100',
        ]) }}
            title='In test'>
            In test
        </div>
    @break

    @default
@endswitch
