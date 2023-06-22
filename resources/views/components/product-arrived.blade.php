@props(['arrived', 'status'])

@if ($arrived)
    <div {{ $attributes->merge(['class' => 'text-green-500']) }}
        title="Consegnato">
        <i class="fa-solid fa-check"></i>
    </div>
@else
    @if (($status == 'closed') || ($status == 'completed'))
        <div {{ $attributes->merge(['class' => 'text-red-500']) }}
            title="Non consegnato">
            <i class="fa-solid fa-xmark"></i>
        </div>
    @endif
@endif
