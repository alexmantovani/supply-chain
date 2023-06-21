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
    <x-slot name="navbar_left_menu">
        @include('layouts.nav_left_bar', ['warehouse' => $warehouse])
    </x-slot>
    <x-slot name="navbar_right_menu">
        <a href="{{ route('warehouse.refill.create', $warehouse) }}">
            <x-secondary-button class="">
                <i class="fa-solid fa-plus"></i> &nbsp; Aggiungi
            </x-secondary-button>
        </a>
    </x-slot>

    @livewire('refill-index', ['warehouse' => $warehouse, 'refills' => $refills])

    {{-- <script>
        function dropdownFunction(element) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            let list = element.parentElement.parentElement.getElementsByClassName("dropdown-content")[0];
            list.classList.add("target");
            for (i = 0; i < dropdowns.length; i++) {
                if (!dropdowns[i].classList.contains("target")) {
                    dropdowns[i].classList.add("hidden");
                }
            }
            list.classList.toggle("hidden");
        }

        function handleClick(element) {
            var id = $(element).attr('data-id');
            var dati = $('#delete_' + id + ' :input').serialize();
            console.log(id);
            // $.ajax({
            //     url: "{ route('price_list.update.analisys') }?" + dati,
            //        type: 'DELETE'
            // }).done(function(data) {
            //     document.getElementById('commission_' + id).value = data['commission'];
            // });
        }

    </script> --}}

</x-app-layout>
