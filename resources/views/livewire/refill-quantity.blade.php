<tr @if ($hideRow) hidden @endif>
    <td class="p-2 whitespace-nowrap">
        <x-product-uuid-cell>
            {{ $refill->product->uuid }}
        </x-product-uuid-cell>
    </td>
    <td class="p-2 whitespace-nowrap">
        <x-product-name-cell class="" :href="route('warehouse.product.show', [$warehouse, $refill->product])">
            {{ $refill->product->name }}
        </x-product-name-cell>
    </td>
    <td class="p-2 whitespace-nowrap items-center">
        <div class="text-center">
            <x-text-input id="quantity_{{ $refill->id }}" class="block w-20 text-right h-9 " type="text"
                name="quantity[{{ $refill->id }}]" wire:model="quantity" :value="$quantity" />
        </div>
    </td>
    <td class="">
        <div class="">
            <x-secondary-button class="h-9 w-9" wire:click="updateQuantity">
                <i class="fa-solid fa-check  -ml-1"></i>
            </x-secondary-button>
        </div>
    </td>
</tr>
