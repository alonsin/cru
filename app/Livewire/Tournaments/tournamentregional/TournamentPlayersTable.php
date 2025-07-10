<?php

namespace App\Livewire\Tournaments\tournamentregional;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Player;
use App\Models\TournamentPlayer;
use App\Traits\CreateGames;
use Illuminate\Database\Eloquent\Builder;

class TournamentPlayersTable extends DataTableComponent
{
    use CreateGames;

    protected $listeners = ['refreshTablePlayersTournament' => 'refreshtable', 'setSaveSorteo1'];
    protected $model = Player::class;
    public array $inputs = [];
    protected $index = 0;
    public $horario = "13:00";
    public $idtournament;

    public function configure(): void
    {
        $this->setPrimaryKey('id'); // Deshabilita la opción de Columns
        $this->setColumnSelectStatus(false); // Desactiva la selección de columnas
    }

    public function builder(): Builder
    {
        $query = TournamentPlayer::query()
            ->with([
                'player',
                'tournament',
            ])
            ->where('horario', $this->horario) // Filtro por horario
            ->where('id_tournament', $this->idtournament); // Filtro por horario

        return $query;
    }

    public function mount()
    {
        $this->inputs = TournamentPlayer::where('horario', $this->horario)
            ->pluck('sorteo_principal', 'id')
            ->toArray();
    }

    public function setSaveSorteo1()
    {
        // dd("diste click en guardar sorteos");
        $valores = array_filter($this->inputs, function ($valor) {
            return is_numeric($valor) && $valor >= 0 && $valor <= 999;
        });


        $conteo = array_count_values($valores);
        // dd($conteo);

        $duplicados = array_filter($conteo, function ($count) {
            return $count > 1;
        });

        // dd($duplicados);


        if (!empty($duplicados)) {
            // dd("entrando aqui weeoi");
            $this->dispatch('duplicados-sorteo-regional');
            // return;
        } else {
            foreach ($this->inputs as $id => $valor) {
                if (!is_numeric($valor) || $valor < 0 || $valor > 999) {
                    continue;
                }

                $registro = TournamentPlayer::find($id);
                if ($registro) {
                    $registro->sorteo_principal = $valor;
                    $registro->save();
                }
            }

            //// CREAR JUEGOS DE 1:00 PM 

            $this->crearJuegosRonda('sorteo_principal', 22, $this->idtournament, 11);

            //// HACER DISPATCH PARA REFRESCAR LOS JUEGOS ACTUALES YA GUARDADOS
            $this->dispatch('refreshAllDataSubitaUno');


            $this->dispatch('updateGruposTables');
            $this->dispatch('sorteos-guardados');
        }
    }

    public function refreshtable()
    {
        $this->resetPage();
        $this->dispatch('closemodalplayers23');
    }


    public function columns(): array
    {
        return [
            Column::make("id")
                ->label(
                    fn() => (++$this->index +  ($this->getPage() - 1) * $this->perPage)
                ),
            Column::make("Id", "id")
                ->sortable()
                ->hideIf(true), // true = oculta; false = muestra
            Column::make("JUGADOR", "player.name_player")
                ->sortable()
                ->searchable(),
            Column::make("SORTEO", "sorteo_principal")
                ->format(function ($value, $row, $column) {
                    $inputValue = $value ?? '';
                    return '<input type="number" 
                  min="0" 
                  max="999" 
                  value="' . $inputValue . '"
                  oninput="if(this.value.length > 3) this.value = this.value.slice(0,3);" 
                  class="text-center fw-bold fs-6" 
                  style="height: 24px;"
                  wire:model.defer="inputs.' . $row->id . '" />';
                })
                ->html(),
            Column::make("Categoría", "player.category.name")
                ->sortable()
                ->format(function ($value, $row, $column) {
                    if ($value === 'Maestro') {
                        return '<span class="badge bg-success">Maestro</span>';
                    } elseif ($value === 'Primera') {
                        return '<span class="badge bg-primary">Primera</span>';
                    } elseif ($value === 'Segunda') {
                        return '<span class="badge bg-warning text-dark">Segunda</span>';
                    } elseif ($value === 'Tercera') {
                        return '<span class="badge bg-danger">Tercera</span>';
                    } else {
                        return '<span class="badge bg-secondary">Desconocida</span>';
                    }
                })
                ->html(),
            Column::make("CLUB", "player.club.name")
                ->sortable(),
            Column::make("HORARIO", "horario")
                ->sortable(),

            Column::make("Acciones")
                ->label(function ($row) {
                    return '
                            <div class="flex space-x-2">
                <!-- Botón Eliminar -->
                <button wire:click="deletePlayer(' . $row->id . ')" class="text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
                    ';
                })->html()
        ];
    }

    public function deletePlayerTournament($playerId)
    {
        $this->dispatch('delete-data-player', $playerId);
    }
}
