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
			border: 1px solid #dee2e6;
			border-top: none;
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
			<div class="card-header bg-white border-bottom-0">
				<ul class="nav nav-tabs nav-justified flex-column flex-sm-row" id="tournamentTabs" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="jugadores-tab" data-bs-toggle="tab" data-bs-target="#jugadores" type="button" role="tab">👤 Jugadores</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="grupos-tab" data-bs-toggle="tab" data-bs-target="#grupos" type="button" role="tab">📋 Grupos</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="ajuste-tab" data-bs-toggle="tab" data-bs-target="#ajuste" type="button" role="tab">⚙ Ajuste</button>
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
					<div class="d-flex justify-content-center align-items-center mt-1 mb-3">

						<button wire:click="showModalNewPlayerForTournament()" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador
						</button>
						<livewire:tournaments.tournament.modal-registrar-jugador-tournament />
					</div>
					<div class="table-responsive mt-3">
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
								@foreach ($playersTournament as $p)
								<tr>
									<td><i class="bi bi-person-circle me-1 text-primary"></i>{{$p->player->name_player}}</td>
									<td>{{$p->horario}}</td>
									<td>{{$p->player->club->name}}</td>
									<td><span>{{$p->player->state->name}}</span></td>
									<td>
										@php
										$categoria = $p->player->category->name ?? '';
										$clase = match($categoria) {
										'Maestro' => 'badge bg-success text-white',
										'Primera' => 'badge bg-warning text-dark',
										'Segunda' => 'badge bg-primary text-white',
										'Terceras' => 'badge bg-info text-white',
										default => 'badge bg-secondary text-white',
										};
										@endphp
										<span class="{{ $clase }}">{{ $categoria }}</span>
									</td>
									<td>
										<input type="number" class="form-control form-control-sm text-center mx-auto d-block" style="width: 90px;" placeholder="N°" min="1">
									</td>
								</tr>
								@endforeach


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
</div>