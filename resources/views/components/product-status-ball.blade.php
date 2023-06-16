@props(['status'])


@switch($status->code)
    @case('ANN')
        <div {{ $attributes->merge(['class' => 'text-red-600']) }} title='Annullato'>
            {{-- <i class="fa-solid fa-ban"></i>
        &nbsp; --}}
        &bull;
        </div>
    @break
    @case('ANR')
        <div {{ $attributes->merge(['class' => 'text-red-600 ']) }} title='Annullato ricambi'>
            &bull;
        </div>
    @break
    @case('ANPV')
        <div {{ $attributes->merge(['class' => 'text-red-600']) }} title='Annullato post vendita'>
            &bull;
        </div>
    @break
    @case('NOO')
        <div {{ $attributes->merge(['class' => 'text-red-600']) }} title='Non ordinabile'>
            &bull;
        </div>
    @break

    @case('ESA')
        <div {{ $attributes->merge([
            'class' => 'text-yellow-400',
        ]) }}
            title='In esaurimento'>
            &bull;
        </div>
    @break
    @case('ESR')
        <div {{ $attributes->merge([
            'class' => 'text-yellow-400',
        ]) }}
            title='In esaurimento ricambi'>
            &bull;
        </div>
    @break
    @case('ESPV')
        <div {{ $attributes->merge([
            'class' => 'text-yellow-400',
        ]) }}
            title='In esaurimento post vendita'>
            &bull;
        </div>
    @break
    @case('PHO')
        <div {{ $attributes->merge([
            'class' => 'text-yellow-400',
        ]) }}
            title='Eliminare gradualmente'>
            &bull;
        </div>
    @break
    @case('PFO')
        <div {{ $attributes->merge([
            'class' => 'text-yellow-400',
        ]) }}
            title='Problemi di fornitura'>
            &bull;
        </div>
    @break

    @case('TST')
        <div {{ $attributes->merge([
            'class' => 'text-yellow-400',
        ]) }}
            title='In test'>
            &bull;
        </div>
    @break

    @default
@endswitch
