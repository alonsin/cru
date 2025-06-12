<?php

namespace App\Livewire\Tournaments\tournamentregional;

use Livewire\Component;

class TournamentPlayersSubita extends Component
{

	public $tournament, $idtournament, $id_tournament;
	public $activeTab3 = 'jugadores1';

	public function setActiveTab3($tab)
	{
		$this->activeTab3 = $tab;
	}

	public function render()
	{
		return view('livewire.tournaments.tournamentregional.tournament-player-subita');
	}
}
