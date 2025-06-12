<div>
	<div class="justify-content-center align-items-center mt-1 mb-3">
		<div class="nav nav-tabs d-flex mt-4" id="grupoTabs" role="tablist">
			<button wire:click="setActiveTab2('jugadores1')" class="nav-link flex-fill text-center @if($activeTab2 === 'jugadores1') active @endif text-dark" id="grupo14-tab"
				data-bs-toggle="tab" data-bs-target="#grupo14" type="button" role="tab"
				aria-controls="grupo14" aria-selected="true">
				13:00 Hrs
			</button>
			<button wire:click="setActiveTab2('jugadores2')" class="nav-link flex-fill text-center @if($activeTab2 === 'jugadores2') active @endif text-dark" id="grupo17-tab"
				data-bs-toggle="tab" data-bs-target="#grupo17" type="button" role="tab"
				aria-controls="grupo17" aria-selected="false">
				14:00 Hrs
			</button>
			<button wire:click="setActiveTab2('jugadores3')" class="nav-link flex-fill text-center @if($activeTab2 === 'jugadores3') active @endif text-dark" id="grupo14-tab"
				data-bs-toggle="tab" data-bs-target="#grupo14" type="button" role="tab"
				aria-controls="grupo14" aria-selected="true">
				15:00 Hrs
			</button>
			<button wire:click="setActiveTab2('jugadores4')" class="nav-link flex-fill text-center @if($activeTab2 === 'jugadores4') active @endif text-dark" id="grupo17-tab"
				data-bs-toggle="tab" data-bs-target="#grupo17" type="button" role="tab"
				aria-controls="grupo17" aria-selected="false">
				16:00 Hrs
			</button>
			<button wire:click="setActiveTab2('jugadores5')" class="nav-link flex-fill text-center @if($activeTab2 === 'jugadores5') active @endif text-dark" id="grupo17-tab"
				data-bs-toggle="tab" data-bs-target="#grupo17" type="button" role="tab"
				aria-controls="grupo17" aria-selected="false">
				17:00 Hrs
			</button>
		</div>

		<!-- Tab Content -->
		<div class="tab-content mt-4" id="grupoTabsContent">
			<div class="tab-pane fade @if($activeTab2 === 'jugadores1') show active @endif" id="grupo14" role="tabpanel" aria-labelledby="grupo14-tab">
				<div class="overflow-x-auto">
					<div class="text-center">
						<button wire:click="showModalNewPlayerForTournamentRegional('13:00')" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador
						</button>

						<button wire:click="saveSorteo()" class="btn btn-secondary btn-sm ms-2">
							<i class="bi bi-save me-1"></i> Guardar Sorteo
						</button>
					</div>
					<livewire:tournaments.tournament-regional.tournament-players-table  idtournament="{{$id_tournament}}" />
				</div>
			</div>
			<div class="tab-pane fade @if($activeTab2 === 'jugadores2') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
				<div class="overflow-x-auto mt-3">
					<div class="text-center">
						<button wire:click="showModalNewPlayerForTournamentRegional('14:00')" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador
						</button>

						<button wire:click="saveSorteo()" class="btn btn-secondary btn-sm ms-2">
							<i class="bi bi-save me-1"></i> Guardar Sorteo
						</button>
					</div>
					<livewire:tournaments.tournament-regional.tournament-players-table2 idtournament="{{$id_tournament}}" />
				</div>
			</div>
			<div class="tab-pane fade @if($activeTab2 === 'jugadores3') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
				<div class="overflow-x-auto mt-3">
					<div class="text-center">
						<button wire:click="showModalNewPlayerForTournamentRegional('15:00')" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador
						</button>

						<button wire:click="saveSorteo()" class="btn btn-secondary btn-sm ms-2">
							<i class="bi bi-save me-1"></i> Guardar Sorteo
						</button>
					</div>
					<livewire:tournaments.tournament-regional.tournament-players-table3 idtournament="{{$id_tournament}}" />
				</div>
			</div>
			<div class="tab-pane fade @if($activeTab2 === 'jugadores4') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
				<div class="overflow-x-auto mt-3">
					<div class="text-center">
						<button wire:click="showModalNewPlayerForTournamentRegional('16:00')" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador
						</button>

						<button wire:click="saveSorteo()" class="btn btn-secondary btn-sm ms-2">
							<i class="bi bi-save me-1"></i> Guardar Sorteo
						</button>
					</div>
					<livewire:tournaments.tournament-regional.tournament-players-table4 idtournament="{{$id_tournament}}" />
				</div>
			</div>
			<div class="tab-pane fade @if($activeTab2 === 'jugadores5') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
				<div class="overflow-x-auto mt-3">
					<div class="text-center">
						<button wire:click="showModalNewPlayerForTournamentRegional('17:00')" class="btn btn-success btn-sm">
							<i class="bi bi-plus-circle me-1"></i> Agregar Jugador
						</button>

						<button wire:click="saveSorteo()" class="btn btn-secondary btn-sm ms-2">
							<i class="bi bi-save me-1"></i> Guardar Sorteo
						</button>
					</div>
					<livewire:tournaments.tournament-regional.tournament-players-table5 idtournament="{{$id_tournament}}" />
				</div>
			</div>
		</div>
		<livewire:tournaments.tournament-regional.modal-registrar-jugador-tournament />
	</div>

</div>