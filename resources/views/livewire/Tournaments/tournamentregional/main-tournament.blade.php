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

		#grupoTabs .nav-link.active {
			background-color: #e9ecef !important;
			/* gris claro */
			color: #000 !important;
			border-color: #dee2e6 #dee2e6 #fff;
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
						<button wire:click="setActiveTab('jugadores')" class="nav-link @if($activeTab === 'jugadores') active @endif" id="jugadores-tab" data-bs-toggle="tab" data-bs-target="#jugadores" type="button" role="tab">👤 Jugadores</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link  @if($activeTab === 'subita') active @endif" id="ajuste-tab" wire:click="setActiveTab('subita')" data-bs-toggle="tab" data-bs-target="#ajuste" type="button" role="tab">🎯 Subita</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link  @if($activeTab === 'ajusteTo32') active @endif" id="ajuste16-tab" wire:click="setActiveTab('ajusteTo32')" data-bs-toggle="tab" data-bs-target="#ajuste16" type="button" role="tab">👀 Ajuste para 32</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link  @if($activeTab === 'ronda16') active @endif" id="ajuste16-tab" wire:click="setActiveTab('ronda16')" data-bs-toggle="tab" data-bs-target="#ajuste16" type="button" role="tab">🎯 Ronda 16</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link  @if($activeTab === 'finales') active @endif" id="finales-tab" wire:click="setActiveTab('finales')" data-bs-toggle="tab" data-bs-target="#finales" type="button" role="tab">🏆 Finales</button>
					</li>
				</ul>
			</div>
			<div class="card-body tab-content p-4" id="tournamentTabsContent">
				<div class="tab-pane fade @if($activeTab === 'jugadores') show active @endif" id="jugadores" role="tabpanel">
					<livewire:tournaments.tournament-regional.main-tournament-players id_tournament="{{$idtournament}}" />
				</div>
				<div class="tab-pane fade @if($activeTab === 'subita') show active @endif" id="ajuste" role="tabpanel">
					<livewire:tournaments.tournament-regional.tournament-players-subita id_tournament="{{$idtournament}}" />
				</div>
				<div class="tab-pane fade @if($activeTab === 'ajusteTo32') show active @endif" id="ajuste16" role="tabpanel">
					<livewire:tournaments.tournament-regional.tournament-players-ajuste16 id_tournament="{{$idtournament}}" />
				</div>
				<div class="tab-pane fade @if($activeTab === 'ronda16') show active @endif" id="ajuste16" role="tabpanel">
					<livewire:tournaments.tournament-regional.tournament-players-ajuste16 id_tournament="{{$idtournament}}" />
				</div>
				<div class="tab-pane fade @if($activeTab === 'finales') show active @endif" id="finales" role="tabpanel">
					<livewire:tournaments.tournament-regional.tournament-players-finals id_tournament="{{$idtournament}}" />
				</div>
			</div>

			<livewire:tournaments.tournament-regional.modal-registrar-jugador-tournament />

		</div>
	</div>

	@script
	<script>
		Livewire.on('error-duplicados-sorteo', e => {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				html: '<b>No se puede guardar</b><br>Hay números de sorteo repetidos en este horario.',
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

		Livewire.on('general-guardado', () => {
			Swal.fire({
				icon: 'success',
				title: '¡Actualizado!',
				text: 'La información se ha actualizado correctamente.',
				timer: 2000,
				showConfirmButton: false
			});
		});
	</script>
	@endscript

</div>