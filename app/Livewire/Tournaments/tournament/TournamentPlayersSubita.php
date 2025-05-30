<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\Game;
use App\Models\TournamentPlayer;
use Livewire\Component;
use Illuminate\Support\Arr;

class TournamentPlayersSubita extends Component
{

    public $tournament, $idtournament, $id_tournament;
    public $playersTournament = [];
    public $enfrentamientos = [];
    public $enfrentamientos1 = [];
    public $jugadores1 = [];
    public $jugadores2 = [];
    public $subitasSeleccionados1 = [];
    public $numeroSorteo = [];
    public $sorteossubita = [];
    public $mesaActual = [];
    public $juegosGuardadosSubita1 = [];
    public $estatusSeleccionados1 = [];
    public $mesaSeleccionada = [];
    public $mesasDisponibles = [];
    public $mesasOcupadas = [];

    public function mount()
    {
        $this->loadandupdateDataSubita();
    }

    public function loadandupdateDataSubita()
    {
        $this->loadDataSubita1AjusteMain();
        $this->cargarJuegosGuardados1();
        $this->cargarganadoresactuales1();
        $this->cargarMesasDisponibles();
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


    public function guardarAjustes()
    {
        $this->guardarAjustesSubita1();
        $this->dispatch('general-guardado');
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
                        'estatus' => $this->estatusSeleccionados1[$index] ?? 0, // si no hay juego, usa el índice
                    ]);
                }

                // Actualizar ganador y perdedor en TournamentPlayer
                if ($ganador1) {
                    TournamentPlayer::where('id_tournament', $this->id_tournament)
                        ->where('id_player', $jugador1['id_player'])
                        ->update(['SORTEO_SUBITA' => 100]);

                    TournamentPlayer::where('id_tournament', $this->id_tournament)
                        ->where('id_player', $jugador2['id_player'])
                        ->update(['SORTEO_SUBITA' => null]);
                }

                if ($ganador2) {
                    TournamentPlayer::where('id_tournament', $this->id_tournament)
                        ->where('id_player', $jugador2['id_player'])
                        ->update(['SORTEO_SUBITA' => 100]);

                    TournamentPlayer::where('id_tournament', $this->id_tournament)
                        ->where('id_player', $jugador1['id_player'])
                        ->update(['SORTEO_SUBITA' => null]);
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-subita');
    }
}
