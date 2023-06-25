<tr class="">
    <td class="p-2">
        <x-product-name-cell class="text-lg">
            {{ $dealer->name }}
        </x-product-name-cell>
    </td>

    <td class="p-2">
        <div class="">
            <select wire:model="providerId"
                class="form-control w-full rounded bg-gray-50 dark:bg-gray-800 mt-1 dark:text-white">
                @foreach ($providers as $provider)
                    <option value="{{ $provider->id }}"
                        {{ $providerId == $provider->id ? 'selected' : '' }}>
                        {{ $provider->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </td>
</tr>
