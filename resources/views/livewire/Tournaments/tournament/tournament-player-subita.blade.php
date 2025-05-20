<div>
	<div class="text-center">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar Juegos
		</button>
	</div>
	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 14:00 HRS -->
		<div class="col-md-12">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #ec965a ;" class="card-header text-white text-center fw-bold">
					SUBITA HORARIO 14:00 HRS
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Sorteo</th>
									<th>Clave 1</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave 2</th>
									<th>Sorteo</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores1[$clave1] ?? null;
								$jugador2 = $jugadores1[$clave2] ?? null;
								@endphp
								<tr>
									<td>
										<input type="number"
											wire:model="sorteossubita.{{ $jugador1['id'] ?? 'x'}}"
											class="form-control form-control-sm text-center mx-auto"
											style="max-width: 45px; border: none; box-shadow: none;">
									</td>

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
									<td><input type="number"
											wire:model="sorteossubita.{{ $jugador2['id'] ?? 'x' }}"
											class="form-control form-control-sm text-center mx-auto"
											style="max-width: 45px; border: none; box-shadow: none;"></td>

								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center mt-4">
		<button wire:click="guardarAjustes" class="btn btn-success">
			Guardar Juegos
		</button>
	</div>

	<div class="row g-4 mt-1">
		<!-- Tabla SUBITA 17:00 HRS -->
		<div class="col-md-12">
			<div class="card shadow-sm mb-4 h-100">
				<div style="background-color: #5ab0ec;" class="card-header text-white text-center fw-bold">
					SUBITA HORARIO 17:00 HRS
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0 text-center align-middle">
							<thead class="table-dark">
								<tr>
									<th>Sorteo</th>
									<th>Clave 1</th>
									<th>Jugador</th>
									<th>Ganador</th>
									<th>VS</th>
									<th>Ganador</th>
									<th>Jugador</th>
									<th>Clave 2</th>
									<th>Sorteo</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($enfrentamientos1 as $index => [$clave1, $clave2])
								@php
								$jugador1 = $jugadores2[$clave1] ?? null;
								$jugador2 = $jugadores2[$clave2] ?? null;
								@endphp
								<tr>
									<td class="text-center align-middle">
										<input type="number"
											class="form-control form-control-sm text-center mx-auto"
											style="max-width: 45px; border: none; box-shadow: none;">
									</td>
									<td>{{ $clave1 }}</td>
									<td><strong>{{ $jugador1['nombre'] ?? '---' }}</strong></td>
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
									<td><strong>{{ $jugador2['nombre'] ?? '---' }}</strong></td>
									<td>{{ $clave2 }}</td>
									<td class="text-center align-middle">
										<input type="number"
											class="form-control form-control-sm text-center mx-auto"
											style="max-width: 45px; border: none; box-shadow: none;">
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