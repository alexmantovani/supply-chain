<tr class="{{ $hideRow ? 'hidden' : '' }}">
    <td class="p-2">
        <div class=" items-center">
            <div class="font-medium text-gray-800 md:text-lg dark:text-gray-300">
                {{ $user->name }}
            </div>
            <div class="text-gray-400 text-sm dark:text-gray-600">
                {{ $user->email }}
            </div>
        </div>
    </td>
    @foreach ($roles as $role)
        @if ($role->name == 'super-admin')
            @continue
        @endif

        <td class="p-2 w-28">
            <div class="text-center pt-2">
                <div>
                    <input wire:model="userRoles" type="checkbox" value="{{ $role->name }}"
                        class="text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>
        </td>
    @endforeach

    <td class="p-2 w-48">
        <div class="">
            <select wire:model="warehouseId"
                class="form-control w-full rounded bg-gray-50 dark:bg-gray-800 mt-1 dark:text-white">
                @foreach ($warehouses as $warehouse_item)
                    <option value="{{ $warehouse_item->id }}"
                        {{ $warehouseId == $warehouse_item->id ? 'selected' : '' }}>
                        {{ $warehouse_item->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </td>
    <td class="p-2 w-10 h-10">
        @if ($user->canBeDeleted())
            <button wire:click="deleteUser()"
                class="text-xs text-orange-700 hover:text-orange-900 hover:underline"
                title="Elimina questo utente">
                Elimina
            </button>

            {{-- <x-danger-button title="Elimina utente">
                <form method="post" action="{{ route('user.destroy', $user) }}" class="">
                    @csrf
                    @method('delete')

                    <i class="fa-solid fa-trash-can"></i>
                </form>
            </x-danger-button> --}}
        @endif
    </td>
</tr>
