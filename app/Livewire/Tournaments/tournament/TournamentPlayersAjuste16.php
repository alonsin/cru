<?php

namespace App\Livewire\Tournaments\tournament;

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

    public function mount()
    {

        $this->ajustesSeleccionados = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('R_AJUSTE_16', 'id')
            ->map(function ($valor) {
                return $valor == 1;
            })->toArray();

        $this->ajustesSeleccionados16 = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('R_16', 'id')
            ->map(function ($valor) {
                return $valor == 1;
            })->toArray();

        $jugadoresCollection  = TournamentPlayer::with('player')
            ->where('id_tournament', $this->id_tournament)
            ->where('R_SUBITA', 1)
            ->where('SORTEO_SUBITA', '>', 10)
            ->orderBy('SORTEO_SUBITA')
            ->get();

        $jugadoresCollection16  = TournamentPlayer::with('player')
            ->where('id_tournament', $this->id_tournament)
            ->where('R_SUBITA', 1)
            ->where('SORTEO_TO_16', '<=', 16)
            ->orderBy('SORTEO_TO_16')
            ->get();

        $this->jugadores = $jugadoresCollection->map(function ($jp) {
            return [
                'id' => $jp->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'SORTEO_SUBITA' => $jp->SORTEO_SUBITA,
            ];
        })->keyBy('SORTEO_SUBITA')->all();

        $this->jugadores16 = $jugadoresCollection16->map(function ($jp) {
            return [
                'id' => $jp->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'SORTEO_TO_16' => $jp->SORTEO_TO_16,
            ];
        })->keyBy('SORTEO_TO_16')->all();


        $this->enfrentamientosajustes = [
            ['11', '22'],
            ['12', '21'],
            ['13', '20'],
            ['14', '19'],
            ['15', '18'],
            ['16', '17'],
        ];

        $this->enfrentamientos16 = [
            ['1', '2', '1'],
            ['3', '4', '2'],
            ['5', '6', '3'],
            ['7', '8', '4'],
            ['9', '10', '5'],
            ['11', '12', '6'],
            ['13', '14', '7'],
            ['15', '16', '8'],
        ];
    }

    public function guardarAjustes()
    {
        foreach ($this->enfrentamientosajustes as $index => $par) {
            // Cada $par es un arreglo como ['11', '22']

            foreach ($par as $sorteoSubita) {
                $jugador = collect($this->jugadores)->get($sorteoSubita);
                if (!$jugador) {
                    continue; // Por si no hay jugador con ese número
                }
                $idJugador = $jugador['id'];
                $clave = $par[0];

                $key = "{$idJugador}";

                $seleccionado = $this->ajustesSeleccionados[$key] ?? false;
                $registro = TournamentPlayer::find($idJugador);

                if ($registro) {
                    if ($seleccionado) {
                        $registro->R_AJUSTE_16 = 1;
                        $registro->SORTEO_TO_16 = $clave;
                    } else {
                        $registro->R_AJUSTE_16 = 0;
                        $registro->SORTEO_TO_16 = null; // puedes usar 0 si prefieres
                    }
                    $registro->save();
                }
            }
        }

        foreach ($this->enfrentamientos16 as $index => $row) {

            foreach (array_slice($row, 0, 2) as $sorteoSubita) {
                $jugador = collect($this->jugadores16)->get($sorteoSubita);
                if (!$jugador) {
                    continue; // No hay jugador con ese número
                }
                $idJugador    = $jugador['id'];
                $key          = (string) $idJugador;
                $seleccionado = $this->ajustesSeleccionados16[$key] ?? false;

                $tp = TournamentPlayer::find($idJugador);
                if (!$tp) {
                    continue;
                }
                if ($seleccionado) {
                    $tp->R_16  = 1;
                    $tp->NUM_8 = $row[2]; 
                } else {
                    $tp->R_16  = 0;
                    $tp->NUM_8 = null;
                }

                $tp->save();
            }
        }


        $this->dispatch('grupos-guardados');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-ajuste16');
    }
}
