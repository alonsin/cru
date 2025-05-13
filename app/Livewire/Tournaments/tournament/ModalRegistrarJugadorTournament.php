<?php

namespace App\Livewire\Tournaments\tournament;

use App\Models\categoryPlayer;
use App\Models\clubPlayer;
use App\Models\estado;
use App\Models\Player;
use Livewire\Component;

class ModalRegistrarJugadorTournament extends Component
{
    public $show = false;
    public $estados, $categorias, $clubes = [];
    public $playersall = [];
    public $estadoSeleccionado, $categoriaSeleccionada, $clubSeleccionada, $nameplayer, $edad, $idPlayer;

    public function mount()
    {
        // $this->resetDatas();
        $this->estados = estado::all();
        $this->categorias = categoryPlayer::all();
        $this->clubes = clubPlayer::all();
    }

    protected $listeners = [
        'setModalNewPlayerForTournmnt' => 'showModal',
    ];

    public function showModal($id)
    {
        // $this->resetDatas();
        // dd("el id es: ", $id);
        $this->playersall = Player::orderBy('name_player', 'asc')->get();
        $this->show = true;
    }


    public function save()
    {
        $data = $this->makingData();
        if ($this->idPlayer != null) {
            $player = Player::find($this->idPlayer);
            $player->update($data);
        } else {
            Player::create($data);
        }
        $this->dispatch('refreshTablePlayers');
        $this->resetDatas();
        $this->show = false;
    }

    public function makingData()
    {
        return $data = [
            'name_player' => $this->nameplayer,
            'id_state' => $this->estadoSeleccionado, // Asumiendo que el estado con id 1 existe
            'id_category_player' => $this->categoriaSeleccionada, // Asumiendo que la categoría con id 2 existe
            'id_club_player' => $this->clubSeleccionada, // Asumiendo que el club con id 3 existe
            'edad' => $this->edad, // La edad es opcional, puede ser NULL si lo deseas
        ];
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.tournaments.tournament.modal-registrar-jugador-torneo');
    }
}
