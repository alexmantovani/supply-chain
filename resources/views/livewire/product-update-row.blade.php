<tr class="">
    <td class="p-2">
        <x-product-name-cell class="text-lg">
            <input id="checkbox_{{ $product->uuid }}" name="product_ids[]" type="checkbox" value="{{ $product->id }}"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="checkbox_{{ $product->uuid }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                {{ $product->name }}
            </label>
            {{-- <a href="{{ route('warehouse.product.show', [$warehouse, $product]) }}">
                {{ $product->name }}
            </a> --}}
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
