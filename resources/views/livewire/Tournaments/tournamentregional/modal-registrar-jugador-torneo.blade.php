<div>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 {{ $show ? 'block' : 'hidden' }}">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h2 class="text-lg text-center mb-4">Registra Nuevo Jugador para Torneo</h2>
            <h2 class="text-lg text-center">{{$horario}} Hrs</h2>
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700">Jugador</label>
                    <select id="playerSelect" wire:model="idplayer" class="w-full select2 border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Selecciona un jugador</option>
                        @foreach($playersall as $player)
                        <option value="{{ $player->id }}">{{ $player->name_player }}</option>
                        @endforeach
                    </select>
                    @error('idplayer')
                    <small class="text-danger err-message">
                        <i class="fa fa-info-circle"></i>&nbsp;{{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">
                        Cancelar
                    </button>
                    <button type="button" wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>