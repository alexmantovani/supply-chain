<tr class="">
    <td class="p-2">
        <x-product-name-cell class="text-lg" :href="route('warehouse.dealer.show', [Auth::user()->activeWarehouse, $dealer])">
                {{ $dealer->name }}
        </x-product-name-cell>
    </td>

    <td class="p-2">
        <div class="">
            <select wire:model="providerId"
                class="form-control w-full rounded bg-gray-50 dark:bg-gray-800 mt-1 dark:text-white">
                <option value="0">
                    Seleziona il fornitore...
                </option>
                @foreach ($providers as $provider)
                    <option value="{{ $provider->id }}" {{ $providerId == $provider->id ? 'selected' : '' }}>
                        {{ $provider->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </td>
</tr>
