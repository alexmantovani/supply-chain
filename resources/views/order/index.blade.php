<x-app-layout>
    <x-slot name="navbar_title">
        <div class="flex ml-5 items-center space-x-5">
            <div>
                <x-navbar-title :href="route('warehouse.show', $warehouse->id)">
                    {{ $warehouse->name }}
                </x-navbar-title>
            </div>
        </div>
    </x-slot>
    <x-slot name="navbar_right_menu">
        <x-nav-link :href="route('warehouse.refill.simulate', $warehouse->id)" :active="request()->routeIs('warehouse.refill.simulate')">
            {{ __('Simula QR') }}
        </x-nav-link>
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4 dark:bg-gray-800">
        <div class="h-full ">
            <div class="w-full max-w-7xl mx-auto">
                <div class="flex justify-between items-baseline">
                    <div class=" text-gray-900 text-xl p-3 font-semibold">
                        Elenco ordini
                    </div>
                    <div class="font-semibold uppercase">
                        <a href="{{ route('warehouse.order.index', [$warehouse, 'show' => 'pending']) }}"
                            class="py-1
                    @if ($show === 'pending') text-indigo-500 border-b border-indigo-400 @endif
                    ">

                            In corso
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('warehouse.order.index', [$warehouse, 'show' => 'all']) }}"
                            class="py-1
                    @if ($show === 'all') text-indigo-500 border-b border-indigo-400 @endif
                    ">
                            Tutti

                        </a>
                    </div>
                </div>

                @if ($orders->count())
                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">
                        <div class="p-3">
                            <div class="">
                                <table class="table w-full">
                                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-800 ">
                                        @foreach ($orders as $order)
                                            <tr class="">
                                                <td class="p-2 whitespace-nowrap py-3">
                                                    <div class="text-gray-300 items-center">
                                                        <div
                                                            class="flex justify-between text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800 py-1 px-2 border-l-4 border-indigo-500">
                                                            <div class="flex">
                                                                Ordine:
                                                                <div class="font-semibold text-gray-800 pl-1">
                                                                    {{ $order->uuid }}
                                                                </div>
                                                            </div>
                                                            <div
                                                                title="{{ $order->created_at->translatedFormat('d.m.Y H:i') }}">
                                                                creato:
                                                                <span class="font-medium text-gray-800">
                                                                    {{ $order->created_at->diffForHumans() }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <table class="table w-full ">
                                                            @foreach ($order->products as $product)
                                                                <tr>
                                                                    <td class="p-2 whitespace-nowrap w-32">
                                                                        <x-product-uuid-cell>
                                                                            {{ $product->uuid }}
                                                                        </x-product-uuid-cell>
                                                                    </td>
                                                                    <td class="p-2 whitespace-nowrap text-left">
                                                                        <x-product-name-cell :href="route('warehouse.product.show', [
                                                                            $warehouse,
                                                                            $product,
                                                                        ])">
                                                                            {{ $product->name }}
                                                                        </x-product-name-cell>
                                                                    </td>
                                                                    <td class="p-2 whitespace-nowrap text-right">
                                                                        <div class=" text-gray-400 text-sm py-1">
                                                                            qty: {{ $product->pivot->quantity }}
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>

                                                    </div>
                                                </td>
                                                {{-- <td class="p-2">
                                                <div class="text-center dark:text-gray-300">
                                                    {{ $order->created_at->translatedFormat('d.m.Y') }}
                                                    &middot;
                                                    {{ $order->created_at->translatedFormat('H:i') }}
                                                </div>
                                            </td> --}}
                                                <td class="p-2">
                                                    <x-order-status
                                                        class="rounded-lg text-xs uppercase py-2 px-3 text-center"
                                                        :status="$order->status" />
                                                </td>
                                                <td class="px-3 py-3 w-8">
                                                    @include('order.dropdown')
                                                </td>
                                                <td class="text-right px-3 py-3 w-10">
                                                    <a href="{{ route('warehouse.order.show', [$warehouse, $order->id]) }}"
                                                        class="font-medium text-gray-800 text-lg hover:underline dark:text-gray-300">
                                                        <i class="fa-solid fa-angle-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="max-w-7xl mx-auto sm:px-6 lg:px-8 items-center text-center text-4xl py-16 text-gray-500 font-medium">
                        <div class=" text-4xl text-gray-200 font-medium py-10" style="font-size: 90px">
                            <i class="fa-regular fa-circle-exclamation"></i>
                        </div>
                        <div class=" p-2">
                            Non sono presenti ordini
                            @if ($show != 'all') pendenti @endif
                        </div>

                    </div>
                @endif

            </div>

            <div class="w-full max-w-7xl mx-auto pt-6">
                <?php echo $orders->appends(['search' => $search ?? '', 'show' => $show])->links(); ?>
            </div>
        </div>
    </section>

</x-app-layout>
