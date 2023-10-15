@props(['status'])

@switch($status)
    @case('aborted')
        <div {{ $attributes->merge([
                'class' => 'border-red-500 dark:text-white bg-gradient-to-l from-red-100 dark:from-red-900',
            ]) }}>
            Annullato
        </div>
    @break

    @case('waiting')
        <div
            {{ $attributes->merge([
                'class' => 'border-cyan-500 dark:text-white bg-gradient-to-l from-cyan-100 dark:from-cyan-900 ',
                'title' => 'L\'ordine è stato spedito e si attende il rientro del materiale',
            ]) }}>
            In attesa
        </div>
    @break

    @case('pending')
        <div {{ $attributes->merge([
            'class' => 'border-yellow-500 dark:text-white bg-gradient-to-l from-yellow-100 dark:from-yellow-900',
        ]) }}>
            Parziale
        </div>
    @break

    @case('completed')
        <div
            {{ $attributes->merge([
                'class' => 'border-green-500 dark:text-white bg-gradient-to-l from-green-100 dark:from-green-900',
                'title' => 'L\'ordine è stato completato',
            ]) }}>
            Completato
        </div>
    @break

    @case('closed')
        <div
            {{ $attributes->merge([
                'class' => 'border-green-500 dark:text-white bg-gradient-to-l from-green-100 dark:from-green-900',
                'title' => 'L\'ordine è stato chiuso con materiale non consegnato',
            ]) }}>
            Chiuso
        </div>
    @break

    @default
@endswitch
