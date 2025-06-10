<?php

namespace App\Livewire\Tournaments\tournamentregional;

use App\Models\TournamentPlayer;
use Livewire\Component;

class MainTournament extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];
    public $grupos = [];
    public $activeTab = 'jugadores';
    public $activeTab2 = 'jugadores1';

    public function mount()
    {
        $this->idtournament = $this->tournament->id;
        $this->grupos = [];
    }

    public function setActiveTab($tab)
    {     
        $this->activeTab = $tab;      
    }

    public function setActiveTab2($tab)
    {
        $this->activeTab2 = $tab;
        if($this->activeTab2 == 'jugadores3'){

        }

    }

    public function showModalNewPlayerForTournament()
    {
        // dd($this->activeTab);
        $this->dispatch("setModalNewPlayerForTournmnt", $this->idtournament);
    }

    public function setDataTournament()
    {
        $this->activeTab = 'grupos';
        $this->dispatch("setDataToGroups", $this->idtournament);
    }

    public function saveSorteo()
    {
        $this->dispatch('setSaveSorteo');
    }

    public function render()
    {
        return view('livewire.tournaments.tournamentregional.main-tournament');
    }
}
