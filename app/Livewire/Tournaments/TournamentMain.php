<?php

namespace App\Livewire\Tournaments;

use Livewire\Component;

class TournamentMain extends Component
{

    public function showModalNewTournament()
    {
        $this->dispatch("setModalNewTournament");
    }


    public function render()
    {
        return view('livewire.tournaments.tournament-main');
    }
}
