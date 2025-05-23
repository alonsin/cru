<div>
	<div class="text-center">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar Juegos Finales
		</button>
	</div>
	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-6">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #5f8d77;" class="card-header text-white text-center fw-bold">
					RONDA DE CUARTOS DE FINAL
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
								@foreach ($enfrentamientos8 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores8[$clave1] ?? null;
								$jugador2 = $jugadores8[$clave2] ?? null;
								$ambosPresentes = $jugador1 && $jugador2;
								@endphp
								<tr>
									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
									<td>
										<input type="radio"
											name="ganador_{{ $index }}"
											value="{{ $jugador1['id'] ?? '' }}"
											wire:model="ganadores8.{{ $index }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}"
											{{ !$ambosPresentes ? 'disabled' : '' }}>
									</td>
									<td>VS</td>
									<td>
										<input type="radio"
											name="ganador_{{ $index }}"
											value="{{ $jugador2['id'] ?? '' }}"
											wire:model="ganadores8.{{ $index }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador2['nombre'] ?? $clave2 }}"
											{{ !$ambosPresentes ? 'disabled' : '' }}>
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
		<div class="col-md-6">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #b38c78;" class="card-header text-white text-center fw-bold">
					RONDA DE SEMIFINAL
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
								@foreach ($enfrentamientos4 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores4[$clave1] ?? null;
								$jugador2 = $jugadores4[$clave2] ?? null;
								$ambosPresentes = $jugador1 && $jugador2;
								@endphp
								<tr>
									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
									<td>
										<input type="radio"
											name="ganador_{{ $index }}"
											value="{{ $jugador1['id'] ?? '' }}"
											wire:model="ganadores4.{{ $index }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}"
											{{ !$ambosPresentes ? 'disabled' : '' }}>
									</td>
									<td>VS</td>
									<td>
										<input type="radio"
											name="ganador_{{ $index }}"
											value="{{ $jugador2['id'] ?? '' }}"
											wire:model="ganadores8.{{ $index }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador2['nombre'] ?? $clave2 }}"
											{{ !$ambosPresentes ? 'disabled' : '' }}>
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

	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-12">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #4b6584;" class="card-header text-white text-center fw-bold">
					FINAL
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
								@foreach ($enfrentamientos2 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores2[$clave1] ?? null;
								$jugador2 = $jugadores2[$clave2] ?? null;
								@endphp
								<tr>
									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
									<td>
										<input type="checkbox"
											wire:model="ajustesSeleccionados2.{{ $jugador1['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}"
											@if(is_null($jugador1)) disabled @endif>
									</td>
									<td>VS</td>
									<td>
										<input type="checkbox"
											wire:model="ajustesSeleccionados2.{{ $jugador2['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador2['nombre'] ?? $clave2 }}"
											@if(is_null($jugador2)) disabled @endif>
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