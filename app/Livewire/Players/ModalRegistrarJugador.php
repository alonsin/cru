<?php

namespace App\Livewire\Players;

use App\Models\categoryPlayer;
use App\Models\clubPlayer;
use App\Models\estado;
use App\Models\Player;
use Livewire\Component;

class ModalRegistrarJugador extends Component
{
    public $show = false;
    public $estados, $categorias, $clubes = [];
    public $estadoSeleccionado, $categoriaSeleccionada, $clubSeleccionada, $nameplayer, $edad, $idPlayer;

    public function mount()
    {
        $this->resetDatas();
        $this->estados = estado::all(); 
        $this->categorias = categoryPlayer::all(); 
        $this->clubes = clubPlayer::all(); 
    }

    protected $listeners = [
        'setModalNewPlayer' => 'showModal', 
        'edit-data-player' => 'editaPlayer',
        'delete-data-player' => 'onconfirmdeletePlayer',   
        'deletePlayerEvent' => 'deletePlayerEvent'   
    ];

    public function showModal()
    {
        $this->show = true;
    }

    public function deletePlayerEvent(){
        $player = Player::find($this->idPlayer);
        $player->delete();
        $this->dispatch('refreshTablePlayers');
    }

    public function onconfirmdeletePlayer($playerId){
        $this->idPlayer = $playerId;
        $this->dispatch("onconfirmDelete", $playerId);        
    }

    public function editaPlayer($data){
        $player = Player::find($data['id']);
        $this->idPlayer = $player['id'];
        $this->nameplayer = $player['name_player'];
        $this->estadoSeleccionado = $player['id_state'];
        $this->categoriaSeleccionada = $player['id_category_player'];
        $this->clubSeleccionada = $player['id_club_player'];
        $this->edad = $player['edad'];
        $this->show = true;
    }

    public function save(){
        $data = $this->makingData();
        if($this->idPlayer != null){
            $player = Player::find($this->idPlayer);
            $player->update($data);
        }else{
            Player::create($data);            
        }
        $this->dispatch('refreshTablePlayers');
        $this->resetDatas();       
        $this->show = false;
    }

    public function resetDatas(){
        $this->reset([
            'nameplayer',
            'estadoSeleccionado',
            'clubSeleccionada',
            'categoriaSeleccionada',
            'edad',
        ]);
    }

    public function makingData(){
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
        return view('livewire.players.modal-registrar-jugador');
    }
}
