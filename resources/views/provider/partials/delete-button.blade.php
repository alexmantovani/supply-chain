<div>
    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion')"
        title="Elimina fornitore">
        <i class="fa-solid fa-trash-can"></i>
        &nbsp; elimina
    </x-danger-button>

    <x-modal name="confirm-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('provider.destroy', $provider) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Sei sicuro di voler eliminare questo fornitore?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Una volta che il fornitore è stato cancellato, tutti i dati ad esso collegati saranno permanentemente cancellati.') }}
            </p>

            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annulla') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Elimina fornitore') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
