@php
    $classes = 'space-x-8 sm:ml-5 flex font-semibold text-xl text-gray-800 dark:text-gray-200  items-center';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
