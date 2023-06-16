<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex ml-5 items-center space-x-5">
            <div
                class="
          font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
        cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div>
                <div class="text-gray-900 dark:text-gray-100">
                    {{ __('Profilo utente') }}
                </div>
            </div>
        </div>
    </x-slot>

    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profilo') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
