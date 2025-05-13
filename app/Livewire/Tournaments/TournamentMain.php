<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use Livewire\Component;

class TournamentMain extends Component
{
    public $idTournament;
    public $selectedTournament;
    public $tournamentsArray = [];

    protected $listeners = [
        'set-new-data-tournaments' => 'updateDataCards',
    ];

    public function updateDataCards($newTournament)
    {
        $this->tournamentsArray = Tournament::orderBy('id', 'desc')->get();
    }

    public function viewTournament($id)
    {
        $this->selectedTournament = Tournament::with(['sede', 'type'])->findOrFail($id);
    }

    public function showModalNewTournament()
    {
        $this->dispatch("setModalNewTournament");
    }

    public function mount()
    {
        $this->selectedTournament = null;
        $this->tournamentsArray = Tournament::orderBy('id', 'desc')->get();
    }


    public function render()
    {
        return view('livewire.tournaments.tournament-main');
    }
}
