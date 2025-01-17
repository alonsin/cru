<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use Livewire\Component;

class TournamentMain extends Component
{
    public $idTournament;
    public $tournamentsArray = [];

    protected $listeners = [
        'set-new-data-tournaments' => 'updateDataCards',
    ];

    public function updateDataCards($newTournament)
    {
        $this->tournamentsArray = Tournament::orderBy('id', 'desc')->get();
    }


    public function showModalNewTournament()
    {
        $this->dispatch("setModalNewTournament");
    }

    public function mount()
    {
        $this->tournamentsArray = Tournament::orderBy('id', 'desc')->get();
    }


    public function render()
    {
        return view('livewire.tournaments.tournament-main');
    }
}
