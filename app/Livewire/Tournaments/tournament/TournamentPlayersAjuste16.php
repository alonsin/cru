<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\Game;
use App\Models\TournamentPlayer;
use Livewire\Component;
use Illuminate\Support\Arr;

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
    public $estatusSeleccionados = [];

    public function mount()
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

        $this->cargarJuegosGuardados();



        $this->cargarganadoresactuales();
    }

    public function seleccionarGanador($ganadorId, $perdedorId)
    {
        // Asegurarse de que solo uno esté seleccionado
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

                // Cargar el estatus en el array para usarlo en el select
                $this->estatusSeleccionados[$juego->id] = $juego->estatus;
            }
        }

        // dd($this->juegosGuardadosAjuste16);
    }

    public function cargarganadoresactuales()
    {
        $this->ajustesSeleccionados = [];

        foreach ($this->enfrentamientosajustes as [$clave1, $clave2]) {

            // Verifica que ambos jugadores existan antes de continuar
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
        foreach ($this->enfrentamientosajustes as $index => $par) {
            [$clave1, $clave2] = $par;

            if (isset($this->jugadores[$clave1]) && isset($this->jugadores[$clave2])) {
                $jugador1 = $this->jugadores[$clave1];
                $jugador2 = $this->jugadores[$clave2];

                $mesa = 10;

                $ganador1 = !empty($this->ajustesSeleccionados[$jugador1['id_player']]);
                $ganador2 = !empty($this->ajustesSeleccionados[$jugador2['id_player']]);

                $wp1 = $ganador1 ? 1 : 0;
                $wp2 = $ganador2 ? 1 : 0;

                $juego = Game::where('id_tournament', $this->id_tournament)
                    ->where('ronda', 3)
                    ->where('p1', $jugador1['id_player'])
                    ->where('p2', $jugador2['id_player'])
                    ->first();

                if ($juego) {
                    $juego->update([
                        'wp1' => $wp1,
                        'wp2' => $wp2,
                        'estatus' => 3,
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
                        'estatus' => 3,
                    ]);
                }
            }
        }

        $this->dispatch('grupos-guardados');
    }


    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-ajuste16');
    }
}
