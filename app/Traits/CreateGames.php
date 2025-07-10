<?php

namespace App\Traits;

use App\Models\Game;
use App\Models\TournamentPlayer;
use Illuminate\Support\Arr;

trait CreateGames
{
    public $enfrentamientos1 = [];
    public $jugadores1 = [];

    public function createArrayEnfrentamientos($cantidadJugadores)
    {
        $this->enfrentamientos1 = [];
        if ($cantidadJugadores > 32) {
            $objetivoJugadores = 32;
            $enfrentamientosNecesarios = $cantidadJugadores - $objetivoJugadores;

            for ($i = 0; $i < $enfrentamientosNecesarios; $i++) {
                $jugador1 = 10 + $i;
                $jugador2 = $cantidadJugadores - $i;
                $this->enfrentamientos1[] = [strval($jugador1), strval($jugador2)];
            }
        } else {
            $enfrentamientosNecesarios = intval($cantidadJugadores / 2);

            for ($i = 0; $i < $enfrentamientosNecesarios; $i++) {
                $jugador1 = ($i * 2) + 1;
                $jugador2 = ($i * 2) + 2;
                $this->enfrentamientos1[] = [strval($jugador1), strval($jugador2)];
            }
        }
    }

    /// FASE TORNEO CORRESPONDE A EL CAMPO Y LA FASE EN QUE SE VA EN LA BD por ejemplo sorteo_principal, SORTEO_SUBITA etc///
    public function getJugadoresRonda($fase_torneo, $id_tournament)
    {




        /////// VALIDAR QUE SI ES MEDIANTE EL HORARIO ENTONCES AGREGAR ESE FILTRO //////



        $jugadoresCollection1  = TournamentPlayer::with('player')
            ->where('id_tournament', $id_tournament)
            ->whereIn($fase_torneo, Arr::flatten($this->enfrentamientos1))
            ->get();

        $this->jugadores1 = $jugadoresCollection1->map(function ($jp) {
            return [
                'id' => $jp->id,
                'id_player' => $jp->player->id,
                'nombre' => $jp->player->name_player ?? 'Sin nombre',
                'sorteo_principal' => $jp->sorteo_principal,
            ];
        })->keyBy('sorteo_principal')->all();
    }

    //// AQUI EN ESTE CASO LA RONDA SI CORRESPONDE AL ID DEL CATALOGO DE RONDA EN BD //////
    public function createGamesROnda($id_tournament, $ronda)
    {
        foreach ($this->enfrentamientos1 as $index => $par) {

            [$clave1, $clave2] = $par;
            if (isset($this->jugadores1[$clave1]) && isset($this->jugadores1[$clave2])) {
                $jugador1 = $this->jugadores1[$clave1];
                $jugador2 = $this->jugadores1[$clave2];

                $juego = Game::where('id_tournament', $id_tournament)
                    ->where('ronda', $ronda)
                    ->where('p1', $jugador1['id_player'])
                    ->where('p2', $jugador2['id_player'])
                    ->first();

                if (!$juego) {
                    Game::create([
                        'id_tournament' => $id_tournament,
                        'mesa' => null,
                        'CP1' => $clave1,
                        'p1' => $jugador1['id_player'],
                        'wp1' => null,
                        'p2' => $jugador2['id_player'],
                        'wp2' => null,
                        'CP2' => $clave2,
                        'ronda' => $ronda,
                        'estatus' => 0,
                    ]);
                }
            }
        }
    }

    //// CANTIDAD DE JUGADORES PARA SUBITA SERIAN 22 //
    public function crearJuegosRonda($fase_torneo, $cantidadJugadores, $id_tournament, $ronda)
    {
        // dd($id_tournament);
        $this->createArrayEnfrentamientos($cantidadJugadores);
        $this->getJugadoresRonda($fase_torneo, $id_tournament);
        $this->createGamesROnda($id_tournament, $ronda);
    }
}
