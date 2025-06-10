<?php

namespace App\Livewire\Tournaments\tournamentregional;

use App\Models\Player;
use App\Models\TournamentPlayer;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ModalRegistrarJugadorTournament extends Component
{
    public $idtournament, $idplayer, $horario;
    public $show = false;
    public $estados, $categorias, $clubes = [];
    public $playersall = [];

    protected $listeners = [
        'setModalNewPlayerForTournmntRegional' => 'showModal',
        'closemodalplayers23' => 'closeModale',
    ];

    public function closeModale()
    {
        $this->closeModal();
    }

    public function showModal($data)
    {
        $this->reset('idplayer', 'horario');
        $this->idtournament = $data['idtournament'];
        $this->horario = $data['horario'];

        $jugadoresRegistrados = TournamentPlayer::where('id_tournament', $this->idtournament)
            ->pluck('id_player');

        $this->playersall = Player::whereNotIn('id', $jugadoresRegistrados)
            ->orderBy('name_player', 'asc')
            ->get();

        $this->show = true;
    }

    public function mount()
    {
        $this->reset('idplayer', 'horario');
    }

    public function validatedata()
    {
        try {
            $this->validate([
                'idplayer' => 'required',
                'horario' => 'required',
            ], [], [
                'idplayer' => 'Jugador',
                'horario' => 'Horario',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }


    public function save()
    {
        $this->validatedata();
        $existe = TournamentPlayer::where('id_tournament', $this->idtournament)
            ->where('id_player', $this->idplayer)
            ->exists();

        if ($existe) {
            throw ValidationException::withMessages([
                'idplayer' => 'El jugador ya está registrado en este torneo.',
            ]);
        } else {
            $data = $this->makingData();
            TournamentPlayer::create($data);
            $this->dispatch('refreshTablePlayersTournament');
        }
    }

    public function makingData()
    {

        return $data = [
            'id_tournament' => $this->idtournament,
            'id_player' => $this->idplayer,
            'horario' => $this->horario,
        ];
    }

    public function closeModal()
    {
        $this->show = false;
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.tournaments.tournamentregional.modal-registrar-jugador-torneo');
    }
}
