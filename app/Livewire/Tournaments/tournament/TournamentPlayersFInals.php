<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;
use Illuminate\Support\Arr;

class TournamentPlayersFinals extends Component
{

    public $id_tournament;
    public $enfrentamientos = [];
    public $enfrentamientosajustes = [];
    public $enfrentamientos16 = [];
    public $enfrentamientofinal = [];
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
            ['1', '2'],
            ['3', '4'],
            ['5', '6'],
            ['7', '8'],
        ];

        $this->enfrentamientos16 = [
            ['1', '2'],
            ['3', '4'],
        ];

        $this->enfrentamientofinal = [
            ['1', '2'],
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

        foreach ($this->enfrentamientos16 as $index => $par) {
            // Cada $par es un arreglo como ['11', '22']
            foreach ($par as $sorteoSubita) {
                $jugador = collect($this->jugadores16)->get($sorteoSubita);
                if (!$jugador) {
                    continue; // Por si no hay jugador con ese número
                }
                $idJugador = $jugador['id'];
                $clave = $par[0];

                $key = "{$idJugador}";

                $seleccionado = $this->ajustesSeleccionados16[$key] ?? false;
                $registro = TournamentPlayer::find($idJugador);

                if ($registro) {         
                    if ($seleccionado) {
                        $registro->R_16 = 1;
                    } else {
                        $registro->R_16 = 0;
                    }
                    $registro->save();
                }
            }
        }

        $this->dispatch('grupos-guardados');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-finals');
    }
}
