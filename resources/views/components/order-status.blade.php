@props(['status'])

@switch($status)
    @case('aborted')
        <div {{ $attributes->merge(['class' => 'bg-red-600 text-white ']) }}>
            {{-- <i class="fa-solid fa-ban"></i>
            &nbsp; --}}
            Annullato
        </div>
    @break

    @case('waiting')
        <div
            {{ $attributes->merge([
                'class' => 'bg-transparent text-green-600 border-green-400 border',
                'title' => 'L\'ordine è stato spedito e si attende il rientro del materiale',
            ]) }}>
            {{-- <i class="fa-solid fa-hourglass"></i>
            &nbsp; --}}
            In attesa
        </div>
    @break

    @case('pending')
        <div {{ $attributes->merge(['class' => 'bg-yellow-400 text-white ']) }}>
            Parziale
        </div>
    @break

    @case('completed')
        <div
            {{ $attributes->merge([
                'class' => 'bg-green-500 text-white ',
                'title' => 'L\'ordine è stato completato',
            ]) }}>
            {{-- <i class="fa-solid fa-check"></i>
            &nbsp; --}}
            Completato
        </div>
    @break

    @default
@endswitch
