<div>
	<div class="text-center">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar Juegos Ronda 16
		</button>
	</div>
	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-6">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #4b6584 ;" class="card-header text-white text-center fw-bold">
					RONDA DE AJUSTE A 16
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Estado</th>
									<th>Clave</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave</th>
									<th>Mesa</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientosajustes as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores[$clave1] ?? null;
								$jugador2 = $jugadores[$clave2] ?? null;

								$claveJuego = $clave1 . '-' . $clave2;
								$juego = $juegosGuardadosAjuste16[$claveJuego] ?? null;

								$esGanador1 = $juego && $juego['wp1'] == 1;
								$esGanador2 = $juego && $juego['wp2'] == 1;
								@endphp

								<tr @php echo ($juego && $juego['estatus']==1) ? 'class="table-warning"' : '' ; @endphp>
									{{-- Estado --}}
									<td>
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados[$juego['id']] ?? $juego['estatus'];
										$claseColor = match((int) $estatus) {
										1 => 'bg-success text-white', // En Juego
										2 => 'bg-danger text-white', // Finalizado
										3 => 'bg-secondary text-white', // Pendiente
										default => 'bg-secondary text-white', // Por si acaso
										};
										@endphp

										<select wire:model="estatusSeleccionados.{{ $juego['id'] }}"
											class="form-select form-select-sm {{ $claseColor }}"
											style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
											<option value="0">PENDIENTE</option>
											<option value="1">EN JUEGO</option>
											<option value="2">FINALIZADO</option>
										</select>
										@else
										<span class="badge bg-secondary">Pendiente</span>
										@endif
									</td>


									{{-- Clave jugador 1 --}}
									<td>{{ $clave1 }}</td>
									<td>{{ $jugador1['nombre'] ?? '---' }}</td>
									{{-- Checkbox jugador 1 --}}
									{{-- Checkbox jugador 1 o -- --}}
									@if ($jugador1 && $jugador2)
									{{-- Checkbox jugador 1 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados.{{ $jugador1['id_player'] }}"
											wire:click="seleccionarGanador('{{ $jugador1['id_player'] }}', '{{ $jugador2['id_player'] }}')">

									</td>

									{{-- VS --}}
									<td>VS</td>

									{{-- Checkbox jugador 2 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados.{{ $jugador2['id_player'] }}"
											wire:click="seleccionarGanador('{{ $jugador2['id_player'] }}', '{{ $jugador1['id_player'] }}')">

									</td>
									@else
									{{-- Si falta alguno de los dos jugadores, mostrar "--" en cada td --}}
									<td>--</td>
									<td>VS</td>
									<td>--</td>
									@endif

									<td>{{ $jugador2['nombre'] ?? '---' }}</td>
									<td>{{ $clave2 }}</td>

									{{-- Mesa --}}
									<td>
										@if ($juego)
										<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
											class="form-select form-select-sm bg-primary text-white"
											style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
											<option value="">Selecciona mesa</option>
											@for ($i = 1; $i <= 11; $i++)
												<option value="{{ $i }}">MESA {{ $i }}</option>
												@endfor
										</select>
										@else
										<span class="text-muted">---</span>
										@endif
									</td>
								</tr>
								@endforeach


							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #89a0bc ;" class="card-header text-white text-center fw-bold">
					RONDA DE 16
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Clave</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos16 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores16[$clave1] ?? null;
								$jugador2 = $jugadores16[$clave2] ?? null;
								@endphp
								<tr>
									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
									<td>
										<input type="checkbox"
											wire:model="ajustesSeleccionados16.{{ $jugador1['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}">
									</td>
									<td>VS</td>
									<td>
										<input type="checkbox"
											wire:model="ajustesSeleccionados16.{{ $jugador2['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador2['nombre'] ?? $clave2 }}">
									</td>
									<td><strong>{{ $jugador2['nombre'] ?? '---' }}</strong></td>
									<td>{{ $clave2 }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>