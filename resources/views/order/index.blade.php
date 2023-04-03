<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Storico ordini') }}
            </h2>
            <div>
                <a href="{{ route('order.index') }}"
                class="">
                    In lavorazione
                </a>
                 &nbsp; | &nbsp;
                 <a href="{{ route('order.index', ['all']) }}">
                    Tutti
                </a>
            </div>
        </div>

    </x-slot>

    <section class="justify-center antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="h-full ">
            <!-- Table -->
            <form method="post" action="{{ route('order.store') }}">
                @csrf
                <div class="w-full max-w-7xl mx-auto ">
                    <div class="bg-white shadow-lg rounded-sm border border-gray-200 px-8">

                        <div class="p-3">
                            <div class="">
                                <table class="table-auto w-full ">
                                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                        <tr>
                                            <th class="p-2 whitespace-nowrap">
                                                <div class="font-semibold text-left">Fornitore</div>
                                            </th>
                                            <th class="p-2 whitespace-nowrap">
                                                <div class="font-semibold text-center">Data</div>
                                            </th>
                                            <th class="p-2 w-40">
                                                <div class="font-semibold">Stato</div>
                                            </th>
                                            <th class="p-2 whitespace-nowrap">
                                                <div class="font-semibold text-center">
                                                    Azioni
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-sm divide-y divide-gray-100">
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class=" items-center">
                                                        {{-- <div class="w-10 h-10 flex-shrink-0 mr-2 sm:mr-3"><img
                                                        class="rounded-full"
                                                        src="https://raw.githubusercontent.com/cruip/vuejs-admin-dashboard-template/main/src/images/user-36-05.jpg"
                                                        width="40" height="40" alt="Alex Shatov"></div> --}}
                                                        {{-- <div class="font-medium text-gray-800 text-lg">
                                                            {{ $order->product->name }}
                                                        </div> --}}
                                                        <a href="{{ route('order.show', $order->id) }}"
                                                            class="font-medium text-gray-800 text-lg hover:underline">
                                                            {{ $order->dealer->name }}
                                                        </a>

                                                        @foreach ($order->products as $product)
                                                            <div class=" text-gray-400 text-xs py-1">
                                                                <div>
                                                                    {{ $product->name }} &middot;
                                                                    {{ $product->pivot->quantity }} articoli
                                                                </div>
                                                            </div>
                                                        @endforeach


                                                    </div>
                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-center">
                                                        {{ $order->created_at }}
                                                    </div>
                                                </td>
                                                <td class="p-2 ">
                                                    <div
                                                        class="text-center font-medium uppercase rounded-lg py-2 px-3 text-xs {!! $order->status_color !!}">
                                                        {!! $order->status !!}
                                                    </div>
                                                </td>
                                                <td class="text-right px-3 py-3 w-40">
                                                    @if ($order->status == 'In attesa')
                                                        <div class="text-center">
                                                            <a href="{{ route('order.completed', $order) }}"
                                                                type="button"
                                                                class="text-xs uppercase p-3 m-3 border rounded-lg bg-blue-400 hover:underline text-white text-center"
                                                                title="Clicca qui per indicare che il materiale è arrivato e ubicato in magazzino">
                                                                <i class="fas fa-box"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                    @endif
                                                    {{-- <a href=""
                                                        class=" text-right border text-gray-600 rounded-lg py-2 px-3 text-base uppercase">
                                                        <i class="far fa-ellipsis-v"></i>
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="w-full max-w-7xl mx-auto pt-6">
                <?php echo $orders->appends(['search' => $search ?? ''])->links(); ?>
            </div>
        </div>
    </section>

</x-app-layout>
