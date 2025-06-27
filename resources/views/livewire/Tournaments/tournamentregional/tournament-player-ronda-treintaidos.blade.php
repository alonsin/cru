<div>
	<style>
		/* Para aplicar color de fondo directamente en <tr> */
		.table-row-success>td {
			background-color: #d1e7dd !important;
		}

		.table-row-warning>td {
			background-color: #fff3cd !important;
		}

		.table-row-pendiente>td {
			background-color: #f8f9fa !important;
		}

		.col-estado {
			width: 110px !important;
			/* Justo lo que ocupa "FINALIZADO" con padding */
			max-width: 110px;
			white-space: nowrap;
		}

		.estado-select {
			padding: 0.5rem 0.25rem !important;
			font-size: 0.65rem !important;
			line-height: 1 !important;
			width: 100%;
			/* Para que no crezca más que el td */
			min-width: unset !important;
			max-width: 100% !important;
		}

		/* Centrado + apariencia visual */
		.estado-select,
		.mesa-select {
			padding: 0.2rem 0.4rem;
			font-size: 0.75rem;
			min-width: 120px;
			text-align: center;
			border-radius: 0.375rem;
		}

		.estado-finalizado {
			background-color: #198754 !important;
			color: white !important;
		}

		.estado-enjuego {
			background-color: #ffc107 !important;
			color: black !important;
		}

		.estado-pendiente {
			background-color: #6c757d !important;
			color: white !important;
		}
	</style>
	<div>
		{{-- Botón de Guardado --}}
		<div class="d-flex justify-content-end my-3">
			<button wire:click="guardarAjustes" class="btn btn-success shadow px-4 py-2 d-flex align-items-center gap-2">
				<i class="bi bi-save"></i> Guardar Juegos
			</button>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card shadow">
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-hover table-striped align-middle text-center mb-0">
								<thead class="table-dark sticky-top shadow-sm" style="z-index: 1;">
									<tr>
										<th class="col-estado">Estado</th>
										<th>Clave 1</th>
										<th>Jugador 1</th>
										<th>✔</th>
										<th>VS</th>
										<th>✔</th>
										<th>Jugador 2</th>
										<th>Clave 2</th>
										<th class="col-estado">Mesa</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($enfrentamientos1 as $index => [$clave1, $clave2])
									@php
									$jugador1 = $jugadores1[$clave1] ?? null;
									$jugador2 = $jugadores1[$clave2] ?? null;
									$claveJuego = $clave1 . '-' . $clave2;
									$juego = $juegosGuardadosSubita1[$claveJuego] ?? null;
									$estatus = $juego['estatus'] ?? 0;
									$rowClass = match((int) $estatus) {
									1 => 'table-row-warning',
									2 => 'table-row-success',
									default => 'table-row-pendiente',
									};
									@endphp

									<tr class="{{ $rowClass }}">
										{{-- Estado --}}
										<td class="col-estado">
											@if ($juego)
											@php
											$estatus = $estatusSeleccionados1[$juego['id']] ?? $juego['estatus'];
											$claseEstado = match((int) $estatus) {
											1 => 'estado-enjuego',
											2 => 'estado-finalizado',
											default => 'estado-pendiente',
											};
											@endphp
											<div class="d-flex justify-content-center">
												<select wire:model="estatusSeleccionados1.{{ $juego['id'] }}"
													class="form-select form-select-sm estado-select {{ $claseEstado }}">
													<option value="0">⏳ PENDIENTE</option>
													<option value="1">🎯 EN JUEGO</option>
													<option value="2">✅ FINALIZADO</option>
												</select>
											</div>
											@else
											<span class="badge bg-secondary">⏳</span>
											@endif
										</td>

										{{-- Jugador 1 --}}
										<td>{{ $clave1 }}</td>
										<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
										<td>
											<input type="checkbox"
												wire:model="subitasSeleccionados1.{{ $jugador1['id_player'] ?? 'x' }}"
												wire:click="seleccionarGanadorSubita1('{{ $jugador1['id_player'] ?? 'x' }}', '{{ $jugador2['id_player'] ?? 'x' }}')"
												class="form-check-input ganador-check"
												aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}"
												{{ $estatus === 2 ? 'disabled' : '' }}
												{{ !$juego ? 'disabled' : '' }}>
										</td>

										<td><span class="fs-5">🤝</span></td>

										<td>
											<input type="checkbox"
												wire:model="subitasSeleccionados1.{{ $jugador2['id_player'] ?? 'x' }}"
												wire:click="seleccionarGanadorSubita1('{{ $jugador2['id_player'] ?? 'x' }}', '{{ $jugador1['id_player'] ?? 'x' }}')"
												class="form-check-input ganador-check"
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
											@endphp

											@if ((int) $estatus === 2)
											<span class="badge bg-dark">🎱 {{ $mesaActual }}</span>
											@else
											<div>
												<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
													class="form-select form-select-sm bg-warning text-dark mesa-select">
													<option value="">Selecciona mesa</option>
													@foreach (range(1, 11) as $mesa)
													<option value="{{ $mesa }}">MESA {{ $mesa }}</option>
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

</div>