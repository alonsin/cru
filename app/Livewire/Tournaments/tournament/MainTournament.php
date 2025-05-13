<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;

class MainTournament extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];

    public function mount()
    {
        $this->idtournament = $this->tournament->id;
        $this->playersTournament = TournamentPlayer::with([
            'player',
            'tournament',
            'player.state',
            'player.category',
            'player.club'
        ])
            ->where('id_tournament', $this->tournament->id)
            ->get();
    }

    public function showModalNewPlayerForTournament()
    {
        // dd("lazaremos el modal aqui");
        $this->dispatch("setModalNewPlayerForTournmnt", $this->idtournament);
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.main-tournament');
    }
}
