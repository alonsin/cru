<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\TournamentPlayer;
use Livewire\Component;

class MainTournament extends Component
{

    public $tournament, $idtournament;
    public $playersTournament = [];
    public $grupos = [];
    public $activeTab = 'jugadores';

    public function mount()
    {
        $this->idtournament = $this->tournament->id;
        $this->grupos = [];
    }

    public function showModalNewPlayerForTournament()
    {
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
        return view('livewire.tournaments.tournament.main-tournament');
    }
}
