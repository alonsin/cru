<div>
    <style>
        .card-match {
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card-match.finalizado {
            border-left: 16px solid #198754;
        }

        .card-match.enjuego {
            border-left: 6px solid #ffc107;
        }

        .card-match.pendiente {
            border-left: 6px solid #adb5bd;
        }

        .estado-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        .estado-finalizado {
            background-color: #198754;
            color: white;
        }

        .estado-enjuego {
            background-color: #ffc107;
            color: black;
        }

        .estado-pendiente {
            background-color: #6c757d;
            color: white;
        }

        .ganador-check {
            transform: scale(1.2);
            margin: 0 0.5rem;
        }

        .jugador-nombre {
            font-weight: 600;
        }

        .mesa-select,
        .estado-select {
            font-size: 0.7rem !important;
            padding: 0.2rem 0.4rem !important;
            height: auto;
            width: auto;
            min-width: 120px;
        }
    </style>

    {{-- Botones de acción --}}
    <div class="d-flex justify-content-end my-3">
        <button wire:click="guardarAjustes" class="btn btn-success shadow px-4 py-2 d-flex align-items-center gap-2">
            💾 Guardar Juegos
        </button>
        <button wire:click="guardarAjustes" class="btn btn-primary shadow px-4 py-2 d-flex align-items-center gap-2 ms-2">
            🔄 Actualizar Juegos
        </button>
    </div>

    {{-- Tarjetas de enfrentamientos --}}
    @foreach ($enfrentamientos1 as $index => [$clave1, $clave2])
        @php
            $jugador1 = $jugadores1[$clave1] ?? null;
            $jugador2 = $jugadores1[$clave2] ?? null;
            $claveJuego = $clave1 . '-' . $clave2;
            $juego = $juegosGuardadosSubita1[$claveJuego] ?? null;
            $estatus = $juego['estatus'] ?? 0;
            $estadoClase = match((int) $estatus) {
                1 => 'enjuego',
                2 => 'finalizado',
                default => 'pendiente',
            };
            $estadoTexto = match((int) $estatus) {
                1 => '🎯 EN JUEGO',
                2 => '✅ FINALIZADO',
                default => '⏳ PENDIENTE',
            };
            $claseEstado = match((int) $estatus) {
                1 => 'estado-enjuego',
                2 => 'estado-finalizado',
                default => 'estado-pendiente',
            };
        @endphp

        <div class="card-match {{ $estadoClase }}">
            <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                <span class="badge estado-badge {{ $claseEstado }}">{{ $estadoTexto }}</span>

                @if ($juego)
                    <select wire:model="estatusSeleccionados1.{{ $juego['id'] }}"
                            class="form-select estado-select {{ $claseEstado }}">
                        <option value="0">⏳ Pendiente</option>
                        <option value="1">🎯 En juego</option>
                        <option value="2">✅ Finalizado</option>
                    </select>
                @endif
            </div>

            <div class="row text-center">
                <div class="col-md-5 d-flex flex-column align-items-center">
                    <div class="jugador-nombre">{{ $jugador1['nombre'] ?? '---' }}</div>
                    <div class="text-muted">{{ $clave1 }}</div>
                    <input type="checkbox"
                           wire:model="subitasSeleccionados1.{{ $jugador1['id_player'] ?? 'x' }}"
                           wire:click="seleccionarGanadorSubita1('{{ $jugador1['id_player'] ?? 'x' }}', '{{ $jugador2['id_player'] ?? 'x' }}')"
                           class="form-check-input ganador-check mt-1"
                           {{ $estatus === 2 ? 'disabled' : '' }}
                           {{ !$juego ? 'disabled' : '' }}>
                </div>

                <div class="col-md-2 d-flex align-items-center justify-content-center fs-4">🤝</div>

                <div class="col-md-5 d-flex flex-column align-items-center">
                    <div class="jugador-nombre">{{ $jugador2['nombre'] ?? '---' }}</div>
                    <div class="text-muted">{{ $clave2 }}</div>
                    <input type="checkbox"
                           wire:model="subitasSeleccionados1.{{ $jugador2['id_player'] ?? 'x' }}"
                           wire:click="seleccionarGanadorSubita1('{{ $jugador2['id_player'] ?? 'x' }}', '{{ $jugador1['id_player'] ?? 'x' }}')"
                           class="form-check-input ganador-check mt-1"
                           {{ $estatus === 2 ? 'disabled' : '' }}
                           {{ !$juego ? 'disabled' : '' }}>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                @if ($juego)
                    @php
                        $mesaActual = $mesaSeleccionada[$juego['id']] ?? $juego['mesa'];
                    @endphp

                    @if ((int) $estatus === 2)
                        <span class="badge bg-dark fs-6">🎱 MESA {{ $mesaActual }}</span>
                    @else
                        <select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
                                class="form-select mesa-select bg-warning text-dark">
                            <option value="">Selecciona mesa</option>
                            @foreach (range(1, 11) as $mesa)
                                <option value="{{ $mesa }}">MESA {{ $mesa }}</option>
                            @endforeach
                        </select>
                    @endif
                @else
                    <span class="text-muted">Sin juego registrado</span>
                @endif
            </div>
        </div>
    @endforeach
</div>
