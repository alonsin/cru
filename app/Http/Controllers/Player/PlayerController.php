<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function index()
    {
        return view('livewire.players.player');
    }
}
