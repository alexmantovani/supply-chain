<x-app-layout>
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
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen md:p-4 dark:bg-gray-900">
        <div class="h-full ">
            <div class="w-full max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    @foreach ($statusCounters as $status => $count)
                        <div href="#"
                            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                            <div class="flex justify-end">
                                <div class="pb-3">
                                    <img src="{{ url('/images/' . $status . '.png') }}" class="h-16 object-scale-down">
                                </div>
                            </div>
                            <h5 class="mb-2 text-4xl font-bold tracking-tight text-gray-900 dark:text-white ">
                                {{ $count }}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 uppercase">
                                {{ trans_choice('statuses.' . $status, $count) }}
                            </p>
                        </div>
                    @endforeach

                </div>
                <div class="flex justify-between items-baseline">
                    <div class=" text-gray-900 dark:text-gray-300 text-xl p-3 font-semibold">
                        Elenco ordini
                    </div>
                    <div class="font-semibold uppercase pr-3">
                        <a href="{{ route('warehouse.order.index', [$warehouse, 'show' => 'pending']) }}"
                            class="py-1
                    @if ($show === 'pending') text-red-500 border-b border-red-400 dark:text-red-600 @endif
                    ">
                            In corso
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('warehouse.order.index', [$warehouse, 'show' => 'all']) }}"
                            class="py-1
                    @if ($show === 'all') text-red-500 border-b border-red-400 dark:text-red-600 @endif
                    ">
                            Tutti
                        </a>
                    </div>
                </div>

                @if ($orders->count())
                    <div
                        class="bg-white shadow-lg rounded-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">
                        <div class="md:p-3">
                            <div class="">
                                <table class="table w-full">
                                    <tbody class="text-sm divide-y divide-red-100 dark:divide-red-800">
                                        @foreach ($orders as $order)
                                            <tr class="">
                                                <td class="py-3">
                                                    <div class="text-gray-300 items-center">
                                                        <div
                                                            class="flex justify-between text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-gray-800 border-l-4 border-gray-500">
                                                            <div class="flex p-2 space-x-1">
                                                                @if ($order->urgent)
                                                                    <div title="Ordine urgente">
                                                                        🔥
                                                                    </div>
                                                                @endif
                                                                <div class="hidden md:flex">
                                                                    Ordine:
                                                                </div>
                                                                <a
                                                                    href="{{ route('warehouse.order.show', [$warehouse, $order->id]) }}">
                                                                    <div
                                                                        class="font-semibold text-gray-800 dark:text-gray-200">
                                                                        {{ $order->uuid }}
                                                                    </div>
                                                                </a>
                                                                <div class="hidden md:flex">
                                                                    &middot;
                                                                    Fornitore:
                                                                </div>
                                                                <div
                                                                    class="font-semibold text-gray-800 dark:text-gray-200 hidden md:flex">
                                                                    {{ $order->provider_name }}
                                                                </div>
                                                                <div class="text-gray-400 dark:text-gray-800">
                                                                    &middot;
                                                                    {{ $order->created_at->diffForHumans() }}
                                                                </div>
                                                            </div>

                                                            <x-order-status-gradient
                                                                class="w-30 md:w-40 text-xs font-semibold uppercase border-r-4 text-gray-800 text-right p-2"
                                                                :status="$order->status" />
                                                        </div>

                                                        <table class="table w-full ">
                                                            @foreach ($order->products as $product)
                                                                <tr>
                                                                    <td class="px-1 w-28">
                                                                        <x-product-uuid-cell class="w-28">
                                                                            {{ $product->uuid }}
                                                                        </x-product-uuid-cell>
                                                                    </td>
                                                                    <td class="px-1 text-left">
                                                                        <x-product-name-cell :href="route('warehouse.product.show', [
                                                                            $warehouse,
                                                                            $product,
                                                                        ])">
                                                                            {{ $product->name }}
                                                                        </x-product-name-cell>
                                                                    </td>
                                                                    <td class="px-1 text-right">
                                                                        @if ($product->pivot->quantity > 0)
                                                                            <div class=" text-gray-400 text-sm py-1">
                                                                                {{ $product->pivot->quantity }}
                                                                            </div>
                                                                        @else
                                                                            {{-- TODO: Al RUA permettere di inserire la quantità --}}
                                                                            <div class="text-red-600 text-sm py-1">
                                                                                {{ $product->pivot->quantity }}
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td class="pr-1 w-4 text-left">
                                                                        <x-product-arrived :arrived="$product->isArrived()"
                                                                            status="{{ $order->status }}"
                                                                            class="text-xs" />
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </td>

                                                <td class="w-2 align-top ">
                                                    <div class="text-center py-4">
                                                        @include('order.dropdown')
                                                    </div>
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
                        class="max-w-7xl mx-auto sm:px-6 px-2 lg:px-8 items-center text-center text-4xl py-8 lg-py-16 text-gray-200 dark:text-gray-700 font-medium">
                        <div class="flex justify-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-28 h-28">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>

                        <div class="p-2 text-gray-600 dark:text-gray-300">
                            Non sono presenti ordini
                            @if ($show != 'all')
                                pendenti
                            @endif
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
