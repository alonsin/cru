<?php

namespace App\Livewire\Tournaments\tournamentregional;

use App\Models\TournamentPlayer;
use Livewire\Component;

class MainTournamentPlayers extends Component
{

    public $id_tournament;
    public $activeTab2 = 'jugadores1';

    public function setActiveTab2($tab)
    {
        $this->activeTab2 = $tab;
    }

    public function showModalNewPlayerForTournamentRegional($horario)
    {
        $this->dispatch(
            "setModalNewPlayerForTournmntRegional",
            [
                'idtournament' => $this->id_tournament,
                'horario' => $horario,
            ]
        );
    }

    public function render()
    {
        return view('livewire.tournaments.tournamentregional.main-tournament-players');
    }
}
