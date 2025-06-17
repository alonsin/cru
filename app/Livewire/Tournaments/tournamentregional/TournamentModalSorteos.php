<?php

namespace App\Livewire\Tournaments\tournamentregional;

use App\Models\TournamentPlayer;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentModalSorteos extends Component
{

	public $id_tournament, $horario;
	public $jugadoresganadores = [];
	public $numerosSorteo = [];

	public function mount() {}


	public function cerrarModalGanadores()
	{
		$this->dispatch('cerrarModalGanadores');
	}

	public function guardarNumerosSorteo()
	{
		foreach ($this->numerosSorteo as $id => $numero) {
			TournamentPlayer::where('id', $id)->update([
				'SORTEO_SUBITA' => $numero === '' ? null : $numero
			]);
		}
		$this->numerosSorteo = [];
		$this->dispatch('cerrarModalGanadores');
		$this->dispatch('sorteos-guardados-subita');
	}
	

	#[On('mostrarModalGanadoresModal')]
	public function mostrarModalGanadoresModal($horario)
	{
		$this->horario = $horario;
		$this->jugadoresganadores = TournamentPlayer::where('id_tournament', 14)
			->where('horario', $horario)
			->where('R_SUBITA', 1)
			->get();

		$this->numerosSorteo = [];

		foreach ($this->jugadoresganadores as $jugador) {
			$this->numerosSorteo[$jugador->id] = $jugador->SORTEO_SUBITA;
		}

		$this->dispatch('mostrarModalGanadores');
	}

	public function render()
	{
		return view('livewire.tournaments.tournamentregional.tournament-modal-sorteos');
	}
}
