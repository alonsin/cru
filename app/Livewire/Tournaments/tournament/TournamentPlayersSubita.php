<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\Game;
use App\Models\TournamentPlayer;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;

class TournamentPlayersSubita extends Component
{

	public $tournament, $idtournament, $id_tournament;
	public $playersTournament = [];
	public $enfrentamientos = [];
	public $enfrentamientos1 = [];
	public $enfrentamientos2 = [];
	public $jugadores1 = [];
	public $jugadores2 = [];
	public $subitasSeleccionados1 = [];
	public $subitasSeleccionados2 = [];
	public $numeroSorteo = [];
	public $sorteossubita1 = [];
	public $sorteossubita2 = [];
	public $mesaActual = [];
	public $juegosGuardadosSubita1 = [];
	public $juegosGuardadosSubita2 = [];
	public $estatusSeleccionados1 = [];
	public $estatusSeleccionados2 = [];
	public $mesaSeleccionada = [];
	public $mesasDisponibles = [];
	public $mesasOcupadas = [];

	public function mount()
	{
		$this->loadandupdateDataSubita();
	}

	#[On('updateDataFromSubita')]
	public function updateDataFromSubita()
	{
		$this->guardarAjustesSubita1();
		$this->guardarAjustesSubita2();
		$this->loadandupdateDataSubita();
	}

	public function loadandupdateDataSubita()
	{
		$this->loadDataSubita1AjusteMain();
		$this->loadDataSubita2AjusteMain();
		$this->cargarJuegosGuardados1();
		$this->cargarJuegosGuardados2();
		$this->cargarganadoresactuales1();
		$this->cargarganadoresactuales2();
		$this->cargarMesasDisponibles();
	}

	public function guardarAjustes()
	{
		$this->guardarAjustesSubita1();
		$this->guardarAjustesSubita2();
		$this->loadandupdateDataSubita();
		$this->dispatch('updateGamesRonda16');
		$this->dispatch('general-guardado');
	}

	/////////////////////////// JUEGOS DE SUBITA UNO /////////////////////////

