<?php

namespace App\Livewire\Tournaments\tournament;

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
    public $ajustesSeleccionados = [];
    public $numeroSorteo = [];
    public $sorteossubita = [];

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


        $this->ajustesSeleccionados = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('R_SUBITA', 'id')
            ->map(function ($valor) {
                return $valor == 1;
            })->toArray();

        $this->sorteossubita = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('SORTEO_SUBITA', 'id')
            ->toArray();




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

        $this->jugadores2 = TournamentPlayer::with('player')
            ->where('horario', '17:00')
            ->whereIn('SORTEO_PASE_GRUPOS', Arr::flatten($this->enfrentamientos1))
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

        // dd($this->jugadores2);
    }

    public function guardarAjustes()
    {
        foreach ($this->ajustesSeleccionados as $jugadorId => $seleccionado) {
            $registro = TournamentPlayer::find($jugadorId);

            if ($registro) {
                $registro->R_SUBITA = $seleccionado ? 1 : 0;
                $registro->save();
            }
        }

        foreach ($this->sorteossubita as $jugadorId => $valorSorteo) {
            if (!is_null($valorSorteo)) {
                $registro = TournamentPlayer::find($jugadorId);
                if ($registro) {
                    $registro->SORTEO_SUBITA = $valorSorteo ? $valorSorteo : 0;
                    $registro->SORTEO_SUBITA <= 10 ? $registro->SORTEO_TO_16 = $valorSorteo : $registro->SORTEO_TO_16 = null; 
                    $registro->save();
                }
            }
        }

        $this->dispatch('updateGamesRonda16');
        $this->dispatch('grupos-guardados');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-subita');
    }
}
