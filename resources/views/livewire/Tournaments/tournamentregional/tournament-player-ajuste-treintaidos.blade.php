<div>
	<div class="text-center mt-0">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar Juegos
		</button>
	</div>
	<div class="row g-4 mt-0">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-12">
			<div class="card shadow-sm mb-4 h-100">
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Estado</th>
									<th>Clave 1</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave 2</th>
									<th>Mesa</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos1 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores1[$clave1] ?? null;
								$jugador2 = $jugadores1[$clave2] ?? null;

								$claveJuego = $clave1 . '-' . $clave2;
								$juego = $juegosGuardadosSubita1[$claveJuego] ?? null;


								$esGanador1 = $juego && $juego['wp1'] == 1;
								$esGanador2 = $juego && $juego['wp2'] == 1;
								$estatus = null;

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
									<td class="text-center align-middle">

										@if ($juego)
										@php
										$estatus = $estatusSeleccionados1[$juego['id']] ?? $juego['estatus'];
										$claseColor = match((int) $estatus) {
										1 => 'bg-success text-white',
										2 => 'bg-danger text-white',
										3 => 'bg-secondary text-white',
										default => 'bg-secondary text-white',
										};
										@endphp
										<div class="d-flex justify-content-center">
											<select wire:model="estatusSeleccionados1.{{ $juego['id'] }}"
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
									<td>VS</td>
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
									<td class="text-center align-middle">
										@if ($juego)
										@php
										$estatus = $estatusSeleccionados1[$juego['id']] ?? $juego['estatus'];
										$mesaActual = $mesaSeleccionada[$juego['id']] ?? $juego['mesa'];
										@endphp

										@if ((int) $estatus === 2)
										<strong>{{ $mesaActual }}</strong>
										@else
										<div class="d-flex justify-content-center">
											<select wire:model="mesaSeleccionada.{{ $juego['id'] }}"
												class="form-select form-select-sm bg-warning text-dark"
												style="padding: 0.2rem 0.4rem; font-size: 0.7rem; height: auto; line-height: 1; border-radius: 0.375rem; width: fit-content; min-width: 100px;">
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>