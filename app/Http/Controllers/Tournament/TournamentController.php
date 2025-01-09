<?php

namespace App\Http\Controllers\Tournament;

use App\Http\Controllers\Controller;

class TournamentController extends Controller
{
    public function index()
    {
        return view('livewire.tournaments.main');
    }
}
