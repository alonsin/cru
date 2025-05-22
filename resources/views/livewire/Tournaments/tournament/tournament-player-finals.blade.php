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
								@foreach ($enfrentamientosajustes as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores[$clave1] ?? null;
								$jugador2 = $jugadores[$clave2] ?? null;
								@endphp
								<tr>
									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
									<td>
										<input type="checkbox"
											wire:model="ajustesSeleccionados.{{ $jugador1['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}">
									</td>
									<td>VS</td>
									<td>
										<input type="checkbox"
											wire:model="ajustesSeleccionados.{{ $jugador2['id'] ?? 'x' }}"
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
								@foreach ($enfrentamientofinal as $index => [$clave1, $clave2])
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