<?php

namespace App\Livewire\Tournaments;

use App\Models\formatTournament;
use App\Models\sedeTournament;
use App\Models\typeTournament;
use Livewire\Component;

class ModalRegistrarTorneo extends Component
{
    public $show = false;
    public $sedes, $tiposTournament, $formatos = [];
    public $sedeSeleccionado, $formatoSeleccionada, $typeSeleccionada, $nameTournament, $fechaTorneo, $idTournament;

    public function mount()
    {
        // $this->resetDatas();
        $this->sedes = sedeTournament::all();
        $this->tiposTournament = typeTournament::all();
        $this->formatos = formatTournament::all();
    }

    protected $listeners = [
        'setModalNewTournament' => 'showModal',
        // 'edit-data-player' => 'editaPlayer',
        // 'delete-data-player' => 'onconfirmdeletePlayer',
        // 'deletePlayerEvent' => 'deletePlayerEvent'
    ];

    public function showModal()
    {
        $this->show = true;
    }

    // public function deletePlayerEvent()
    // {
    //     $player = Player::find($this->idPlayer);
    //     $player->delete();
    //     $this->dispatch('refreshTablePlayers');
    // }

    // public function onconfirmdeletePlayer($playerId)
    // {
    //     $this->idPlayer = $playerId;
    //     $this->dispatch("onconfirmDelete", $playerId);
    // }

    // public function editaPlayer($data)
    // {
    //     $player = Player::find($data['id']);
    //     $this->idPlayer = $player['id'];
    //     $this->nameplayer = $player['name_player'];
    //     $this->estadoSeleccionado = $player['id_state'];
    //     $this->categoriaSeleccionada = $player['id_category_player'];
    //     $this->clubSeleccionada = $player['id_club_player'];
    //     $this->edad = $player['edad'];
    //     $this->show = true;
    // }

    public function save()
    {
        $data = $this->makingData();
        if ($this->idTournament != null) {
            $tournament = Tournament::find($this->idTournament);
            $tournament->update($data);
        } else {
            Tournament::create($data);
        }
        $this->dispatch('refreshTablePlayers');
        $this->resetDatas();
        $this->show = false;
    }

    // public function resetDatas()
    // {
    //     $this->reset([
    //         'nameplayer',
    //         'estadoSeleccionado',
    //         'clubSeleccionada',
    //         'categoriaSeleccionada',
    //         'edad',
    //         'idPlayer',
    //     ]);
    // }

    public function makingData()
    {
        return $data = [
            'name_tournament' => $this->nameTournament,
            'id_sede' => $this->sedeSeleccionado, // Asumiendo que el estado con id 1 existe
            'id_format' => $this->formatoSeleccionada, // Asumiendo que la categoría con id 2 existe
            'id_type' => $this->typeSeleccionada, // Asumiendo que el club con id 3 existe
            'fecha_torneo' => $this->fechaTorneo, // La edad es opcional, puede ser NULL si lo deseas
        ];
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.tournaments.modal-registrar-torneo');
    }
}
