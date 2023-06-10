@props(['status'])


@switch($status->code)
    @case('ANN')
        <div {{ $attributes->merge(['class' => 'bg-red-600 text-white ']) }} title='Annullato'>
            {{-- <i class="fa-solid fa-ban"></i>
        &nbsp; --}}
            Annullato
        </div>
    @break
    @case('ANR')
        <div {{ $attributes->merge(['class' => 'bg-red-600 text-white ']) }} title='Annullato ricambi'>
            Annullato
        </div>
    @break
    @case('ANPV')
        <div {{ $attributes->merge(['class' => 'bg-red-600 text-white ']) }} title='Annullato post vendita'>
            Annullato
        </div>
    @break
    @case('NOO')
        <div {{ $attributes->merge(['class' => 'bg-red-600 text-white ']) }} title='Non ordinabile'>
            Non ordinabile
        </div>
    @break

    @case('ESA')
        <div {{ $attributes->merge([
            'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
        ]) }}
            title='In esaurimento'>
            In esaurimento
        </div>
    @break
    @case('ESR')
        <div {{ $attributes->merge([
            'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
        ]) }}
            title='In esaurimento ricambi'>
            In esaurimento
        </div>
    @break
    @case('ESPV')
        <div {{ $attributes->merge([
            'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
        ]) }}
            title='In esaurimento post vendita'>
            In esaurimento
        </div>
    @break
    @case('PHO')
        <div {{ $attributes->merge([
            'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
        ]) }}
            title='Eliminare gradualmente'>
            Phase out
        </div>
    @break
    @case('PFO')
        <div {{ $attributes->merge([
            'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
        ]) }}
            title='Problemi di fornitura'>
            Fornitura
        </div>
    @break

    @case('TST')
        <div {{ $attributes->merge([
            'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
        ]) }}
            title='In test'>
            In test
        </div>
    @break

    @default
@endswitch
