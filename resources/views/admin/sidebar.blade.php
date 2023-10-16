<div class="grid grid-cols-2 lg:grid-cols-4 gap-1 lg:gap-4">
    <a href="{{ url('admin/users') }}">
        <div
            class="w-full bg-white shadow-lg rounded-sm border-b-8 p-4 dark:bg-gray-900 dark:text-gray-200 {{ $active == 'users' ? 'border-red-500' : 'border-red-100 dark:border-gray-700' }}">
            <div class="flex justify-between md:space-x-10">
                <svg class="w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>


                <div class="text-right">
                    <div class="text-xl font-medium">
                        Utenti
                    </div>
                    <div class=" text-red-400 text-md">
                        {{ App\Models\User::all()->count() }} utenti
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ url('/admin/warehouses') }}">
        <div
            class="w-full bg-white shadow-lg rounded-sm border-b-8 p-4 dark:bg-gray-900 dark:text-gray-200 {{ $active == 'warehouses' ? 'border-red-500' : 'border-red-100 dark:border-gray-700' }}">
            <div class="flex justify-between md:space-x-10">
                <svg class="w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>

                <div class="text-right">
                    <div class="text-xl font-medium">
                        Magazzini
                    </div>
                    <div class=" text-red-400 text-md">
                        {{ App\Models\Warehouse::all()->count() }} magazzini
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ url('/admin/provider') }}">
        <div
            class="w-full bg-white shadow-lg rounded-sm border-b-8 p-4 dark:bg-gray-900 dark:text-gray-200 {{ $active == 'providers' ? 'border-red-500' : 'border-red-100 dark:border-gray-700' }}">
            <div class="flex justify-between md:space-x-10">
                <svg class="w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <div class="text-right">
                    <div class="text-xl font-medium">
                        Fornitori
                    </div>
                    <div class=" text-red-400 text-md">
                        {{ App\Models\Provider::all()->count() }} fornitori
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ url('/admin/products') }}">
        <div
            class="w-full h-full bg-white shadow-lg rounded-sm border-b-8 p-4 dark:bg-gray-900 dark:text-gray-200 {{ $active == 'products' ? 'border-red-500' : 'border-red-100 dark:border-gray-700' }}">
            <div class="flex justify-between md:space-x-10">
                <svg class="w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                <div class="text-right">
                    <div class="text-xl font-medium">
                        Prodotti
                    </div>
                    <div class=" text-red-400 text-md">
                        {{ App\Models\Product::all()->count() }} prodotti
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
