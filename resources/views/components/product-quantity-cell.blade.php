@props(['quantity'])

@if ($quantity > 0)
    <a
        {{ $attributes->merge(['class' => 'font-xs md:text-md md:font-medium text-gray-800 dark:text-gray-300 text-right']) }}>
        {{ $quantity }}
    </a>
@else
    <a
        {{ $attributes->merge(['class' => 'font-xs md:text-md md:font-medium text-gray-400 dark:text-gray-500 text-right']) }}>
        -
    </a>
@endif
