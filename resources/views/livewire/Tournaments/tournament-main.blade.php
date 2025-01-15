<div>
    <div class="p-6 lg:p-5 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-1">
            <div class="overflow-x-auto">

                <div class="flex justify-center w-full mt-2">
                    <button wire:click="showModalNewTournament()" class="bg-lime-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Crear Nuevo Torneo
                    </button>
                    <livewire:players.modal-registrar-jugador />
                </div>

                <div class="container mx-auto p-4">
                    <livewire:tournaments.modal-registrar-torneo />
                    <!-- Listado de Cards -->
                    <!-- Contenedor con Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Card 1 -->
                        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Imagen del torneo -->
                            <div class="w-full md:w-auto p-4 flex justify-center">
                                <img src="{{ asset('images/cru-img-removebg-preview.png') }}" style="width: 160px; height: auto;" class="size-20" alt="Logo" class="">
                            </div>
                            <!-- Información del torneo -->
                            <div class="w-full md:flex-grow p-4">
                                <h2 class="text-xl font-bold text-gray-800">1as y 2as PARCHE</h2>
                                <p class="text-gray-600">Fecha: <span class="font-semibold">10 de Enero de 2025</span></p>
                                <p class="text-gray-600">Sede: <span class="font-semibold">Cambola PARCHE</span></p>
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

                        <!-- Card 2 -->
                        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Imagen del torneo -->
                            <div class="w-full md:w-auto p-4 flex justify-center">
                                <img src="{{ asset('images/cru-img-removebg-preview.png') }}" style="width: 160px; height: auto;" class="size-20" alt="Logo" class="">
                            </div>
                            <!-- Información del torneo -->
                            <div class="w-full md:flex-grow p-4">
                                <h2 class="text-xl font-bold text-gray-800">Mensual Abierto (CRU)</h2>
                                <p class="text-gray-600">Fecha: <span class="font-semibold">15 de Enero de 2025</span></p>
                                <p class="text-gray-600">Sede: <span class="font-semibold">Club Rrecreativo Universidad</span></p>
                                <!-- Estatus del torneo y botón -->
                                <div class="flex items-center justify-between mt-2">
                                    <p
                                        class="text-xs font-bold inline-block px-3 py-1 rounded-full text-white"
                                        style="background-color: #F87171;">
                                        Finalizado
                                    </p>
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full transition duration-300">
                                        Ver Torneo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contenedor con Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <!-- Card 1 -->
                        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Imagen del torneo -->
                            <div class="w-full md:w-auto p-4 flex justify-center">
                                <img src="{{ asset('images/cru-img-removebg-preview.png') }}" style="width: 160px; height: auto;" class="size-20" alt="Logo" class="">
                            </div>
                            <!-- Información del torneo -->
                            <div class="w-full md:flex-grow p-4">
                                <h2 class="text-xl font-bold text-gray-800">Mensual de Segundas Fuerzas</h2>
                                <p class="text-gray-600">Fecha: <span class="font-semibold">10 de Enero de 2025</span></p>
                                <p class="text-gray-600">Sede: <span class="font-semibold">Club Recreativo Universidad</span></p>
                                <!-- Estatus del torneo y botón -->
                                <div class="flex items-center justify-between mt-2">
                                    <p
                                        class="text-xs font-bold inline-block px-3 py-1 rounded-full text-white"
                                        style="background-color: #F87171;">
                                        Finalizado
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