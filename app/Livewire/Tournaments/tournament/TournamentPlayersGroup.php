<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;

class TournamentPlayersGroup extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];
    public $grupos = [];
    public $grupo = [];

    protected $listeners = [
        'setDataToGroups'
    ];

    public function saveDataGrupos()
    {

        foreach ($this->grupo as $jugadorId => $partidas) {
            $registro = TournamentPlayer::find($jugadorId);
            if (!$registro) continue;

            $partidasValidas = [];
            // Recorremos p1, p2, p3 (pueden venir en cualquier orden)
            foreach ($partidas as $key => $partida) {
                // Saltar si no es un arreglo (por ejemplo si hay 'id' u otro campo)
                if (!is_array($partida)) continue;

                // Verificamos si tiene valores válidos
                if (!empty($partida[0]) || !empty($partida[1])) {
                    $partidasValidas[] = $partida;
                }
                // Solo necesitamos 2 partidas
                if (count($partidasValidas) == 2) break;
            }
            // Asignamos a P1
            if (isset($partidasValidas[0])) {
                $registro->P1_TCAR = $partidasValidas[0][0] ?? null;
                $registro->P1_TENT = $partidasValidas[0][1] ?? null;
            }
            // Asignamos a P2
            if (isset($partidasValidas[1])) {
                $registro->P2_TCAR = $partidasValidas[1][0] ?? null;
                $registro->P2_TENT = $partidasValidas[1][1] ?? null;
            }
            $registro->save();
        }


        $this->dispatch('grupos-guardados');
    }

    public function setDataToGroups($idtournament)
    {
        $this->idtournament = $idtournament;
        $this->grupos = TournamentPlayer::with('player')
            ->orderBy('sorteo_principal')
            ->get()
            ->chunk(3)
            ->map(function ($grupo) {
                return $grupo->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'player_name' => $item->player->name_player,
                        'club' => $item->player->club->name,
                        // Agrega más campos si necesitas
                    ];
                });
            })->toArray();
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-group');
    }
}
