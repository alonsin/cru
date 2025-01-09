<div>
<div class="p-6 lg:p-5 bg-white border-b border-gray-200">
<div class="container mx-auto px-4 py-1">
        <div class="flex justify-between items-center mb-6">
        <div class="flex justify-center w-full">
                <button wire:click="showModalNewPlayer()" class="bg-lime-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Registrar Nuevo Jugador
                </button>   
                <livewire:players.modal-registrar-jugador />
            </div>
        </div>
        <div class="overflow-x-auto">
        <livewire:players.player-table />
        </div>
    </div> 
    <script>

    document.addEventListener('DOMContentLoaded', function () {
        
        Livewire.on('onconfirmDelete', (id) => {
            Swal.fire({
                title: '¿Estás seguro de elimiar el registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Livewire.emit('deleteConfirmed', id);
                    Livewire.dispatch('deletePlayerEvent');
                }
            });
        });
    });
</script> 
</div>
</div>



