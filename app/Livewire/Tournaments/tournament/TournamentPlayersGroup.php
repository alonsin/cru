<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;

class TournamentPlayersGroup extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];
    public $grupos = [];

    protected $listeners = [
        'setDataToGroups'
    ];

    public function setDataToGroups($idtournament)
    {
        $this->idtournament = $idtournament;
        // $jugadores = TournamentPlayer::with('player')->get();
        $jugadoresRegistrados = TournamentPlayer::where('id_tournament', $this->idtournament)
            ->pluck('id_player');

        // $this->grupos = $jugadoresRegistrados->chunk(3);
      $this->grupos = TournamentPlayer::orderBy('sorteo_principal')->get()->chunk(3)->toArray();
        // $this->grupos = [];
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.tournament-player-group');
    }
}