	public function seleccionarGanadorSubita1($ganadorId, $perdedorId)
	{
		$this->subitasSeleccionados1[$ganadorId] = true;
		$this->subitasSeleccionados1[$perdedorId] = false;
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

	public function loadDataSubita1AjusteMain()
	{
		$this->enfrentamientos1 = [
			['A1', 'B1'],
			['C1', 'D1'],
			['E1', 'F1'],
			['G1', 'H1'],
			['I1', 'J1'],
			['K1', 'J2'],
			['K2', 'I2'],
			['H1', 'G2'],
			['F2', 'E2'],
			['D2', 'C2'],
			['B2', 'A2'],
		];

		$this->mesaActual = [];

		$jugadoresCollection1  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('horario', '14:00')
			->whereIn('SORTEO_PASE_GRUPOS', Arr::flatten($this->enfrentamientos1))
			->get();

		$this->jugadores1 = $jugadoresCollection1->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'SORTEO_PASE_GRUPOS' => $jp->SORTEO_PASE_GRUPOS,
			];
		})->keyBy('SORTEO_PASE_GRUPOS')->all();

		foreach ($this->jugadores1 as $jugador) {
			$id = $jugador['id_player'];

			$tp = TournamentPlayer::where('id_tournament', $this->id_tournament)
				->where('id_player', $id)
				->first();

			if ($tp) {
				$this->sorteossubita1[$id] = $tp->SORTEO_SUBITA;
			}
		}
	}

	public function cargarJuegosGuardados1()
	{
		foreach ($this->enfrentamientos1 as [$clave1, $clave2]) {

			if (!isset($this->jugadores1[$clave1]) || !isset($this->jugadores1[$clave2])) {
				continue;
			}

			$jugador1 = $this->jugadores1[$clave1];
			$jugador2 = $this->jugadores1[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 2) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;

				$this->juegosGuardadosSubita1[$claveJuego] = $juego;
				$this->estatusSeleccionados1[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales1()
	{
		$this->subitasSeleccionados1 = [];

		foreach ($this->enfrentamientos1 as [$clave1, $clave2]) {

			if (!isset($this->jugadores1[$clave1]) || !isset($this->jugadores1[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}

			$jugador1 = $this->jugadores1[$clave1];
			$jugador2 = $this->jugadores1[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 2)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->subitasSeleccionados1[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->subitasSeleccionados1[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function guardarAjustesSubita1()
	{
		foreach ($this->enfrentamientos1 as $index => $par) {

			[$clave1, $clave2] = $par;

			if (isset($this->jugadores1[$clave1]) && isset($this->jugadores1[$clave2])) {
				$jugador1 = $this->jugadores1[$clave1];
				$jugador2 = $this->jugadores1[$clave2];



				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 2)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();


				// dd($juego);

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->subitasSeleccionados1[$jugador1['id_player']]);
				$ganador2 = !empty($this->subitasSeleccionados1[$jugador2['id_player']]);

				$wp1 = $ganador1 ? 1 : 0;
				$wp2 = $ganador2 ? 1 : 0;

				if ($juego) {
					$juego->update([
						'wp1' => $wp1,
						'wp2' => $wp2,
						'estatus' => $this->estatusSeleccionados1[$juego->id] ?? 0,
						'mesa' => $mesa,
					]);
				} else {
					// dd("else");
					$juegocreado = 	Game::create([
						'id_tournament' => $this->id_tournament,
						'mesa' => $mesa,
						'CP1' => $clave1,
						'p1' => $jugador1['id_player'],
						'wp1' => $wp1,
						'p2' => $jugador2['id_player'],
						'wp2' => $wp2,
						'CP2' => $clave2,
						'ronda' => 2,
						'estatus' => $this->estatusSeleccionados1[$index] ?? 0,
					]);

					// dd($juegocreado);
				}

				$valorJugador1 = isset($this->sorteossubita1[$jugador1['id_player']]) && $this->sorteossubita1[$jugador1['id_player']] !== ''
					? (int)$this->sorteossubita1[$jugador1['id_player']]
					: null;

				$valorJugador2 = isset($this->sorteossubita1[$jugador2['id_player']]) && $this->sorteossubita1[$jugador2['id_player']] !== ''
					? (int)$this->sorteossubita1[$jugador2['id_player']]
					: null;

				if ($ganador1) {
					// Jugador 1 es ganador
					$updateJugador1 = [
						'SORTEO_SUBITA' => $valorJugador1,
						'R_SUBITA' => 1,
					];
					if ($valorJugador1 !== null && $valorJugador1 <= 16) {
						$updateJugador1['SORTEO_TO_16'] = $valorJugador1;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update($updateJugador1);

					// Jugador 2 es perdedor
					$updateJugador2 = [
						'SORTEO_SUBITA' => $valorJugador2,
						'R_SUBITA' => null,
					];
					if ($valorJugador2 !== null && $valorJugador2 <= 16) {
						$updateJugador2['SORTEO_TO_16'] = $valorJugador2;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update($updateJugador2);
				}

				if ($ganador2) {
					// Jugador 2 es ganador
					$updateJugador2 = [
						'SORTEO_SUBITA' => $valorJugador2,
						'R_SUBITA' => 1,
					];
					if ($valorJugador2 !== null && $valorJugador2 <= 16) {
						$updateJugador2['SORTEO_TO_16'] = $valorJugador2;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update($updateJugador2);

					// Jugador 1 es perdedor
					$updateJugador1 = [
						'SORTEO_SUBITA' => $valorJugador1,
						'R_SUBITA' => null,
					];
					if ($valorJugador1 !== null && $valorJugador1 <= 16) {
						$updateJugador1['SORTEO_TO_16'] = $valorJugador1;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update($updateJugador1);
				}
			}
		}
	}

	/////////////////////////// JUEGOS DE SUBITA UNO /////////////////////////

	/////////////////////////// JUEGOS DE SUBITA DOS /////////////////////////

	public function seleccionarGanadorSubita2($ganadorId, $perdedorId)
	{
		$this->subitasSeleccionados2[$ganadorId] = true;
		$this->subitasSeleccionados2[$perdedorId] = false;
	}

	public function loadDataSubita2AjusteMain()
	{
		$this->enfrentamientos2 = [
			['A1', 'B1'],
			['C1', 'D1'],
			['E1', 'F1'],
			['G1', 'H1'],
			['I1', 'J1'],
			['K1', 'J2'],
			['K2', 'I2'],
			['H1', 'G2'],
			['F2', 'E2'],
			['D2', 'C2'],
			['B2', 'A2'],
		];

		$this->mesaActual = [];

		$jugadoresCollection2  = TournamentPlayer::with('player')
			->where('id_tournament', $this->id_tournament)
			->where('horario', '17:00')
			->whereIn('SORTEO_PASE_GRUPOS', Arr::flatten($this->enfrentamientos2))
			->get();

		$this->jugadores2 = $jugadoresCollection2->map(function ($jp) {
			return [
				'id' => $jp->id,
				'id_player' => $jp->player->id,
				'nombre' => $jp->player->name_player ?? 'Sin nombre',
				'SORTEO_PASE_GRUPOS' => $jp->SORTEO_PASE_GRUPOS,
			];
		})->keyBy('SORTEO_PASE_GRUPOS')->all();

		foreach ($this->jugadores2 as $jugador) {
			$id = $jugador['id_player'];

			$tp = TournamentPlayer::where('id_tournament', $this->id_tournament)
				->where('id_player', $id)
				->first();

			if ($tp) {
				$this->sorteossubita2[$id] = $tp->SORTEO_SUBITA;
			}
		}
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
				->where('ronda', 2) // o usa $this->ronda si es dinámico
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				$claveJuego = $clave1 . '-' . $clave2;

				$this->juegosGuardadosSubita2[$claveJuego] = $juego;
				$this->estatusSeleccionados2[$juego->id] = $juego->estatus;
				$this->mesaSeleccionada[$juego->id] = $juego->mesa;
			}
		}
	}

	public function cargarganadoresactuales2()
	{
		$this->subitasSeleccionados2 = [];

		foreach ($this->enfrentamientos2 as [$clave1, $clave2]) {

			if (!isset($this->jugadores2[$clave1]) || !isset($this->jugadores2[$clave2])) {
				continue; // Saltar este enfrentamiento si falta uno de los dos jugadores
			}

			$jugador1 = $this->jugadores2[$clave1];
			$jugador2 = $this->jugadores2[$clave2];

			$juego = Game::where('id_tournament', $this->id_tournament)
				->where('ronda', 2)
				->where('p1', $jugador1['id_player'])
				->where('p2', $jugador2['id_player'])
				->first();

			if ($juego) {
				if ($juego->wp1 == 1) {
					$this->subitasSeleccionados2[$jugador1['id_player']] = true;
				}
				if ($juego->wp2 == 1) {
					$this->subitasSeleccionados2[$jugador2['id_player']] = true;
				}
			}
		}
	}

	public function guardarAjustesSubita2()
	{
		foreach ($this->enfrentamientos2 as $index => $par) {
			[$clave1, $clave2] = $par;

			if (isset($this->jugadores2[$clave1]) && isset($this->jugadores2[$clave2])) {
				$jugador1 = $this->jugadores2[$clave1];
				$jugador2 = $this->jugadores2[$clave2];

				$juego = Game::where('id_tournament', $this->id_tournament)
					->where('ronda', 2)
					->where('p1', $jugador1['id_player'])
					->where('p2', $jugador2['id_player'])
					->first();

				$mesa = $juego ? ($this->mesaSeleccionada[$juego->id] ?? $juego->mesa) : ($this->mesaSeleccionada[$index] ?? null);

				$ganador1 = !empty($this->subitasSeleccionados2[$jugador1['id_player']]);
				$ganador2 = !empty($this->subitasSeleccionados2[$jugador2['id_player']]);

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
						'ronda' => 2,
						'estatus' => $this->estatusSeleccionados2[$index] ?? 0,
					]);
				}

				$valorJugador1 = isset($this->sorteossubita2[$jugador1['id_player']]) && $this->sorteossubita2[$jugador1['id_player']] !== ''
					? (int)$this->sorteossubita2[$jugador1['id_player']]
					: null;

				$valorJugador2 = isset($this->sorteossubita2[$jugador2['id_player']]) && $this->sorteossubita2[$jugador2['id_player']] !== ''
					? (int)$this->sorteossubita2[$jugador2['id_player']]
					: null;

				if ($ganador1) {
					// Jugador 1 es ganador
					$updateJugador1 = [
						'SORTEO_SUBITA' => $valorJugador1,
						'R_SUBITA' => 1,
					];
					if ($valorJugador1 !== null && $valorJugador1 <= 16) {
						$updateJugador1['SORTEO_TO_16'] = $valorJugador1;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update($updateJugador1);

					// Jugador 2 es perdedor
					$updateJugador2 = [
						'SORTEO_SUBITA' => $valorJugador2,
						'R_SUBITA' => null,
					];
					if ($valorJugador2 !== null && $valorJugador2 <= 16) {
						$updateJugador2['SORTEO_TO_16'] = $valorJugador2;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update($updateJugador2);
				}

				if ($ganador2) {
					// Jugador 2 es ganador
					$updateJugador2 = [
						'SORTEO_SUBITA' => $valorJugador2,
						'R_SUBITA' => 1,
					];
					if ($valorJugador2 !== null && $valorJugador2 <= 16) {
						$updateJugador2['SORTEO_TO_16'] = $valorJugador2;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador2['id_player'])
						->update($updateJugador2);

					// Jugador 1 es perdedor
					$updateJugador1 = [
						'SORTEO_SUBITA' => $valorJugador1,
						'R_SUBITA' => null,
					];
					if ($valorJugador1 !== null && $valorJugador1 <= 16) {
						$updateJugador1['SORTEO_TO_16'] = $valorJugador1;
					}

					TournamentPlayer::where('id_tournament', $this->id_tournament)
						->where('id_player', $jugador1['id_player'])
						->update($updateJugador1);
				}
			}
		}
	}

	/////////////////////////// JUEGOS DE SUBITA UNO /////////////////////////

	public function render()
	{
		return view('livewire.tournaments.tournament.tournament-player-subita');
	}
}
