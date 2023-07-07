<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Company Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Allows .') }}
        </p>
    </header>


    <form method="post" action="{{ route('profile.company.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
        </div>

        <div>
            <select name="companyId"
                class="form-control w-full rounded bg-gray-50 dark:bg-gray-800 mt-1 dark:text-white">
                @foreach (Auth::user()->companies as $company)
                    <option value="{{ $company->id }}"
                        {{ $company->pivot->is_active ? 'selected' : '' }}
                        >
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Attiva') }}</x-primary-button>

            @if (session('status') === 'profile-company-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400">{{ __('Nuova compagnia attivata.') }}</p>
            @endif
        </div>
    </form>
</section>
