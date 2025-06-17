<?php

namespace App\Livewire\Tournaments\tournamentregional;

use App\Models\Game;
use App\Models\TournamentPlayer;
use Livewire\Component;
use Livewire\Attributes\On;

class TournamentPlayersAjuste16 extends Component
{
	public $id_tournament;
	public $enfrentamientos = [];
	public $enfrentamientosajustes = [];
	public $enfrentamientos16 = [];
	public $jugadores = [];
	public $jugadores16 = [];
	public $jugadoresDirectos = [];
	public $ajustesSeleccionados = [];
	public $ajustesSeleccionados16 = [];
	public $mesaActual = [];
	public $juegosGuardadosAjuste16 = [];
	public $juegosGuardados16 = [];
	public $estatusSeleccionados = [];
	public $estatusSeleccionados16 = [];
	public $mesaSeleccionada = [];
	public $mesasDisponibles = [];
	public $mesasOcupadas = [];


	public function mount()
	{
		$this->loadandupdateData16();
	}

	public function loadandupdateData16()
	{
		$this->loadData16AjusteMain();
		$this->loadData16Main();
		$this->cargarJuegosGuardados();
		$this->cargarJuegosGuardados16();
		$this->cargarganadoresactuales();
		$this->cargarganadoresactuales16();
		$this->cargarMesasDisponibles();
	}

	#[On('updateGamesRonda16')]
	public function actualizarJuegos()
	{
		$this->guardarAjustes16();
		$this->loadandupdateData16();
	}

	public function cargarMesasDisponibles()
	{
		$this->mesasOcupadas = Game::where('id_tournament', $this->id_tournament)
			->where('estatus', 1)
			->pluck('mesa')
			->filter() // evitar valores nulos
			->unique()
			->toArray();
		$this->mesasDisponibles = array_diff(range(1, 11), $this->mesasOcupadas);
	}

