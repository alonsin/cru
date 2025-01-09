<?php

namespace App\Livewire\Players;

use Livewire\Component;

class PlayerMain extends Component
{

    public function showModalNewPlayer(){
       $this->dispatch("setModalNewPlayer");
    }


    public function render()
    {
        return view('livewire.players.player-main');
    }
}
