<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('warehouse.product.index', $warehouse->id)" :active="request()->routeIs('warehouse.product.*')">
        {{ __('Listino') }}
    </x-nav-link>
    <x-nav-link :href="route('warehouse.refill.index', $warehouse->id)" :active="request()->routeIs('warehouse.refill.*')">
        {{ __('In esaurimento') }}
    </x-nav-link>
    @can('handle order')
        <x-nav-link :href="route('warehouse.order.index', $warehouse->id)" :active="request()->routeIs('warehouse.order.*')">
            {{ __('Ordini') }}
        </x-nav-link>
    @endcan
    @can('admin site')
        <x-nav-link :href="route('admin')" :active="request()->routeIs('admin.*')">
            {{ __('Admin') }}
        </x-nav-link>
    @endcan

</div>
