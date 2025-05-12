<div>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    <div class="p-6 lg:p-5 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-1">
            <div class="overflow-x-auto">

                @if ($selectedTournament)
                <div class="container mt-5">
                    <h1 class="text-center font-semibold text-xl text-gray-600"> {{ strtoupper($selectedTournament->name_tournament) }}</h1>
                    <h3 class="text-center font-semibold text-sm text-gray-600"> {{ \Carbon\Carbon::parse($selectedTournament->fecha_torneo)->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</h3>
                    <div class="card shadow-sm rounded-4 mt-5 border-0">
                        <div class="card-header bg-white border-bottom-0">
                            <ul class="nav nav-tabs nav-justified flex-column flex-sm-row" id="tournamentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="jugadores-tab" data-bs-toggle="tab" data-bs-target="#jugadores" type="button" role="tab">👤 Jugadores</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="grupos-tab" data-bs-toggle="tab" data-bs-target="#grupos" type="button" role="tab">📋 Grupos</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="ajuste-tab" data-bs-toggle="tab" data-bs-target="#ajuste" type="button" role="tab">📋 Ajuste</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="ronda32-tab" data-bs-toggle="tab" data-bs-target="#ronda32" type="button" role="tab">🎯 Ronda 32</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="ronda16-tab" data-bs-toggle="tab" data-bs-target="#ronda16" type="button" role="tab">🎯 Ronda 16</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="finales-tab" data-bs-toggle="tab" data-bs-target="#finales" type="button" role="tab">🏆 Finales</button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body tab-content p-4" id="tournamentTabsContent">
                            <div class="tab-pane fade show active" id="jugadores" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">

                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i> Agregar Jugador
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle bg-white shadow rounded-3 overflow-hidden">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th class="text-muted">Nombre</th>
                                                <th class="text-muted">Horario</th>
                                                <th class="text-muted">Club</th>
                                                <th class="text-muted">Estado</th>
                                                <th class="text-muted">Categoría</th>
                                                <th class="text-muted">Sorteo</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Carlos Mendoza</td>
                                                <td>10:00 AM</td>
                                                <td>Club Centenario</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-success text-white">Maestro</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Roberto Díaz</td>
                                                <td>11:30 AM</td>
                                                <td>Billar El Diamante</td>
                                                <td><span>Jalisco</span></td>
                                                <td><span class="badge bg-warning text-dark">Primer Fuerza</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> José Ramírez</td>
                                                <td>01:00 PM</td>
                                                <td>Águila Real</td>
                                                <td><span>CDMX</span></td>
                                                <td><span class="badge bg-info">Tercera Fuerza</span></td>
                                                <td><input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Alonso Ruiz</td>
                                                <td>03:00 PM</td>
                                                <td>MasterShot</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-primary">Sgunda Fuerza</span></td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Carlos Mendoza</td>
                                                <td>10:00 AM</td>
                                                <td>Club Centenario</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-success text-white">Maestro</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Roberto Díaz</td>
                                                <td>11:30 AM</td>
                                                <td>Billar El Diamante</td>
                                                <td><span>Jalisco</span></td>
                                                <td><span class="badge bg-warning text-dark">Primer Fuerza</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> José Ramírez</td>
                                                <td>01:00 PM</td>
                                                <td>Águila Real</td>
                                                <td><span>CDMX</span></td>
                                                <td><span class="badge bg-info">Tercera Fuerza</span></td>
                                                <td><input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Alonso Ruiz</td>
                                                <td>03:00 PM</td>
                                                <td>MasterShot</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-primary">Sgunda Fuerza</span></td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Carlos Mendoza</td>
                                                <td>10:00 AM</td>
                                                <td>Club Centenario</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-success text-white">Maestro</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Roberto Díaz</td>
                                                <td>11:30 AM</td>
                                                <td>Billar El Diamante</td>
                                                <td><span>Jalisco</span></td>
                                                <td><span class="badge bg-warning text-dark">Primer Fuerza</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> José Ramírez</td>
                                                <td>01:00 PM</td>
                                                <td>Águila Real</td>
                                                <td><span>CDMX</span></td>
                                                <td><span class="badge bg-info">Tercera Fuerza</span></td>
                                                <td><input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Alonso Ruiz</td>
                                                <td>03:00 PM</td>
                                                <td>MasterShot</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-primary">Sgunda Fuerza</span></td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Carlos Mendoza</td>
                                                <td>10:00 AM</td>
                                                <td>Club Centenario</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-success text-white">Maestro</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Roberto Díaz</td>
                                                <td>11:30 AM</td>
                                                <td>Billar El Diamante</td>
                                                <td><span>Jalisco</span></td>
                                                <td><span class="badge bg-warning text-dark">Primer Fuerza</span></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> José Ramírez</td>
                                                <td>01:00 PM</td>
                                                <td>Águila Real</td>
                                                <td><span>CDMX</span></td>
                                                <td><span class="badge bg-info">Tercera Fuerza</span></td>
                                                <td><input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="bi bi-person-circle me-1 text-primary"></i> Alonso Ruiz</td>
                                                <td>03:00 PM</td>
                                                <td>MasterShot</td>
                                                <td><span>Michoacán</span></td>
                                                <td><span class="badge bg-primary">Sgunda Fuerza</span></td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="grupos" role="tabpanel">
                                <h5>Grupos del Torneo</h5>
                                <p>Aquí se muestran los grupos generados para el torneo.</p>
                            </div>
                            <div class="tab-pane fade" id="ajuste" role="tabpanel">
                                <h5>Configuración</h5>
                                <p>Ajustes del torneo (nombre, reglas, sede, etc.).</p>
                            </div>
                            <div class="tab-pane fade" id="ronda32" role="tabpanel">
                                <h5>Ronda de 32</h5>
                                <p>Visualiza y gestiona los partidos de la ronda de 32.</p>
                            </div>
                            <div class="tab-pane fade" id="ronda16" role="tabpanel">
                                <h5>Ronda de 16</h5>
                                <p>Visualiza y gestiona los partidos de la ronda de 16.</p>
                            </div>
                            <div class="tab-pane fade" id="finales" role="tabpanel">
                                <h5>Finales</h5>
                                <p>Semifinales y Final del torneo.</p>
                            </div>
                        </div>
                    </div>
                </div>


                @else
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
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex flex-col md:flex-row bg-white rounded-lg overflow-hidden">
                                    <!-- Imagen del torneo -->
                                    <div class="w-full md:w-auto p-4 flex justify-center">
                                        <img src="{{ asset('images/cru-img-removebg-preview.png') }}" style="width: 160px; height: auto;" class="size-20" alt="Logo" class="">
                                    </div>
                                    <!-- Información del torneo -->
                                    <div class="w-full md:flex-grow p-4">
                                        <h2 class="text-xl font-bold text-gray-800">{{ $tournament->name_tournament }}</h2>
                                        <p class="text-gray-600">Fecha: <span class="font-semibold"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($tournament->fecha_torneo)->format('d/m/Y') }}</span></p>
                                        <p class="text-gray-600">Sede: <span class="font-semibold">{{$tournament->sede->name}}</span></p>
                                        <!-- Estatus del torneo y botón -->
                                        <div class="flex items-center justify-between mt-2">
                                            <p
                                                class="text-xs font-bold inline-block px-3 py-1 rounded-full text-white"
                                                style="background-color: {{ $tournament->status == 1 ? '#10B981' : '#FBBF24' }};">
                                                {{ $tournament->status == 1 ? 'En curso' : 'Terminado' }}
                                            </p>
                                            <button
                                                wire:click="viewTournament({{ $tournament->id }})"
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
                @endif

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