<div>
    <div class="p-6 lg:p-5 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-1">
            <div class="overflow-x-auto">

                <div class="flex justify-end w-full mt-2 ">
                    <button wire:click="showModalNewTournament()" class="mr-5 bg-lime-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Crear Nuevo Torneo
                    </button>
                    <livewire:players.modal-registrar-jugador />
                </div>

                <div class="container mx-auto p-2">
                    <livewire:tournaments.modal-registrar-torneo />
                    <!-- Listado de Cards -->

                    @foreach ($tournamentsArray as $tournament)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
                                    <!-- Imagen del torneo -->
                                    <div class="w-full md:w-auto p-4 flex justify-center">
                                        <img src="{{ asset('images/cru-img-removebg-preview.png') }}" style="width: 160px; height: auto;" class="size-20" alt="Logo" class="">
                                    </div>
                                    <!-- Información del torneo -->
                                    <div class="w-full md:flex-grow p-4">
                                        <h2 class="text-xl font-bold text-gray-800">{{ $tournament->name_tournament }}</h2>
                                        <p class="text-gray-600">Fecha: <span class="font-semibold"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($tournament->fecha_torneo)->format('d/m/Y') }}</span></p>
                                        <p class="text-gray-600">Sede: <span class="font-semibold">{{$tournament->id_type}}</span></p>
                                        <!-- Estatus del torneo y botón -->
                                        <div class="flex items-center justify-between mt-2">
                                            <p
                                                class="text-xs font-bold inline-block px-3 py-1 rounded-full text-white"
                                                style="background-color: #10B981;">
                                                En curso
                                            </p>
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full transition duration-300">
                                                Ver Torneo
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Livewire.on('onconfirmDelete', (id) => {
                    Swal.fire({
                        title: '¿Estás seguro de elimiar el registro?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Livewire.emit('deleteConfirmed', id);
                            Livewire.dispatch('deletePlayerEvent');
                        }
                    });
                });
            });
        </script>
    </div>
</div>