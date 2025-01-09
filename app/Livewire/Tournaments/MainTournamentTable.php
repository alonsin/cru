<?php

namespace App\Livewire\Tournaments;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Player;
use Illuminate\Database\Eloquent\Builder;

class PlayerTable extends DataTableComponent
{
    protected $listeners = ['refreshTablePlayers' => 'refreshtable'];
    protected $model = Player::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id'); // Deshabilita la opción de Columns
        $this->setColumnSelectStatus(false); // Desactiva la selección de columnas
    }

    public function builder(): Builder
    {
        $query = Player::query()
            ->with([
                'state:id,name', 
                'club:id,name',  
                'category:id,name'  
            ]);
        return $query;
    }

    public function refreshtable(){
        $this->resetPage();
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("JUGADOR", "name_player")
                ->sortable()
                ->searchable(),
            Column::make("Categoria", "category.name")
                ->sortable(),
            Column::make("CLUB", "club.name")
                ->sortable(),
            Column::make("Estado", "state.name")
                    ->sortable(),
            Column::make("Edad", "edad")
                ->sortable(),
            Column::make("Acciones")
                ->label(function($row) {
                    return '
                            <div class="flex space-x-2">
                <!-- Botón Editar -->
                <button wire:click="editPlayer(' . $row . ')" class="text-green-500 hover:text-blue-700">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </button>

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

    public function editPlayer($data){
    $this->dispatch('edit-data-player', $data);
    }

    public function deletePlayer($playerId){
        $this->dispatch('delete-data-player', $playerId);
    }
}
