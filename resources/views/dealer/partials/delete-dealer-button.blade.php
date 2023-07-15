<div>
    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-dealer-deletion')"
        title="Elimina costruttore">
        <i class="fa-solid fa-trash-can"></i>
    </x-danger-button>

    <x-modal name="confirm-dealer-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('dealer.destroy', $dealer) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Sei sicuro di voler eliminare questo costruttore?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Una volta che il costruttore è stato cancellato, tutti i prodotti ad esso collegati saranno permanentemente cancellati.') }}
            </p>

            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annulla') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Elimina costruttore') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
