<div class="hidden space-x-2 sm:-my-px sm:ml-10 sm:flex">
    @can('handle order')
        <a href="{{ route('product.checkin', $warehouse->id) }}">
            <x-secondary-button class="" title="Inserisci i codici dei prodotti che ti sono stati consegnati">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" />
                </svg>
            </x-secondary-button>
        </a>
    @endcan

    @can('add refill request')
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="" title="Aggiungi articoli alla lista dei materiali in esaurimento">
                <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
            </x-secondary-button>
        </a>
    @endcan
</div>

<div class="flex space-x-2 sm:hidden">
    @can('add refill request')
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="" title="Aggiungi articoli alla lista dei materiali in esaurimento">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </x-secondary-button>
        </a>
    @endcan

    @can('handle order')
        <a href="{{ route('product.checkin', $warehouse->id) }}">
            <x-secondary-button class="" title="Inserisci i codici dei prodotti che ti sono stati consegnati">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" />
                </svg>
            </x-secondary-button>
        </a>
    @endcan
</div>
