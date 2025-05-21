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
    public $jugadores = [];
    public $jugadoresDirectos = [];
    public $ajustesSeleccionados = [];

    public function mount()
    {
        $jugadoresCollection  = TournamentPlayer::with('player')
            ->where('id_tournament', $this->id_tournament)
            ->where('R_SUBITA', 1)
            ->where('SORTEO_SUBITA', '>', 10)
            ->orderBy('SORTEO_SUBITA')
            ->get();

        $this->jugadores = $jugadoresCollection->map(function ($jp) {
            return [
                'id' => $jp->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'SORTEO_SUBITA' => $jp->SORTEO_SUBITA,
            ];
        })->keyBy('SORTEO_SUBITA')->all();


        $this->enfrentamientosajustes = [
            ['11', '22'],
            ['12', '21'],
            ['13', '20'],
            ['14', '19'],
            ['15', '18'],
            ['16', '17'],
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

                $key = "{$idJugador}_{$clave}";

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

        $this->dispatch('grupos-guardados');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-ajuste16');
    }
}
