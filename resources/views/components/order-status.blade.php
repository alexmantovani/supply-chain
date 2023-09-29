@props(['status'])

@switch($status)
    @case('aborted')
        <div {{ $attributes->merge([
                'class' => 'border-red-500 dark:bg-red-900 dark:text-white bg-gradient-to-l from-red-100',
            ]) }}>
            {{-- <i class="fa-solid fa-ban"></i>
            &nbsp; --}}
            Annullato
        </div>
    @break

    @case('waiting')
        <div
            {{ $attributes->merge([
                'class' => 'border-cyan-500 dark:bg-cyan-900 dark:text-white bg-gradient-to-l from-cyan-100',
                'title' => 'L\'ordine è stato spedito e si attende il rientro del materiale',
            ]) }}>
            {{-- <i class="fa-solid fa-hourglass"></i>
            &nbsp; --}}
            In attesa
        </div>
    @break

    @case('pending')
        <div {{ $attributes->merge([
            'class' => 'border-yellow-500 dark:bg-yellow-900 dark:text-white bg-gradient-to-l from-yellow-100',
        ]) }}>
            Parziale
        </div>
    @break

    @case('completed')
        <div
            {{ $attributes->merge([
                'class' => 'border-green-500 dark:bg-green-900 dark:text-white bg-gradient-to-l from-green-100',
                'title' => 'L\'ordine è stato completato',
            ]) }}>
            {{-- <i class="fa-solid fa-check"></i>
            &nbsp; --}}
            Completato
        </div>
    @break

    @case('closed')
        <div
            {{ $attributes->merge([
                'class' => 'border-green-500 dark:bg-green-900 dark:text-white bg-gradient-to-l from-green-100',
                'title' => 'L\'ordine è stato chiuso con materiale non consegnato',
            ]) }}>
            Chiuso
        </div>
    @break

    @default
@endswitch
