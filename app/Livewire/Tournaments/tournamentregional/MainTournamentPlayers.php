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

    public function saveSorteo1()
    {
        $this->dispatch('setSaveSorteo1');
    }

    public function saveSorteo2()
    {
        $this->dispatch('setSaveSorteo2');
    }
    public function saveSorteo3()
    {
       
        $this->dispatch('setSaveSorteo3');
    }
    public function saveSorteo4()
    {
        $this->dispatch('setSaveSorteo4');
    }
    public function saveSorteo5()
    {
        $this->dispatch('setSaveSorteo5');
    }

    public function render()
    {
        return view('livewire.tournaments.tournamentregional.main-tournament-players');
    }
}
