<?php

namespace App\Livewire\Tournaments;

use Livewire\Component;

class TournamentMain extends Component
{

    // public function showModalNewPlayer(){
    //    $this->dispatch("setModalNewPlayer");
    // }


    public function render()
    {
        return view('livewire.tournaments.tournament-main');
    }
}
