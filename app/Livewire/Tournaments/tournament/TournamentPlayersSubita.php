<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;
use Illuminate\Support\Arr;

class TournamentPlayersSubita extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];
    public $enfrentamientos = [];
    public $jugadores1 = [];
    public $ajustesSeleccionados = [];

    public function mount()
    {
        $this->enfrentamientos = [
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

        $this->ajustesSeleccionados = TournamentPlayer::pluck('R_AJUSTE_16', 'id')->map(function ($valor) {
            return $valor == 1;
        })->toArray();

        $this->jugadores1 = TournamentPlayer::with('player')
            ->where('horario', '14:00')
            ->whereIn('SORTEO_PASE_GRUPOS', Arr::flatten($this->enfrentamientos))
            ->get()
            ->mapWithKeys(function ($jugador) {
                return [
                    $jugador->SORTEO_PASE_GRUPOS => [
                        'id' => $jugador->id,
                        'nombre' => $jugador->player->name_player ?? '',
                    ]
                ];
            })
            ->toArray();
    }

    public function guardarAjustes()
    {
        foreach ($this->ajustesSeleccionados as $jugadorId => $seleccionado) {
            $registro = TournamentPlayer::find($jugadorId);

            if ($registro) {
                $registro->R_AJUSTE_16 = $seleccionado ? 1 : 0;
                $registro->save();
            }
        }

        $this->dispatch('grupos-guardados');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-subita');
    }
}
