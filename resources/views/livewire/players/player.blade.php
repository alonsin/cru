
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            {{ __('LISTA DE JUGADORES REGISTRADOS') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:players.player-main />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


