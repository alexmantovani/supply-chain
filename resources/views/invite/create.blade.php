<x-app-layout>

    <x-slot name="navbar_right_menu">
        {{-- @include('layouts.nav_right_bar', ['warehouse' => $warehouse]) --}}
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="flex sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

                <form method="POST" action="{{ route('invite.store') }}">
                    @csrf

                    <input type="hidden" name="company_id" value="{{ $company->id }}" />

                    <!-- Name -->
                    <div class="pt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="pt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-4 mb-2">
                        <x-input-label for="warehouse_id" :value="__('Elenco magazzini')" />
                        <div class="">
                            <select id="warehouse_id" name="warehouse_id"
                                class="form-control w-full rounded bg-gray-50 dark:bg-gray-800 mt-1 dark:text-white">
                                @foreach ($warehouses as $warehouse_item)
                                    <option value="{{ $warehouse_item->id }}">
                                        {{ $warehouse_item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class=" pt-2">
                        <x-input-label :value="__('Ruolo')" class="pb-1"/>

                        <div class="flex justify-between border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-3">
                            @foreach ($roles as $role)
                                @if ($role->name == 'super-admin')
                                    @continue
                                @endif

                                <div class="flex">
                                    <input id="roles_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->name }}"
                                    class="text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <x-input-label for="roles_{{ $role->id }}" :value="$role->name" class="pl-2 uppercase" />
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <x-primary-button class="my-5">
                        {{ __('Invita') }}
                    </x-primary-button>
                </form>

            </div>
        </div>
    </section>
</x-app-layout>
