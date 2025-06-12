<div>

	<div class="nav nav-tabs d-flex mt-0" id="grupoTabs" role="tablist">
		<button wire:click="setActiveTab3('jugadores1')" class="nav-link flex-fill text-center @if($activeTab3 === 'jugadores1') active @endif text-dark" id="grupo14-tab"
			data-bs-toggle="tab" data-bs-target="#grupo14" type="button" role="tab"
			aria-controls="grupo14" aria-selected="true">
			13:00 Hrs
		</button>
		<button wire:click="setActiveTab3('jugadores2')" class="nav-link flex-fill text-center @if($activeTab3 === 'jugadores2') active @endif text-dark" id="grupo17-tab"
			data-bs-toggle="tab" data-bs-target="#grupo17" type="button" role="tab"
			aria-controls="grupo17" aria-selected="false">
			14:00 Hrs
		</button>
		<button wire:click="setActiveTab3('jugadores3')" class="nav-link flex-fill text-center @if($activeTab3 === 'jugadores3') active @endif text-dark" id="grupo14-tab"
			data-bs-toggle="tab" data-bs-target="#grupo14" type="button" role="tab"
			aria-controls="grupo14" aria-selected="true">
			15:00 Hrs
		</button>
		<button wire:click="setActiveTab3('jugadores4')" class="nav-link flex-fill text-center @if($activeTab3 === 'jugadores4') active @endif text-dark" id="grupo17-tab"
			data-bs-toggle="tab" data-bs-target="#grupo17" type="button" role="tab"
			aria-controls="grupo17" aria-selected="false">
			16:00 Hrs
		</button>
		<button wire:click="setActiveTab3('jugadores5')" class="nav-link flex-fill text-center @if($activeTab3 === 'jugadores5') active @endif text-dark" id="grupo17-tab"
			data-bs-toggle="tab" data-bs-target="#grupo17" type="button" role="tab"
			aria-controls="grupo17" aria-selected="false">
			17:00 Hrs
		</button>
	</div>


	<div class="tab-content mt-0" id="grupoTabsContent">
		<div class="tab-pane fade @if($activeTab3 === 'jugadores1') show active @endif" id="grupo14" role="tabpanel" aria-labelledby="grupo14-tab">
			<livewire:tournaments.tournament-regional.tournament-players-subita-uno id_tournament="{{$id_tournament}}" />
		</div>
		<div class="tab-pane fade @if($activeTab3 === 'jugadores2') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
			<livewire:tournaments.tournament-regional.tournament-players-subita-dos id_tournament="{{$id_tournament}}" />
		</div>
		<div class="tab-pane fade @if($activeTab3 === 'jugadores3') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
			<livewire:tournaments.tournament-regional.tournament-players-subita-tres id_tournament="{{$id_tournament}}" />
		</div>
		<div class="tab-pane fade @if($activeTab3 === 'jugadores4') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
			<livewire:tournaments.tournament-regional.tournament-players-subita-cuatro id_tournament="{{$id_tournament}}" />
		</div>
		<div class="tab-pane fade @if($activeTab3 === 'jugadores5') show active @endif" id="grupo17" role="tabpanel" aria-labelledby="grupo17-tab">
			<livewire:tournaments.tournament-regional.tournament-players-subita-cinco id_tournament="{{$id_tournament}}" />
		</div>
	</div>

</div>