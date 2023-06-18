@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            @if (gettype($message) == 'array')
                {{-- @foreach ((array) $message as $subMessage)
                    <li>{{ $subMessage }}</li>
                @endforeach --}}
                <li>{{ $message[0] }}</li>
            @else
                <li>{{ $message }}</li>
            @endif
        @endforeach
    </ul>
@endif
