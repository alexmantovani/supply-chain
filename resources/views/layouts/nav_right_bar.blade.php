<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <a href="{{ route('warehouse.refill.create', $warehouse) }}">
        <x-secondary-button class="">
            <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
        </x-secondary-button>
    </a>
</div>

<div class="flex space-x-2 sm:hidden">
    <a href="{{ route('warehouse.refill.create', $warehouse) }}">
        <x-secondary-button class="">
            <i class="fa-solid fa-plus"></i>
        </x-secondary-button>
    </a>
</div>
