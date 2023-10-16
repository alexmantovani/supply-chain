<div class="md:hidden">
    <x-responsive-nav-link :href="route('warehouse.product.index', $warehouse->id)">
        {{ __('Listino') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('warehouse.refill.index', $warehouse->id)">
        {{ __('In esaurimento') }}
    </x-responsive-nav-link>
    @can('handle order')
        <x-responsive-nav-link :href="route('warehouse.order.index', $warehouse->id)">
            {{ __('Ordini') }}
        </x-responsive-nav-link>
    @endcan
    @can('admin site')
        <x-responsive-nav-link :href="route('admin')">
            {{ __('Admin') }}
        </x-responsive-nav-link>
    @endcan
</div>
