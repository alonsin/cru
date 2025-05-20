<div>
	<div class="text-center">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar ajustes
		</button>
	</div>
	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-6">
			<div class="card shadow-sm mb-4 h-100">
				<div class="card-header bg-primary text-white text-center fw-bold">
					SUBITA HORARIO 14:00 HRS
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Clave 1</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave 2</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores1[$clave1] ?? null;
								$jugador2 = $jugadores1[$clave2] ?? null;
								@endphp
								<tr>
									<td>{{ $clave1 }}</td>
									<td>{{ $jugador1['nombre'] ?? '---' }}</td>
									<td>
										<input type="checkbox"
											wire:model.defer="ajustesSeleccionados.{{ $jugador1['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador1['nombre'] ?? $clave1 }}">
									</td>
									<td>VS</td>
									<td>
										<input type="checkbox"
											wire:model.defer="ajustesSeleccionados.{{ $jugador2['id'] ?? 'x' }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugador2['nombre'] ?? $clave2 }}">
									</td>
									<td>{{ $jugador2['nombre'] ?? '---' }}</td>
									<td>{{ $clave2 }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Tabla SUBITA 17:00 HRS -->
		<div class="col-md-6">
			<div class="card shadow-sm mb-4 h-100">
				<div class="card-header bg-success text-white text-center fw-bold">
					SUBITA HORARIO 17:00 HRS
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Clave 1</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave 2</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos as $index => [$clave1, $clave2])
								<tr>
									<td>{{ $clave1 }}</td>
									<td>{{ $jugadores2[$clave1] ?? '---' }}</td>
									<td>
										<input type="checkbox"
											wire:model.defer="ajustesSeleccionados.{{ $clave1 }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugadores2[$clave1] ?? $clave1 }}">
									</td>
									<td>VS</td>
									<td>
										<input type="checkbox"
											wire:model.defer="ajustesSeleccionados.{{ $clave2 }}"
											class="form-check-input"
											aria-label="Ganador {{ $jugadores2[$clave2] ?? $clave2 }}">
									</td>
									<td>{{ $jugadores2[$clave2] ?? '---' }}</td>
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