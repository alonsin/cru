<div>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 {{ $show ? 'block' : 'hidden' }}">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h2 class="text-lg text-center mb-4">Registra Nuevo Torneo</h2>
            <form>
                <!-- Campos del formulario -->
                <div class="mb-4">
                    <label class="block text-gray-700">Nombre:</label>
                    <input wire:model="nameplayer" type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Sede Torneo:</label>
                    <select id="estado" name="estado" wire:model="estadoSeleccionado" class="block w-full px-4 py-2 text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Selecciona un estado</option>
                        @foreach ($sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Tipo Torneo:</label>
                    <select id="estado" name="estado" wire:model="categoriaSeleccionada" class="block w-full px-4 py-2 text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Selecciona categoria</option>
                        @foreach ($tiposTournament as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Formato:</label>
                    <select id="estado" name="club" wire:model="clubSeleccionada" class="block w-full px-4 py-2 text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Selecciona club</option>
                        @foreach ($formatos as $formato)
                        <option value="{{ $formato->id }}">{{ $formato->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Fecha del Torneo:</label>
                    <input
                        type="date"
                        id="fecha_torneo"
                        name="fecha_torneo"
                        class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-700" />
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