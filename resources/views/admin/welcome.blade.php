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

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-800">


        {{-- <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 h-full md:mx-28"> --}}
        <div class="h-full w-full max-w-7xl mx-auto ">

            <div class="">
                @include('admin.sidebar', ['active' => 'home'])

                <div class="mt-5 grid  lg:grid-cols-2">

                    <div class="p-3 w-full h-full">
                        <canvas id="myChart"></canvas>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-1 md:p-5 rounded-md">
                        <div class="font-semibold text-2xl dark:text-gray-200">
                            Ordini pendenti
                        </div>

                        <div>
                            <table class="table-auto w-full md:mt-5 text-sm ">
                                @foreach ($orders as $groupOrder)
                                    <tr>
                                        <td colspan="4">
                                            <div class="mt-1 md:mt-5 mb-1 p-1 text-lg rounded-sm font-semibold text-gray-900 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">
                                                {{ $groupOrder->first()->warehouse->name }}
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach ($groupOrder as $order)
                                        <tr class="h-8">
                                            <td>
                                                <div class=" lg:pl-3">
                                                    <a
                                                        href="{{ route('warehouse.order.show', [$warehouse, $order->id]) }}">
                                                        <div class="font-medium text-gray-800 dark:text-gray-200 ">
                                                            {{ $order->uuid }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </td>

                                            <td>

                                                <div
                                                    class="text-gray-700 dark:text-gray-200 hidden md:flex">
                                                    {{ $order->provider_name }}
                                                </div>
                                            </td>


                                            <td>
                                                <div class="text-gray-700 dark:text-gray-700">
                                                    {{ $order->created_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td>
                                                <x-order-status-gradient
                                                class="w-30 text-xs font-semibold uppercase border-r-4 text-gray-700 text-right p-2"
                                                :status="$order->status" />
                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                    </div>

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
