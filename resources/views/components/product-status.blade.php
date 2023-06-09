@props(['status'])

@switch($status)
    @case('aborted')
        <div {{ $attributes->merge(['class' => 'bg-red-600 text-white ']) }}>
            {{-- <i class="fa-solid fa-ban"></i>
            &nbsp; --}}
            Annullato
        </div>
    @break

    @case('obsolete')
        <div
            {{ $attributes->merge([
                'class' => 'bg-transparent text-yellow-600 border-yellow-400 border',
            ]) }}>
            {{-- <i class="fa-regular fa-triangle-exclamation"></i>
            &nbsp; --}}
            Obsoleto
        </div>
    @break

    {{-- @case('available')
        <div {{ $attributes->merge([
            'class' => 'bg-green-500 text-white ',
        ]) }}>
            <i class="fa-solid fa-check"></i>
            &nbsp;
            Disponibile
        </div>
    @break --}}

    @default

@endswitch
