<div>
	<div class="text-center">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar Juegos Finales
		</button>
	</div>
	<div class="row mt-3">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-12">
			<div class="card shadow-sm h-100">
				<div style="background-color: #5f8d77;" class="card-header text-white text-center fw-bold">
					RONDA DE CUARTOS DE FINAL
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
								@foreach ($enfrentamientos8 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores8[$clave1] ?? null;
								$jugador2 = $jugadores8[$clave2] ?? null;

								$claveJuego = $clave1 . '-' . $clave2;
								$juego = $juegosGuardados8[$claveJuego] ?? null;

								$esGanador1 = $juego && $juego['wp1'] == 1;
								$esGanador2 = $juego && $juego['wp2'] == 1;
								@endphp

								<tr
									@php
									if ($juego) {
									if ($juego['estatus']==1) {
									echo 'class="table-warning"' ;
									} elseif ($juego['estatus']==2) {
									echo 'class="table-success"' ;
									}
									}
									@endphp>

									{{-- Estado --}}
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados8[$juego['id']] ?? $juego['estatus'];
										$claseColor = match((int) $estatus) {
										1 => 'bg-success text-white',
										2 => 'bg-danger text-white',
										3 => 'bg-secondary text-white',
										default => 'bg-secondary text-white',
										};
										@endphp

										<div class="d-flex justify-content-center">
											<select wire:model="estatusSeleccionados8.{{ $juego['id'] }}"
												class="form-select form-select-sm {{ $claseColor }}"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
												<option value="0">PENDIENTE</option>
												<option value="1">EN JUEGO</option>
												<option value="2">FINALIZADO</option>
											</select>
										</div>
										@else
										<span class="badge bg-secondary">Pendiente</span>
										@endif
									</td>


									{{-- Clave jugador 1 --}}
									<td><strong>{{ $clave1 }}</strong></td>
									<td>{{ $jugador1['nombre'] ?? '---' }}</td>
									{{-- Checkbox jugador 1 --}}
									{{-- Checkbox jugador 1 o -- --}}
									@if ($jugador1 && $jugador2)
									{{-- Checkbox jugador 1 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados8.{{ $jugador1['id_player'] }}"
											wire:click="seleccionarGanador8('{{ $jugador1['id_player'] }}', '{{ $jugador2['id_player'] }}')"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>

									</td>

									{{-- VS --}}
									<td>VS</td>

									{{-- Checkbox jugador 2 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados8.{{ $jugador2['id_player'] }}"
											wire:click="seleccionarGanador8('{{ $jugador2['id_player'] }}', '{{ $jugador1['id_player'] }}')"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>

									</td>
									@else

									{{-- Si falta alguno de los dos jugadores, mostrar "--" en cada td --}}
									<td>--</td>
									<td>VS</td>
									<td>--</td>
									@endif

									<td>{{ $jugador2['nombre'] ?? '---' }}</td>
									<td><strong>{{ $clave2 }}</strong></td>


									{{-- Mesa --}}
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados8[$juego['id']] ?? $juego['estatus'];
										$mesaActual = $mesaSeleccionada[$juego['id']] ?? $juego['mesa'];
										@endphp

										@if ((int) $estatus === 2)
										<strong>{{ $mesaActual }}</strong>
										@else
										<div class="d-flex justify-content-center">
											@php
											$opcionesMesa = $mesasDisponibles;

											// Si la mesa actual está ocupada pero es la de este juego, permitir mostrarla
											if ($mesaActual && !in_array($mesaActual, $opcionesMesa)) {
											$opcionesMesa[] = $mesaActual;
											}

											sort($opcionesMesa);
											@endphp

											<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
												class="form-select form-select-sm bg-warning text-dark"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
												<option value="">Selecciona mesa</option>
												@foreach ($opcionesMesa as $mesa)
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
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="row mt-4">
		<div class="col-md-12">
			<div class="card shadow-sm h-100">
				<div style="background-color: #b38c78;" class="card-header text-white text-center fw-bold">
					RONDA DE SEMIFINAL
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
								@foreach ($enfrentamientos4 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores4[$clave1] ?? null;
								$jugador2 = $jugadores4[$clave2] ?? null;

								$claveJuego = $clave1 . '-' . $clave2;
								$juego = $juegosGuardados4[$claveJuego] ?? null;

								$esGanador1 = $juego && $juego['wp1'] == 1;
								$esGanador2 = $juego && $juego['wp2'] == 1;
								@endphp

								<tr
									@php
									if ($juego) {
									if ($juego['estatus']==1) {
									echo 'class="table-warning"' ;
									} elseif ($juego['estatus']==2) {
									echo 'class="table-success"' ;
									}
									}
									@endphp>

									{{-- Estado --}}
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados4[$juego['id']] ?? $juego['estatus'];
										$claseColor = match((int) $estatus) {
										1 => 'bg-success text-white',
										2 => 'bg-danger text-white',
										3 => 'bg-secondary text-white',
										default => 'bg-secondary text-white',
										};
										@endphp

										<div class="d-flex justify-content-center">
											<select wire:model="estatusSeleccionados4.{{ $juego['id'] }}"
												class="form-select form-select-sm {{ $claseColor }}"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
												<option value="0">PENDIENTE</option>
												<option value="1">EN JUEGO</option>
												<option value="2">FINALIZADO</option>
											</select>
										</div>
										@else
										<span class="badge bg-secondary">Pendiente</span>
										@endif
									</td>


									{{-- Clave jugador 1 --}}
									<td><strong>{{ $clave1 }}</strong></td>
									<td>{{ $jugador1['nombre'] ?? '---' }}</td>
									{{-- Checkbox jugador 1 --}}
									{{-- Checkbox jugador 1 o -- --}}
									@if ($jugador1 && $jugador2)
									{{-- Checkbox jugador 1 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados4.{{ $jugador1['id_player'] }}"
											wire:click="seleccionarGanador4('{{ $jugador1['id_player'] }}', '{{ $jugador2['id_player'] }}')"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>

									</td>

									{{-- VS --}}
									<td>VS</td>

									{{-- Checkbox jugador 2 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados4.{{ $jugador2['id_player'] }}"
											wire:click="seleccionarGanador4('{{ $jugador2['id_player'] }}', '{{ $jugador1['id_player'] }}')"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>

									</td>
									@else

									{{-- Si falta alguno de los dos jugadores, mostrar "--" en cada td --}}
									<td>--</td>
									<td>VS</td>
									<td>--</td>
									@endif

									<td>{{ $jugador2['nombre'] ?? '---' }}</td>
									<td><strong>{{ $clave2 }}</strong></td>


									{{-- Mesa --}}
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados4[$juego['id']] ?? $juego['estatus'];
										$mesaActual = $mesaSeleccionada[$juego['id']] ?? $juego['mesa'];
										@endphp

										@if ((int) $estatus === 2)
										<strong>{{ $mesaActual }}</strong>
										@else
										<div class="d-flex justify-content-center">
											@php
											$opcionesMesa = $mesasDisponibles;

											// Si la mesa actual está ocupada pero es la de este juego, permitir mostrarla
											if ($mesaActual && !in_array($mesaActual, $opcionesMesa)) {
											$opcionesMesa[] = $mesaActual;
											}

											sort($opcionesMesa);
											@endphp

											<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
												class="form-select form-select-sm bg-warning text-dark"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
												<option value="">Selecciona mesa</option>
												@foreach ($opcionesMesa as $mesa)
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

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-12">
			<div class="card shadow-sm h-100">
				<div style="background-color: #4b6584;" class="card-header text-white text-center fw-bold">
					FINAL
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
								@foreach ($enfrentamientos2 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores2[$clave1] ?? null;
								$jugador2 = $jugadores2[$clave2] ?? null;

								$claveJuego = $clave1 . '-' . $clave2;
								$juego = $juegosGuardados2[$claveJuego] ?? null;

								$esGanador1 = $juego && $juego['wp1'] == 1;
								$esGanador2 = $juego && $juego['wp2'] == 1;
								@endphp

								<tr
									@php
									if ($juego) {
									if ($juego['estatus']==1) {
									echo 'class="table-warning"' ;
									} elseif ($juego['estatus']==2) {
									echo 'class="table-success"' ;
									}
									}
									@endphp>

									{{-- Estado --}}
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados2[$juego['id']] ?? $juego['estatus'];
										$claseColor = match((int) $estatus) {
										1 => 'bg-success text-white',
										2 => 'bg-danger text-white',
										3 => 'bg-secondary text-white',
										default => 'bg-secondary text-white',
										};
										@endphp

										<div class="d-flex justify-content-center">
											<select wire:model="estatusSeleccionados2.{{ $juego['id'] }}"
												class="form-select form-select-sm {{ $claseColor }}"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
												<option value="0">PENDIENTE</option>
												<option value="1">EN JUEGO</option>
												<option value="2">FINALIZADO</option>
											</select>
										</div>
										@else
										<span class="badge bg-secondary">Pendiente</span>
										@endif
									</td>


									{{-- Clave jugador 1 --}}
									<td><strong>{{ $clave1 }}</strong></td>
									<td>{{ $jugador1['nombre'] ?? '---' }}</td>
									{{-- Checkbox jugador 1 --}}
									{{-- Checkbox jugador 1 o -- --}}
									@if ($jugador1 && $jugador2)
									{{-- Checkbox jugador 1 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados2.{{ $jugador1['id_player'] }}"
											wire:click="seleccionarGanador2('{{ $jugador1['id_player'] }}', '{{ $jugador2['id_player'] }}')"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>

									</td>

									{{-- VS --}}
									<td>VS</td>

									{{-- Checkbox jugador 2 --}}
									<td>
										<input type="checkbox"
											class="form-check-input"
											wire:model="ajustesSeleccionados2.{{ $jugador2['id_player'] }}"
											wire:click="seleccionarGanador2('{{ $jugador2['id_player'] }}', '{{ $jugador1['id_player'] }}')"
											{{ $estatus === 2 ? 'disabled' : '' }}
											{{ !$juego ? 'disabled' : '' }}>

									</td>
									@else

									{{-- Si falta alguno de los dos jugadores, mostrar "--" en cada td --}}
									<td>--</td>
									<td>VS</td>
									<td>--</td>
									@endif

									<td>{{ $jugador2['nombre'] ?? '---' }}</td>
									<td><strong>{{ $clave2 }}</strong></td>


									{{-- Mesa --}}
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados2[$juego['id']] ?? $juego['estatus'];
										$mesaActual = $mesaSeleccionada[$juego['id']] ?? $juego['mesa'];
										@endphp

										@if ((int) $estatus === 2)
										<strong>{{ $mesaActual }}</strong>
										@else
										<div class="d-flex justify-content-center">
											@php
											$opcionesMesa = $mesasDisponibles;

											// Si la mesa actual está ocupada pero es la de este juego, permitir mostrarla
											if ($mesaActual && !in_array($mesaActual, $opcionesMesa)) {
											$opcionesMesa[] = $mesaActual;
											}

											sort($opcionesMesa);
											@endphp

											<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
												class="form-select form-select-sm bg-warning text-dark"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
												<option value="">Selecciona mesa</option>
												@foreach ($opcionesMesa as $mesa)
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
					</div>
				</div>
			</div>
		</div>
	</div>

</div>