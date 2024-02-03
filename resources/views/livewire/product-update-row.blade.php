<tr class=" {{ ($providerId && $refillQuantity) ? '' : 'bg-red-200' }}">
    <td class="p-2 w-2">
        <input id="checkbox_{{ $product->uuid }}" name="product_ids[]" type="checkbox" value="{{ $product->id }}"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    </td>

    <td class="p-2 w-12 hidden md:table-cell">
        <x-product-uuid-cell class="text-md">
            <label for="checkbox_{{ $product->uuid }}" class="">
                {{ $product->uuid }}
            </label>
        </x-product-uuid-cell>
    </td>

    <td class="p-2 ">
        <x-product-name-cell class="">
            <label for="checkbox_{{ $product->uuid }}"
                class="text-sm font-medium text-gray-900 dark:text-gray-300">
                {{ $product->name }}
            </label>
            {{-- <a href="{{ route('warehouse.product.show', [$warehouse, $product]) }}">
                {{ $product->name }}
            </a> --}}
        </x-product-name-cell>
    </td>

    <td class="p-2 w-6 hidden md:table-cell">
        <input
        class="w-20 text-right border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm"
        wire:model="package" type="text">
    </td>

    <td class="p-2 w-6">
        <input
            class="w-20 text-right border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm"
            wire:model="refillQuantity" type="text">
    </td>

    <td class="p-2 w-6 hidden md:table-cell">
        <input
        class="w-20 text-right border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm"
        wire:model="unitOfMeasure" type="text">
    </td>

    <td class="p-2 w-38">
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