	public function loadData16AjusteMain()
	{
		$this->enfrentamientosajustes = [
			['11', '22'],
			['12', '21'],
			['13', '20'],
			['14', '19'],
			['15', '18'],
			['16', '17'],
		];

		$this->mesaActual = [];


		$jugadoresCollection  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('R_SUBITA', 1)
			->where('SORTEO_SUBITA', '>', 10)
			->orderBy('SORTEO_SUBITA')
			->get();

		$this->jugadores = $jugadoresCollection->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'SORTEO_SUBITA' => $jp->SORTEO_SUBITA,
			];
		})->keyBy('SORTEO_SUBITA')->all();
	}

	public function seleccionarGanador($ganadorId, $perdedorId)
	{
		$this->ajustesSeleccionados[$ganadorId] = true;
		unset($this->ajustesSeleccionados[$perdedorId]);
	}

	public function cargarJuegosGuardados()
	{
		foreach ($this->enfrentamientosajustes as [$clave1, $clave2]) {

			if (!isset($this->jugadores[$clave1]) || !isset($this->jugadores[$clave2])) {
				continue;
			}

			$jugador1 = $this->jugadores[$clave1];
			$jugador2 = $this->jugadores[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 3) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;
				$this->juegosGuardadosAjuste16[$claveJuego] = $juego;

				$this->estatusSeleccionados[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales()
	{
		$this->ajustesSeleccionados = [];

		foreach ($this->enfrentamientosajustes as [$clave1, $clave2]) {
			if (!isset($this->jugadores[$clave1]) || !isset($this->jugadores[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}
			$jugador1 = $this->jugadores[$clave1];
			$jugador2 = $this->jugadores[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 3)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->ajustesSeleccionados[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->ajustesSeleccionados[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function guardarAjustes()
	{
		$this->guardarAjustes16();
		$this->guardar16();
		$this->loadandupdateData16();
		$this->loadData16Main();
		$this->dispatch('general-guardado');
	}

	public function guardarAjustes16()
	{
		foreach ($this->enfrentamientosajustes as $index => $par) {
			[$clave1, $clave2] = $par;

			if (isset($this->jugadores[$clave1]) && isset($this->jugadores[$clave2])) {
				$jugador1 = $this->jugadores[$clave1];
				$jugador2 = $this->jugadores[$clave2];

				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 3)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->ajustesSeleccionados[$jugador1['id_player']]);
				$ganador2 = !empty($this->ajustesSeleccionados[$jugador2['id_player']]);

				$wp1 = $ganador1 ? 1 : 0;
				$wp2 = $ganador2 ? 1 : 0;

				if ($juego) {
					$juego->update([
						'wp1' => $wp1,
						'wp2' => $wp2,
						'estatus' => $this->estatusSeleccionados[$juego->id] ?? 0,
						'mesa' => $mesa,
					]);
				} else {
					Game::create([
						'id_tournament' => $this->id_tournament,
						'mesa' => $mesa,
						'CP1' => $clave1,
						'p1' => $jugador1['id_player'],
						'wp1' => $wp1,
						'p2' => $jugador2['id_player'],
						'wp2' => $wp2,
						'CP2' => $clave2,
						'ronda' => 3,
						'estatus' => $this->estatusSeleccionados[$index] ?? 0, // si no hay juego, usa el índice
					]);
				}

				// Actualizar ganador y perdedor en TournamentPlayer
				if ($ganador1) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update(['SORTEO_TO_16' => $clave1]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update(['SORTEO_TO_16' => null]);
				}

				if ($ganador2) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update(['SORTEO_TO_16' => $clave1]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update(['SORTEO_TO_16' => null]);
				}
			}
		}
	}


	////////////////////   JUEGOS DE 16 ///////////////////////

	public function loadData16Main()
	{
		$this->enfrentamientos16 = [
			['1', '2'],
			['3', '4'],
			['5', '6'],
			['7', '8'],
			['9', '10'],
			['11', '12'],
			['13', '14'],
			['15', '16'],
		];

		$this->mesaActual = [];


		$jugadoresCollection16  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('R_SUBITA', 1)
			->where('SORTEO_TO_16', '<=', 16)
			->orderBy('SORTEO_TO_16')
			->get();


		$this->jugadores16 = $jugadoresCollection16->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'SORTEO_TO_16' => $jp->SORTEO_TO_16,
			];
		})->keyBy('SORTEO_TO_16')->all();
	}

	public function cargarJuegosGuardados16()
	{
		foreach ($this->enfrentamientos16 as [$clave1, $clave2]) {
			if (!isset($this->jugadores16[$clave1]) || !isset($this->jugadores16[$clave2])) {
				continue;
			}

			$jugador1 = $this->jugadores16[$clave1];
			$jugador2 = $this->jugadores16[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 4) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;
				$this->juegosGuardados16[$claveJuego] = $juego;

				$this->estatusSeleccionados16[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales16()
	{
		$this->ajustesSeleccionados16 = [];

		foreach ($this->enfrentamientos16 as [$clave1, $clave2]) {
			if (!isset($this->jugadores16[$clave1]) || !isset($this->jugadores16[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}
			$jugador1 = $this->jugadores16[$clave1];
			$jugador2 = $this->jugadores16[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 4)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->ajustesSeleccionados16[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->ajustesSeleccionados16[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function seleccionarGanador16($ganadorId, $perdedorId)
	{
		$this->ajustesSeleccionados16[$ganadorId] = true;
		unset($this->ajustesSeleccionados16[$perdedorId]);
	}

	public function guardar16()
	{
		foreach ($this->enfrentamientos16 as $index => $par) {
			[$clave1, $clave2] = $par;

			if (isset($this->jugadores16[$clave1]) && isset($this->jugadores16[$clave2])) {
				$jugador1 = $this->jugadores16[$clave1];
				$jugador2 = $this->jugadores16[$clave2];

				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 4)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->ajustesSeleccionados16[$jugador1['id_player']]);
				$ganador2 = !empty($this->ajustesSeleccionados16[$jugador2['id_player']]);

				$wp1 = $ganador1 ? 1 : 0;
				$wp2 = $ganador2 ? 1 : 0;

				if ($juego) {
					$juego->update([
						'wp1' => $wp1,
						'wp2' => $wp2,
						'estatus' => $this->estatusSeleccionados16[$juego->id] ?? 0,
						'mesa' => $mesa,
					]);
				} else {
					Game::create([
						'id_tournament' => $this->id_tournament,
						'mesa' => $mesa,
						'CP1' => $clave1,
						'p1' => $jugador1['id_player'],
						'wp1' => $wp1,
						'p2' => $jugador2['id_player'],
						'wp2' => $wp2,
						'CP2' => $clave2,
						'ronda' => 4,
						'estatus' => $this->estatusSeleccionados16[$index] ?? 0, // si no hay juego, usa el índice
					]);
				}

				// Actualizar ganador y perdedor en TournamentPlayer
				if ($ganador1) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update([
							'NUM_8' => $index + 1, // Aquí se asigna el número de posición
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update(['NUM_8' => null]);
				}

				if ($ganador2) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update([
							'NUM_8' => $index + 1, // Aquí también
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update(['NUM_8' => null]);
				}
			}
		}
	}

	////////////////////   JUEGOS DE 16 ///////////////////////


	public function render()
	{
		return view('livewire.tournaments.tournamentregional.tournament-player-ajuste16');
	}
}
