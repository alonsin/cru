<div>
	<style>
		.nav-tabs .nav-link {
			font-weight: 500;
			color: #495057;
			border: none;
			background-color: #f8f9fa;
			transition: all 0.3s ease;
			margin: 2px;
			border-radius: 0.5rem 0.5rem 0 0;
		}

		.nav-tabs .nav-link.active {
			background-color: #4b6584;
			color: white;
			font-weight: bold;
			box-shadow: inset 0 -3px 0 rgba(0, 0, 0, 0.15);
		}

		.nav-tabs .nav-link:hover {
			background-color: #e2e6ea;
			color: #0d6efd;
		}

		.tab-content {
			background-color: #ffffff;
			padding: 1.5rem;
			border-radius: 0 0 0.5rem 0.5rem;
		}

		.card-header.bg-white {
			background: linear-gradient(135deg, #f8f9fa, #e9ecef);
			border-bottom: 2px solid #dee2e6;
		}
	</style>
	<div class="container mt-5">
		<h1 class="text-center font-semibold text-xl text-gray-600"> {{ strtoupper($tournament->name_tournament) }}</h1>
		<h3 class="text-center font-semibold text-sm text-gray-600"> {{ \Carbon\Carbon::parse($tournament->fecha_torneo)->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</h3>
		<div class="card shadow-sm rounded-4 mt-5 border-0">
			<div class="card-header bg-light border-bottom-0">
				<ul class="nav nav-tabs nav-justified flex-column flex-sm-row" id="tournamentTabs" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link @if($activeTab === 'jugadores') active @endif" id="jugadores-tab" data-bs-toggle="tab" data-bs-target="#jugadores" type="button" role="tab">👤 Jugadores</button>
					</li>
					<li class="nav-item" role="presentation">
						<button wire:click="setDataTournament" class="nav-link @if($activeTab === 'grupos') active @endif" id="grupos-tab" data-bs-toggle="tab" data-bs-target="#grupos" type="button" role="tab">📋 Grupos</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="ajuste-tab" data-bs-toggle="tab" data-bs-target="#ajuste" type="button" role="tab">🎯 Subita</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="ajuste16-tab" data-bs-toggle="tab" data-bs-target="#ajuste16" type="button" role="tab">🎯 Ronda 16</button>
					</li>
					<!-- <li class="nav-item" role="presentation">
						<button class="nav-link" id="ronda32-tab" data-bs-toggle="tab" data-bs-target="#ronda32" type="button" role="tab">🎯 Ronda 32</button>
					</li> -->
					<!-- <li class="nav-item" role="presentation">
						<button class="nav-link" id="ronda16-tab" data-bs-toggle="tab" data-bs-target="#ronda16" type="button" role="tab">🎯 Ronda 16</button>
					</li> -->
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="finales-tab" data-bs-toggle="tab" data-bs-target="#finales" type="button" role="tab">🏆 Finales</button>
					</li>
				</ul>
			</div>
			<div class="card-body tab-content p-4" id="tournamentTabsContent">
				<div class="tab-pane fade @if($activeTab === 'jugadores') show active @endif" id="jugadores" role="tabpanel">
					<div class="d-flex justify-content-center align-items-center mt-1 mb-3">
						<button wire:click="showModalNewPlayerForTournament()" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador {{$idtournament}}
						</button>

						<button wire:click="saveSorteo()" class="btn btn-secondary btn-sm ms-2">
							<i class="bi bi-plus-circle me-1"></i> Guardar Sorteo
						</button>

						<livewire:tournaments.tournament.modal-registrar-jugador-tournament />
					</div>

					<div class="overflow-x-auto">
						<livewire:tournaments.tournament.tournament-players-table />
					</div>
				</div>
				<div class="tab-pane fade @if($activeTab === 'grupos') show active @endif" id="grupos" role="tabpanel">
					<livewire:tournaments.tournament.tournament-players-group />					
				</div>
				<div class="tab-pane fade" id="ajuste" role="tabpanel">
					<livewire:tournaments.tournament.tournament-players-subita  id_tournament="{{$idtournament}}"/>
				</div>
				<div class="tab-pane fade" id="ajuste16" role="tabpanel">
					<livewire:tournaments.tournament.tournament-players-ajuste16  id_tournament="{{$idtournament}}"/>
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

	@script
	<script>
		Livewire.on('error-duplicados-sorteo', e => {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				html: '<b>No se puede guardar</b><br>Hay números de sorteo repetidos.',
				confirmButtonText: 'Entendido'
			});
		});

		Livewire.on('sorteos-guardados', () => {
			Swal.fire({
				icon: 'success',
				title: '¡Guardado!',
				text: 'Los sorteos se han guardado correctamente.',
				timer: 2000,
				showConfirmButton: false
			});
		});

		Livewire.on('grupos-guardados', () => {
			Swal.fire({
				icon: 'success',
				title: '¡Guardado!',
				text: 'La información de grupos de ha actualizado correctamente.',
				timer: 2000,
				showConfirmButton: false
			});
		});
	</script>
	@endscript

</div>