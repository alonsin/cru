<div>
	<style>
		/* Fila con color según estatus */
		.table-success>td {
			background-color: #d1e7dd !important;
		}

		.table-warning>td {
			background-color: #fff3cd !important;
		}

		/* Compactar columnas */
		.col-estado,
		.col-mesa {
			width: 115px !important;
			max-width: 115px;
			white-space: nowrap;
		}

		/* Selects de estado y mesa */
		.estado-select,
		.mesa-select {
			padding: 0.1rem 0.25rem !important;
			font-size: 0.65rem !important;
			line-height: 1 !important;
			width: 100% !important;
			max-width: 100% !important;
			border-radius: 0.3rem;
			text-align: center;
		}

		/* Colores para estado */
		.bg-finalizado {
			background-color: #198754 !important;
			color: white !important;
		}

		.bg-enjuego {
			background-color: #ffc107 !important;
			color: black !important;
		}

		.bg-pendiente {
			background-color: #6c757d !important;
			color: white !important;
		}

		/* Mesa (select amarillo) */
		.bg-mesa {
			background-color: #ffc107 !important;
			color: black !important;
		}
	</style>

	<div class="text-center mt-0 mb-3">
		<button wire:click="guardarAjustes" class="btn btn-success me-2">
			<i class="bi bi-save"></i> Guardar Juegos
		</button>
		<button wire:click="sortearGanadores" class="btn btn-warning">
			<i class="bi bi-shuffle"></i> Sortear Jugadores Ganadores
		</button>
	</div>

	<div class="row g-4 mt-0">
		<div class="col-md-12">
			<div class="card shadow-sm mb-4 h-100">
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th class="col-estado">Estado</th>
									<th>Clave 1</th>
									<th>Jugador</th>
									<th>✔</th>
									<th>VS</th>
									<th>✔</th>
									<th>Jugador</th>
									<th>Clave 2</th>
									<th class="col-mesa">Mesa</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos1 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores1[$clave1] ?? null;
								$jugador2 = $jugadores1[$clave2] ?? null;
								$claveJuego = $clave1 . '-' . $clave2;
								$juego = $juegosGuardadosSubita1[$claveJuego] ?? null;
								$estatus = $juego['estatus'] ?? null;
								$rowClass = $estatus == 1 ? 'table-warning' : ($estatus == 2 ? 'table-success' : '');
								@endphp
								<tr class="{{ $rowClass }}">
									{{-- Estado --}}
									<td class="col-estado text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados1[$juego['id']] ?? $juego['estatus'];
										$claseColor = match((int) $estatus) {
										1 => 'bg-enjuego',
										2 => 'bg-finalizado',
										default => 'bg-pendiente',
										};
										@endphp
										<div class="d-flex justify-content-center">
											<select wire:model="estatusSeleccionados1.{{ $juego['id'] }}"
												class="form-select form-select-sm estado-select {{ $claseColor }}">
												<option value="0">⏳ Pendiente</option>
												<option value="1">🎮 En juego</option>
												<option value="2">✅ Finalizado</option>
											</select>
										</div>
										@else
										<span class="badge bg-secondary">⏳</span>
										@endif
									</td>

									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>

									<td>
										<input type="checkbox"
											wire:model="subitasSeleccionados1.{{ $jugador1['id_player'] ?? 'x' }}"
											wire:click="seleccionarGanadorSubita1('{{ $jugador1['id_player'] ?? 'x' }}', '{{ $jugador2['id_player'] ?? 'x' }}')"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>
									</td>

									<td><span class="fs-5">🤝</span></td>

									<td>
										<input type="checkbox"
											wire:model="subitasSeleccionados1.{{ $jugador2['id_player'] ?? 'x' }}"
											wire:click="seleccionarGanadorSubita1('{{ $jugador2['id_player'] ?? 'x' }}', '{{ $jugador1['id_player'] ?? 'x' }}')"
											class="form-check-input"
											aria-label="Ganador {{ $jugador2['nombre'] ?? $clave2 }}"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>
									</td>

									<td><strong>{{ $jugador2['nombre'] ?? '---' }}</strong></td>
									<td>{{ $clave2 }}</td>

									{{-- Mesa --}}
									<td>
										@if ($juego)
										@php
										$mesaActual = $mesaSeleccionada[$juego['id']] ?? $juego['mesa'];
										$opcionesMesa = $mesasDisponibles;
										if ($mesaActual && !in_array($mesaActual, $opcionesMesa)) {
										$opcionesMesa[] = $mesaActual;
										}
										sort($opcionesMesa);
										@endphp

										@if ((int) $estatus === 2)
										<span class="badge bg-dark">
											<i class="bi bi-grid-3x3-gap-fill me-1"></i> {{ $mesaActual }}
										</span>
										@else
										<div class="d-flex justify-content-center">
											<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
												class="form-select form-select-sm mesa-select bg-mesa">
												<option value="">🎱 Mesa</option>
												@foreach ($opcionesMesa as $mesa)
												<option value="{{ $mesa }}">🎱 MESA {{ $mesa }}</option>
												@endforeach
											</select>
										</div>
										@endif
										@else
										<span class="text-muted">---</span>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div> <!-- table-responsive -->
				</div> <!-- card-body -->
			</div> <!-- card -->
		</div> <!-- col -->
	</div> <!-- row -->
</div>