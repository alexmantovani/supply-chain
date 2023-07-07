<x-app-layout>
    <x-slot name="navbar_right_menu">
        @include('layouts.nav_right_bar', ['warehouse' => $warehouse])
    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-1 md:p-4 dark:bg-gray-800">
        <div class="h-full ">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto ">
                <div
                    class="md:bg-white md:shadow-lg rounded-sm md:border border-gray-200 md:px-8 dark:bg-gray-900 dark:border-gray-700">

                    <div class="flex justify-between my-2 md:my-4">
                        <div class="pb-6">
                            <div class="text-2xl font-light pt-4 text-gray-400 dark:text-gray-300">
                                Ordine
                                <a href="{{ route('warehouse.order.show', [$warehouse, $order]) }}">
                                    <span class="font-semibold text-gray-700 dark:text-gray-100">
                                        {{ $order->uuid }}
                                    </span>
                                </a>
                            </div>
                            <div class="text-base text-gray-400">
                                effettuato il
                                <span class="text-gray-600 dark:text-gray-200 font-semibold">
                                    {{ $order->created_at->translatedFormat('d M Y') }}
                                </span>
                                alle
                                <span class="text-gray-600 dark:text-gray-200 font-semibold">
                                    {{ $order->created_at->translatedFormat('H.i') }}
                                </span>
                            </div>
                        </div>

                        <div class="my-4 flex items-top">
                            <div class="md:w-40 mt-1">
                                <x-order-status
                                    class="text-xs font-semibold uppercase py-1 border-r-4 text-gray-700 text-right px-2"
                                    :status="$order->status" />
                            </div>
                            {{-- @include('order.dropdown') --}}
                        </div>
                    </div>

                    @livewire('order-partial', ['warehouse' => $warehouse, 'order' => $order])
                </div>

                @if ($order->status == 'pending' || $order->status == 'waiting')
                    <div class="p-3 text-gray-600 dark:text-gray-400 text-sm">
                        In alternativa puoi chiudere l'ordine malgrado non sia arrivato tutto il materiale cliccando
                        <a href="{{ route('order.closed', $order) }}"
                            class="font-semibold hover:underline text-gray-800 dark:text-gray-200">
                            qui
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </section>

</x-app-layout>
