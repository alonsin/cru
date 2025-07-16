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
	public $numerosAsignados = [];

	public function mount() {}


	public function cerrarModalGanadores()
	{
		$this->dispatch('cerrarModalGanadores');
	}

	public function getNumerosAsignados()
	{
		$numerosUsados = TournamentPlayer::where('id_tournament', $this->id_tournament)
			->pluck('SORTEO_SUBITA')
			->toArray();
		$this->numerosAsignados = array_filter($numerosUsados, function ($valor) {
			return $valor !== null;
		});
		$this->numerosAsignados = array_values($this->numerosAsignados);
	}

	public function guardarNumerosSorteo()
	{
		$bais = 13;
		$this->getNumerosAsignados();

		// Validar que los números no se repiten
		$numeros = array_filter($this->numerosSorteo, fn($n) => $n !== null && $n !== '');
		$numerosUnicos = array_unique($numeros);

		if (count($numeros) !== count($numerosUnicos)) {
			$this->dispatch('sorteos-repetidos-subita', message: 'Hay numeros de sorteo repetidos, favor de revisar.');
			return;
		}
		// Guardar los números si no hay duplicados 
		foreach ($this->numerosSorteo as $id => $numero) {
			if ($numero <= $bais) {
				TournamentPlayer::where('id', $id)->update([
					'SORTEO_TO_32' => $numero === '' ? null : $numero
				]);
			}
			TournamentPlayer::where('id', $id)->update([
				'SORTEO_SUBITA' => $numero === '' ? null : $numero
			]);
		}
		// Emitir eventos una vez al final
		$this->dispatch('cerrarModalGanadores');
		$this->dispatch('sorteos-guardados-subita');


		$this->numerosSorteo = [];
	}

	#[On('mostrarModalGanadoresModal')]
	public function mostrarModalGanadoresModal($horario)
	{
		$this->horario = $horario;
		$this->jugadoresganadores = TournamentPlayer::where('id_tournament', 14)
			// ->where('horario', $horario)
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
