@props(['arrived', 'status'])

@if ($arrived)
    <div {{ $attributes->merge(['class' => 'text-green-500']) }}>
        <i class="fa-solid fa-check"></i>
    </div>
@else
    @if ($status == 'completed')
        <div {{ $attributes->merge(['class' => 'text-red-500']) }}>
            <i class="fa-solid fa-xmark"></i>
        </div>
    @endif
@endif
