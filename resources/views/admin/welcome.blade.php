<x-app-layout>
    {{-- <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div class="
      font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight
    cursor-pointer">
                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
            </div>
            <div>
                <div class="text-gray-900 dark:text-gray-100">
                    Pannello di amministrazione
                </div>
            </div>
        </div>
    </x-slot> --}}

    <x-slot name="navbar_title">
        <div class="flex md:ml-5 items-center space-x-2 md:space-x-5">
            <div>
                <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
                    {{ $warehouse->name }}
                </x-navbar-title>
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar', ['warehouse' => $warehouse])
    </x-slot>

    <x-slot name="navbar_right_menu">
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">


        {{-- <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 h-full md:mx-28"> --}}
        <div class="h-full w-full max-w-7xl mx-auto ">

            <div class="">
                @include('admin.sidebar', ['active' => 'home'])

                {{-- <div>
                    <a href="{{ url('admin/users') }}">
                        <div
                            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 p-8 dark:bg-gray-900 dark:border-gray-800 my-3">
                            <div class="flex justify-between space-x-10">
                                <svg class="w-16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
                            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 p-8 dark:bg-gray-900 dark:border-gray-800 my-3">
                            <div class="flex justify-between space-x-10">
                                <svg class="w-16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" />
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
                            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 p-8 dark:bg-gray-900 dark:border-gray-800 my-3">
                            <div class="flex justify-between space-x-10">
                                <svg class="w-16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
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
                    <a href="{{ url('/admin/dealer') }}">
                        <div
                            class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 px1 p-8 dark:bg-gray-900 dark:border-gray-800 my-3">
                            <div class="flex justify-between space-x-10">
                                <svg class="w-16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                </svg>
                                <div class="text-right">
                                    <div class="text-xl font-medium">
                                        Produttori
                                    </div>
                                    <div class=" text-red-400 text-md">
                                        {{ App\Models\Dealer::all()->count() }} produttori
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> --}}

                <div class="mt-5">

                    <div class="p-3">
                        <canvas id="myChart" width="400" height="160"></canvas>
                    </div>

                    <div class="font-semibold text-2xl dark:text-gray-200">
                        Ordini pendenti
                    </div>
                    <table class="table-auto w-full mt-5">
                        @foreach ($orders as $order)
                            <tr class="h-10">
                                <td>
                                    <div>
                                        {{ $order->warehouse->name }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $order->in_progress }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        const data = <?php echo json_encode($graphOrders); ?>;

        const labels = Object.keys(data);
        const datasets = [];

        const uniqueWarehouseIds = [...new Set(
            [].concat(...labels.map(year => data[year].map(entry => entry.warehouse_id)))
        )];

        uniqueWarehouseIds.forEach(warehouseId => {
            const dataset = {
                label: `Warehouse ${warehouseId}`,
                data: labels.map(year => {
                    const yearData = data[year];
                    const entry = yearData.find(entry => entry.warehouse_id === warehouseId);
                    return entry ? entry.count : 0;
                }),
                backgroundColor: getRandomColor(),
                stack: 'stack'
            };

            datasets.push(dataset);
        });

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        const ctx = document.getElementById('myChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        stacked: true // Impila le barre orizzontalmente
                    },
                    y: {
                        stacked: true // Impila le barre verticalmente
                    }
                }
            }
        });
    </script>


</x-app-layout>
