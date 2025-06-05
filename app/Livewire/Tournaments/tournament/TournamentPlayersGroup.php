<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;

class TournamentPlayersGroup extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];
    public $grupos = [];
    public $grupos2 = [];
    public $grupo = [];

    protected $listeners = [
        'setDataToGroups'
    ];

    public function saveDataGrupos()
    {
        // Recorremos cada chunk (grupo)…
        foreach ($this->grupos as $chunk) {
            // …y dentro cada jugador (que es un array con clave 'id', 'player_name', 'p1', 'p2', etc.)
            foreach ($chunk as $jugadorData) {
                // Usamos el ID real, no el offset del array
                $registro = TournamentPlayer::find($jugadorData['id']);
                if (! $registro) {
                    continue;
                }

                // ---- P1 (primer partido que jugó) ----
                // Si hay algún dato en p1[0] o p1[1], lo guardamos; si no, lo nulificamos
                if (! empty($jugadorData['p1'][0]) || ! empty($jugadorData['p1'][1])) {
                    $registro->P1_TCAR = $jugadorData['p1'][0];
                    $registro->P1_TENT = $jugadorData['p1'][1];
                } else {
                    $registro->P1_TCAR = null;
                    $registro->P1_TENT = null;
                }

                // ---- P2 (segundo partido que jugó) ----
                if (! empty($jugadorData['p2'][0]) || ! empty($jugadorData['p2'][1])) {
                    $registro->P2_TCAR = $jugadorData['p2'][0];
                    $registro->P2_TENT = $jugadorData['p2'][1];
                } else {
                    $registro->P2_TCAR = null;
                    $registro->P2_TENT = null;
                }
                $registro->SORTEO_PASE_GRUPOS = $jugadorData['S_PASE_GRUPOS'] ?: null;
                // Guardamos el registro
                $registro->save();
            }
        }

        foreach ($this->grupos2 as $chunk) {
            // …y dentro cada jugador (que es un array con clave 'id', 'player_name', 'p1', 'p2', etc.)
            foreach ($chunk as $jugadorData) {
                // Usamos el ID real, no el offset del array
                $registro = TournamentPlayer::find($jugadorData['id']);
                if (! $registro) {
                    continue;
                }

                // ---- P1 (primer partido que jugó) ----
                // Si hay algún dato en p1[0] o p1[1], lo guardamos; si no, lo nulificamos
                if (! empty($jugadorData['p1'][0]) || ! empty($jugadorData['p1'][1])) {
                    $registro->P1_TCAR = $jugadorData['p1'][0];
                    $registro->P1_TENT = $jugadorData['p1'][1];
                } else {
                    $registro->P1_TCAR = null;
                    $registro->P1_TENT = null;
                }

                // ---- P2 (segundo partido que jugó) ----
                if (! empty($jugadorData['p2'][0]) || ! empty($jugadorData['p2'][1])) {
                    $registro->P2_TCAR = $jugadorData['p2'][0];
                    $registro->P2_TENT = $jugadorData['p2'][1];
                } else {
                    $registro->P2_TCAR = null;
                    $registro->P2_TENT = null;
                }
                $registro->SORTEO_PASE_GRUPOS = $jugadorData['S_PASE_GRUPOS'] ?: null;
                // Guardamos el registro
                $registro->save();
            }
        }

        // Disparamos el evento de “guardado”
        $this->dispatch('grupos-guardados');
        $this->getDataAll();
        $this->getDataAll2();
    }

    public function getDataAll()
    {
        $this->grupos = TournamentPlayer::with(['player.club'])
            ->whereNotNull('sorteo_principal') // Solo jugadores con sorteo definido
            ->where('horario', '14:00')        // Filtro por horario 14:00
            ->orderBy('sorteo_principal', 'asc') // Orden ascendente por sorteo
            ->get()
            ->chunk(3) // Agrupar cada 3 jugadores
            ->map(function ($chunk) {
                return $chunk->map(function ($item) {
                    return [
                        'id'          => $item->id,
                        'player_name' => $item->player->name_player,
                        'club'        => $item->player->club->name,
                        'p1'          => [$item->P1_TCAR, $item->P1_TENT],
                        'p2'          => [$item->P2_TCAR, $item->P2_TENT],
                        'p3'          => [$item->P3_TCAR ?? null, $item->P3_TENT ?? null], // si aplica
                        'T_CAR'       => (int)$item->T_CARAMBOLAS,
                        'T_ENT'       => (int)$item->T_ENTRADAS,
                        'PROM'        => $item->PROM,
                        'S_PASE_GRUPOS' => $item->SORTEO_PASE_GRUPOS,
                    ];
                })->toArray();
            })
            ->toArray();
    }

    public function getDataAll2()
    {
        $this->grupos2 = TournamentPlayer::with(['player.club'])
            ->whereNotNull('sorteo_principal') // Solo jugadores con sorteo definido
            ->where('horario', '17:00')        // Filtro por horario 14:00
            ->orderBy('sorteo_principal', 'asc') // Orden ascendente por sorteo
            ->get()
            ->chunk(3) // Agrupar cada 3 jugadores
            ->map(function ($chunk) {
                return $chunk->map(function ($item) {
                    return [
                        'id'          => $item->id,
                        'player_name' => $item->player->name_player,
                        'club'        => $item->player->club->name,
                        'p1'          => [$item->P1_TCAR, $item->P1_TENT],
                        'p2'          => [$item->P2_TCAR, $item->P2_TENT],
                        'p3'          => [$item->P3_TCAR ?? null, $item->P3_TENT ?? null], // si aplica
                        'T_CAR'       => (int)$item->T_CARAMBOLAS,
                        'T_ENT'       => (int)$item->T_ENTRADAS,
                        'PROM'        => $item->PROM,
                        'S_PASE_GRUPOS' => $item->SORTEO_PASE_GRUPOS,
                    ];
                })->toArray();
            })
            ->toArray();
    }

    public function setDataToGroups($idtournament)
    {
        $this->idtournament = $idtournament;
        $this->getDataAll();
        $this->getDataAll2();
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-group');
    }
}
