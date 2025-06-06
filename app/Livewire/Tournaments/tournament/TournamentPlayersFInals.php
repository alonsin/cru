<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\Game;
use App\Models\TournamentPlayer;
use Livewire\Component;

class TournamentPlayersFinals extends Component
{

	public $id_tournament;
	public $enfrentamientos2 = [];
	public $enfrentamientos8 = [];
	public $enfrentamientos4 = [];
	public $enfrentamientofinal = [];
	public $jugadores8 = [];
	public $jugadores4 = [];
	public $jugadores2 = [];
	public $jugadoresDirectos = [];
	public $ajustesSeleccionados8 = [];
	public $ajustesSeleccionados4 = [];
	public $ajustesSeleccionados2 = [];
	public $ganadores8 = [];
	public $ganadores4 = [];
	public $mesasOcupadas = [];
	public $mesasDisponibles = [];
	public $mesaActual = [];
	public $juegosGuardados8 = [];
	public $estatusSeleccionados8 = [];

	public function mount()
	{
		$this->loadandupdateData8();
		$this->loadandupdateData4();
		$this->loadandupdateData2();
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

	public function guardarAjustes()
	{
		$this->guardar8();
		$this->guardar4();
		$this->guardar2();
		$this->loadData8Main();
		$this->loadData4Main();
		$this->loadData2Main();
		$this->dispatch('general-guardado');
	}

	//////////////////// RONDA 8 //////////////////////////

	public function loadandupdateData8()
	{
		$this->loadData8Main();
		$this->cargarJuegosGuardados8();
		$this->cargarganadoresactuales8();
		$this->cargarMesasDisponibles();
	}

	public function loadData8Main()
	{
		$this->enfrentamientos8 = [
			['1', '2'],
			['3', '4'],
			['5', '6'],
			['7', '8'],
		];

		$this->mesaActual = [];


		$jugadoresCollection8  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('NUM_8', '<=', 8)
			->orderBy('NUM_8')
			->get();


		$this->jugadores8 = $jugadoresCollection8->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'NUM_8' => $jp->NUM_8,
			];
		})->keyBy('NUM_8')->all();
	}

	public function cargarJuegosGuardados8()
	{
		foreach ($this->enfrentamientos8 as [$clave1, $clave2]) {
			if (!isset($this->jugadores8[$clave1]) || !isset($this->jugadores8[$clave2])) {
				continue;
			}

			$jugador1 = $this->jugadores8[$clave1];
			$jugador2 = $this->jugadores8[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 6) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;
				$this->juegosGuardados8[$claveJuego] = $juego;

				$this->estatusSeleccionados8[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales8()
	{
		$this->ajustesSeleccionados8 = [];

		foreach ($this->enfrentamientos8 as [$clave1, $clave2]) {
			if (!isset($this->jugadores8[$clave1]) || !isset($this->jugadores8[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}
			$jugador1 = $this->jugadores8[$clave1];
			$jugador2 = $this->jugadores8[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 6)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->ajustesSeleccionados8[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->ajustesSeleccionados8[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function guardar8()
	{
		foreach ($this->enfrentamientos8 as $index => $par) {
			[$clave1, $clave2] = $par;

			if (isset($this->jugadores8[$clave1]) && isset($this->jugadores8[$clave2])) {
				$jugador1 = $this->jugadores8[$clave1];
				$jugador2 = $this->jugadores8[$clave2];

				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 6)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->ajustesSeleccionados8[$jugador1['id_player']]);
				$ganador2 = !empty($this->ajustesSeleccionados8[$jugador2['id_player']]);

				$wp1 = $ganador1 ? 1 : 0;
				$wp2 = $ganador2 ? 1 : 0;

				if ($juego) {
					$juego->update([
						'wp1' => $wp1,
						'wp2' => $wp2,
						'estatus' => $this->estatusSeleccionados8[$juego->id] ?? 0,
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
						'ronda' => 6,
						'estatus' => $this->estatusSeleccionados8[$index] ?? 0, // si no hay juego, usa el índice
					]);
				}

				// Actualizar ganador y perdedor en TournamentPlayer
				if ($ganador1) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update([
							'NUM_4' => $index + 1, // Aquí se asigna el número de posición
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update(['NUM_4' => null]);
				}

				if ($ganador2) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update([
							'NUM_4' => $index + 1, // Aquí también
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update(['NUM_4' => null]);
				}
			}
		}
	}

	//////////////////// RONDA 8 //////////////////////////


	//////////////////// RONDA SEMIFINAL //////////////////////////

	public function loadandupdateData4()
	{
		$this->loadData4Main();
		$this->cargarJuegosGuardados4();
		$this->cargarganadoresactuales4();
		$this->cargarMesasDisponibles();
	}

	public function loadData4Main()
	{
		$this->enfrentamientos4 = [
			['1', '2'],
			['3', '4'],
		];

		$this->mesaActual = [];


		$jugadoresCollection4  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('NUM_4', '<=', 4)
			->orderBy('NUM_4')
			->get();


		$this->jugadores4 = $jugadoresCollection4->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'NUM_4' => $jp->NUM_4,
			];
		})->keyBy('NUM_4')->all();
	}

	public function cargarJuegosGuardados4()
	{
		foreach ($this->enfrentamientos4 as [$clave1, $clave2]) {
			if (!isset($this->jugadores4[$clave1]) || !isset($this->jugadores4[$clave2])) {
				continue;
			}

			$jugador1 = $this->jugadores4[$clave1];
			$jugador2 = $this->jugadores4[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 7) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;
				$this->juegosGuardados4[$claveJuego] = $juego;

				$this->estatusSeleccionados4[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales4()
	{
		$this->ajustesSeleccionados4 = [];

		foreach ($this->enfrentamientos4 as [$clave1, $clave2]) {
			if (!isset($this->jugadores4[$clave1]) || !isset($this->jugadores4[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}
			$jugador1 = $this->jugadores4[$clave1];
			$jugador2 = $this->jugadores4[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 7)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->ajustesSeleccionados4[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->ajustesSeleccionados4[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function guardar4()
	{
		foreach ($this->enfrentamientos4 as $index => $par) {
			[$clave1, $clave2] = $par;

			if (isset($this->jugadores4[$clave1]) && isset($this->jugadores4[$clave2])) {
				$jugador1 = $this->jugadores4[$clave1];
				$jugador2 = $this->jugadores4[$clave2];

				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 7)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->ajustesSeleccionados4[$jugador1['id_player']]);
				$ganador2 = !empty($this->ajustesSeleccionados4[$jugador2['id_player']]);

				$wp1 = $ganador1 ? 1 : 0;
				$wp2 = $ganador2 ? 1 : 0;

				if ($juego) {
					$juego->update([
						'wp1' => $wp1,
						'wp2' => $wp2,
						'estatus' => $this->estatusSeleccionados4[$juego->id] ?? 0,
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
						'ronda' => 7,
						'estatus' => $this->estatusSeleccionados4[$index] ?? 0, // si no hay juego, usa el índice
					]);
				}

				// Actualizar ganador y perdedor en TournamentPlayer
				if ($ganador1) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update([
							'NUM_2' => $index + 1, // Aquí se asigna el número de posición
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update(['NUM_2' => null]);
				}

				if ($ganador2) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update([
							'NUM_2' => $index + 1, // Aquí también
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update(['NUM_2' => null]);
				}
			}
		}
	}

	//////////////////// RONDA SEMIFINAL //////////////////////////



	//////////////////// RONDA FINAL //////////////////////////

	public function loadandupdateData2()
	{
		$this->loadData2Main();
		$this->cargarJuegosGuardados2();
		$this->cargarganadoresactuales2();
		$this->cargarMesasDisponibles();
	}

	public function loadData2Main()
	{
		$this->enfrentamientos2 = [
			['1', '2'],
		];

		$this->mesaActual = [];


		$jugadoresCollection2  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('NUM_4', '<=', 4)
			->orderBy('NUM_4')
			->get();


		$this->jugadores2 = $jugadoresCollection2->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'NUM_2' => $jp->NUM_4,
			];
		})->keyBy('NUM_2')->all();
	}

	public function cargarJuegosGuardados2()
	{
		foreach ($this->enfrentamientos2 as [$clave1, $clave2]) {
			if (!isset($this->jugadores2[$clave1]) || !isset($this->jugadores2[$clave2])) {
				continue;
			}

			$jugador1 = $this->jugadores2[$clave1];
			$jugador2 = $this->jugadores2[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 8) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;
				$this->juegosGuardados2[$claveJuego] = $juego;

				$this->estatusSeleccionados2[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales2()
	{
		$this->ajustesSeleccionados2 = [];

		foreach ($this->enfrentamientos2 as [$clave1, $clave2]) {
			if (!isset($this->jugadores2[$clave1]) || !isset($this->jugadores2[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}
			$jugador1 = $this->jugadores2[$clave1];
			$jugador2 = $this->jugadores2[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 8)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->ajustesSeleccionados2[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->ajustesSeleccionados2[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function guardar2()
	{
		foreach ($this->enfrentamientos2 as $index => $par) {
			[$clave1, $clave2] = $par;

			if (isset($this->jugadores2[$clave1]) && isset($this->jugadores2[$clave2])) {
				$jugador1 = $this->jugadores2[$clave1];
				$jugador2 = $this->jugadores2[$clave2];

				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 8)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->ajustesSeleccionados2[$jugador1['id_player']]);
				$ganador2 = !empty($this->ajustesSeleccionados2[$jugador2['id_player']]);

				$wp1 = $ganador1 ? 1 : 0;
				$wp2 = $ganador2 ? 1 : 0;

				if ($juego) {
					$juego->update([
						'wp1' => $wp1,
						'wp2' => $wp2,
						'estatus' => $this->estatusSeleccionados2[$juego->id] ?? 0,
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
						'ronda' => 8,
						'estatus' => $this->estatusSeleccionados2[$index] ?? 0, // si no hay juego, usa el índice
					]);
				}

				// Actualizar ganador y perdedor en TournamentPlayer
				if ($ganador1) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update([
							'R_FINAL' => 1, // Aquí se asigna el número de posición
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update(['R_FINAL' => null]);
				}

				if ($ganador2) {
					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update([
							'R_FINAL' =>  1, // Aquí también
						]);

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update(['R_FINAL' => null]);
				}
			}
		}
	}

	//////////////////// RONDA SEMIFINAL //////////////////////////


	public function render()
	{
		return view('livewire.tournaments.tournament.tournament-player-finals');
	}
}
