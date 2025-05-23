<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;
use Illuminate\Support\Arr;

class TournamentPlayersFinals extends Component
{

    public $id_tournament;
    public $enfrentamientos2 = [];
    public $enfrentamientos8 = [];
    public $enfrentamientos4 = [];
    public $enfrentamientofinal = [];
    public $jugadores8 = [];
    public $jugadores4 = [];
    public $jugadores2 = [];
    public $jugadoresDirectos = [];
    public $ajustesSeleccionados8 = [];
    public $ajustesSeleccionados4 = [];
    public $ajustesSeleccionados2 = [];
    public $ganadores8 = [];
    public $ganadores4 = [];

    public function mount()
    {
        $this->ronda8();
        $this->mostrarganadores8();
        $this->ronda4();
        $this->mostrarganadores4();
        $this->ronda2();
    }

    public function guardarAjustes()
    {
        $this->guardar8();
        $this->guardar4();
        $this->guardar2();


        $this->dispatch('grupos-guardados');
    }

    public function guardar8()
    {
        foreach ($this->enfrentamientos8 as $index => $row) {
            [$clave1, $clave2, $num4] = $row;

            $jugador1 = $this->jugadores8[$clave1] ?? null;
            $jugador2 = $this->jugadores8[$clave2] ?? null;

            $ganadorId = $this->ganadores8[$index] ?? null;

            foreach ([$jugador1, $jugador2] as $jugador) {
                if (!$jugador) continue;

                $tp = TournamentPlayer::find($jugador['id']);
                if (!$tp) continue;

                if ($jugador['id'] == $ganadorId) {
                    $tp->R_8 = 1;
                    $tp->NUM_4 = $num4;
                } else {
                    if ($ganadorId !== null) {
                        $tp->R_8 = 0;
                        $tp->NUM_4 = null;
                    }
                }

                $tp->save();
            }
        }

        $this->ronda4(); // recarga resultados si es necesario
    }


    public function guardar4()
    {
        foreach ($this->enfrentamientos4 as $index => $row) {
            [$clave1, $clave2, $num4] = $row;

            $jugador1 = $this->jugadores4[$clave1] ?? null;
            $jugador2 = $this->jugadores4[$clave2] ?? null;

            if (!$jugador1 || !$jugador2) {
                continue;
            }

            $ganadorId = $this->ganadores4[$index] ?? null;

            foreach ([$jugador1, $jugador2] as $jugador) {
                $tp = TournamentPlayer::find($jugador['id']);
                if (!$tp) continue;

                if ($jugador['id'] == $ganadorId) {
                    $tp->R_8 = 1;
                    $tp->NUM_4 = $num4;
                } else {
                    $tp->R_8 = 0;
                    $tp->NUM_4 = null;
                }

                $tp->save();
            }
        }
        $this->ronda4();
    }

    public function guardar2()
    {
        foreach ($this->enfrentamientos2 as $index => $row) {

            foreach (array_slice($row, 0, 2) as $sorteoSubita) {
                $jugador = collect($this->jugadores2)->get($sorteoSubita);
                if (!$jugador) {
                    continue;
                }
                $idJugador    = $jugador['id'];
                $key          = (string) $idJugador;
                $seleccionado = $this->ajustesSeleccionados2[$key] ?? false;

                $tp = TournamentPlayer::find($idJugador);
                if (!$tp) {
                    continue;
                }
                if ($seleccionado) {
                    $tp->R_FINAL  = 1;
                } else {
                    $tp->R_FINAL  = 0;
                }

                $tp->save();
            }
        }
    }

    public function ronda8()
    {

        $this->enfrentamientos8 = [
            ['1', '2', '1'],
            ['3', '4', '2'],
            ['5', '6', '3'],
            ['7', '8', '4'],
        ];

        $this->ajustesSeleccionados8 = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('R_8', 'id')
            ->map(function ($valor) {
                return $valor == 1;
            })->toArray();

        $jugadoresCollection8  = TournamentPlayer::with('player')
            ->where('id_tournament', $this->id_tournament)
            ->where('R_16', 1)
            ->where('NUM_8', '<=', 8)
            ->orderBy('NUM_8')
            ->get();

        $this->jugadores8 = $jugadoresCollection8->map(function ($jp) {
            return [
                'id' => $jp->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'NUM_8' => $jp->NUM_8,
            ];
        })->keyBy('NUM_8')->all();
    }

    public function ronda4()
    {
        $this->enfrentamientos4 = [
            ['1', '2', '1'],
            ['3', '4', '2'],
        ];

        $this->ajustesSeleccionados4 = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('R_SEMIF', 'id')
            ->map(function ($valor) {
                return $valor == 1;
            })->toArray();

        $jugadoresCollection4 = TournamentPlayer::with('player')
            ->where('id_tournament', $this->id_tournament)
            ->where('R_8', 1)
            ->where('NUM_4', '<=', 4)
            ->orderBy('NUM_4')
            ->get();

        $this->jugadores4 = $jugadoresCollection4->map(function ($jp) {
            return [
                'id' => $jp->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'NUM_4' => $jp->NUM_4,
            ];
        })->keyBy('NUM_4')->all();
    }

    public function ronda2()
    {
        $this->enfrentamientos2 = [
            ['1', '2', '1'],
        ];

        $this->ajustesSeleccionados2 = TournamentPlayer::where('id_tournament', $this->id_tournament)
            ->pluck('R_FINAL', 'id')
            ->map(function ($valor) {
                return $valor == 1;
            })->toArray();

        $jugadoresCollection2 = TournamentPlayer::with('player')
            ->where('id_tournament', $this->id_tournament)
            ->where('R_SEMIF', 1)
            ->where('NUM_2', '<=', 2)
            ->orderBy('NUM_2')
            ->get();

        $this->jugadores2 = $jugadoresCollection2->map(function ($jp) {
            return [
                'id' => $jp->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'NUM_2' => $jp->NUM_2,
            ];
        })->keyBy('NUM_2')->all();
    }

    public function mostrarganadores8()
    {
        $this->ganadores8 = [];

        foreach ($this->enfrentamientos8 as $index => $row) {
            [$clave1, $clave2] = $row;

            $j1 = $this->jugadores8[$clave1] ?? null;
            $j2 = $this->jugadores8[$clave2] ?? null;

            if (!$j1 || !$j2) continue;

            $tp1 = TournamentPlayer::find($j1['id']);
            $tp2 = TournamentPlayer::find($j2['id']);

            if ($tp1 && $tp1->R_8 == 1) {
                $this->ganadores8[$index] = $tp1->id;
            } elseif ($tp2 && $tp2->R_8 == 1) {
                $this->ganadores8[$index] = $tp2->id;
            }
        }
    }

    public function mostrarganadores4()
    {
        $this->ganadores4 = [];

        foreach ($this->enfrentamientos4 as $index => $row) {
            [$clave1, $clave2] = $row;

            $j1 = $this->jugadores4[$clave1] ?? null;
            $j2 = $this->jugadores4[$clave2] ?? null;

            if (!$j1 || !$j2) continue;

            $tp1 = TournamentPlayer::find($j1['id']);
            $tp2 = TournamentPlayer::find($j2['id']);

            if ($tp1 && $tp1->R_8 == 1) {
                $this->ganadores4[$index] = $tp1->id;
            } elseif ($tp2 && $tp2->R_8 == 1) {
                $this->ganadores4[$index] = $tp2->id;
            }
        }
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-finals');
    }
}
