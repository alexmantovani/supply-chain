@props(['status'])

@switch($status)
    @case('aborted')
        <div {{ $attributes->merge([
                'class' => 'border-red-500 dark:bg-red-900 dark:text-white bg-red-50',
            ]) }}>
            Annullato
        </div>
    @break

    @case('waiting')
        <div
            {{ $attributes->merge([
                'class' => 'border-cyan-500 dark:bg-cyan-900 dark:text-white bg-cyan-50',
                'title' => 'L\'ordine è stato spedito e si attende il rientro del materiale',
            ]) }}>
            In attesa
        </div>
    @break

    @case('pending')
        <div {{ $attributes->merge([
            'class' => 'border-yellow-500 dark:bg-yellow-900 dark:text-white bg-yellow-50',
        ]) }}>
            Parziale
        </div>
    @break

    @case('completed')
        <div
            {{ $attributes->merge([
                'class' => 'border-green-500 dark:bg-green-900 dark:text-white bg-green-50',
                'title' => 'L\'ordine è stato completato',
            ]) }}>
            Completato
        </div>
    @break

    @case('closed')
        <div
            {{ $attributes->merge([
                'class' => 'border-green-500 dark:bg-green-900 dark:text-white bg-green-50',
                'title' => 'L\'ordine è stato chiuso con materiale non consegnato',
            ]) }}>
            Chiuso
        </div>
    @break

    @default
@endswitch
