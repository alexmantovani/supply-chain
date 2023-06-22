@props(['filters'])

<div id="dropdownRadio"
    class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
    data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top"
    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
    <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
        @foreach (App\Models\ProductStatus::all()->groupBy('group') as $group => $value)
            <li>
                <div class="flex items-center p-2">
                    <input {{ in_array($group, $filters) ? 'checked' : '' }} id="default-checkbox-{{ $loop->index }}"
                        type="checkbox" name="filters[]" value="{{ $group }}"
                        class="w-4 h-4 text-red-400 bg-gray-100 border-gray-300 rounded focus:ring-red-400 dark:focus:ring-red-400 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox-{{ $loop->index }}"
                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $group }}
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
</div>
