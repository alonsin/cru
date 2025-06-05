<div>

	<style>
		#grupoTabs .nav-link.active {
			background-color: #d1d4d7 !important;
			/* gris claro */
			color: #000 !important;
			/* texto negro para contraste */
			border-color: #dee2e6 #dee2e6 #fff;
			/* bordes armonizados */
		}
	</style>

	<div class="text-center mt-3">
		<button wire:click="saveDataGrupos" class="btn btn-success">
			Guardar Grupos
		</button>
	</div>


	<div class="nav nav-tabs d-flex mt-4" id="grupoTabs" role="tablist">
		<button class="nav-link flex-fill text-center active text-dark" id="grupo100-tab"
			data-bs-toggle="tab" data-bs-target="#grupo100" type="button" role="tab"
			aria-controls="grupo100" aria-selected="true">
			GRUPOS 14:00 Hrs
		</button>
		<button class="nav-link flex-fill text-center text-dark" id="grupo170-tab"
			data-bs-toggle="tab" data-bs-target="#grupo170" type="button" role="tab"
			aria-controls="grupo170" aria-selected="false">
			GRUPOS 17:00 Hrs
		</button>
	</div>


	<div class="tab-content mt-4" id="grupoTabsContent">
		<!-- Jugadores 14:00 -->
		<div class="tab-pane fade show active" id="grupo100" role="tabpanel" aria-labelledby="grupo100-tab">
			@foreach ($grupos as $gIndex => $grupo)
			<div class="card shadow-sm rounded mb-4 mt-3">
				<div style="background-color: #4b6584 ;" class="card-header text-white text-center fs-5 fw-bold">
					GRUPO {{ $gIndex + 1 }} ( 14:00 HRS )
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-bordered table-hover mb-0 text-center align-middle">
							<thead class="table-light">
								<tr>
									<th rowspan="2">No</th>
									<th rowspan="2">NOMBRE</th>
									<th rowspan="2">CLUB</th>
									<th colspan="2">P1</th>
									<th colspan="2">P2</th>
									<th colspan="2">P3</th>
									<th rowspan="2">TCAR</th>
									<th rowspan="2">TENT</th>
									<th rowspan="2">PROMEDIO</th>
									<th rowspan="2">SORTEO</th>
								</tr>
								<tr>
									<th>CAR</th>
									<th>ENT</th>
									<th>CAR</th>
									<th>ENT</th>
									<th>CAR</th>
									<th>ENT</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($grupo as $jugadorId => $jugador)
								@php
								// contador de partidos jugados (0→p1, 1→p2)
								$matchCounter = 0;
								@endphp
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td style="white-space: nowrap;"><small>{{ $jugador['player_name'] }}</small></td>
									<td style="white-space: nowrap;"><small>{{ $jugador['club'] }}</small></td>

									{{-- Recorremos rondas 0,1,2 (P1,P2,P3) --}}
									@for ($i = 0; $i < 3; $i++)
										@php
										$isHighlighted=($jugadorId % 3)===$i;
										@endphp

										@if($isHighlighted)
										{{-- Descansa en esta ronda: dos celdas naranjas sin input --}}
										<td style="background-color: #F4C29F ;">
										</td>
										<td style="background-color: #F4C29F ;"></td>
										@else
										{{-- Juega: asignamos este bloque al siguiente partido en BD --}}
										@php
										$currentMatch = $matchCounter++; // 0 o 1
										@endphp
										@for($k = 0; $k < 2; $k++)
											<td>
											<input
												type="number"
												wire:model.defer="grupos.{{ $gIndex }}.{{ $jugadorId }}.p{{ $currentMatch + 1 }}.{{ $k }}"
												class="form-control form-control-sm text-center"
												style="padding:0 .25rem; font-size:1rem; line-height:1; height:1.5em; border:none; box-shadow:none; outline:none;" />
											</td>
											@endfor
											@endif

											@endfor

											{{-- Totales y promedio --}}
											<td>{{ $jugador['T_CAR'] }}</td>
											<td>{{ $jugador['T_ENT'] }}</td>
											<td><strong>{{ $jugador['PROM'] }}</strong></td>
											<td>
												<input
													type="text"
													wire:model.defer="grupos.{{ $gIndex }}.{{ $jugadorId }}.S_PASE_GRUPOS"
													class="form-control form-control-sm text-center"
													style="padding:0 .25rem; font-size:1rem; line-height:1; height:1.5em; border:none; box-shadow:none; outline:none;" />
											</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<!-- Jugadores 17:00 -->
		<div class="tab-pane fade" id="grupo170" role="tabpanel" aria-labelledby="grupo170-tab">
			@foreach ($grupos2 as $gIndex => $grupo)
			<div class="card shadow-sm rounded mb-4 mt-3">
				<div style="background-color: #4b6584 ;" class="card-header text-white text-center fs-5 fw-bold">
					GRUPO {{ $gIndex + 1 }} ( 14:00 HRS )
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-bordered table-hover mb-0 text-center align-middle">
							<thead class="table-light">
								<tr>
									<th rowspan="2">No</th>
									<th rowspan="2">NOMBRE</th>
									<th rowspan="2">CLUB</th>
									<th colspan="2">P1</th>
									<th colspan="2">P2</th>
									<th colspan="2">P3</th>
									<th rowspan="2">TCAR</th>
									<th rowspan="2">TENT</th>
									<th rowspan="2">PROMEDIO</th>
									<th rowspan="2">SORTEO</th>
								</tr>
								<tr>
									<th>CAR</th>
									<th>ENT</th>
									<th>CAR</th>
									<th>ENT</th>
									<th>CAR</th>
									<th>ENT</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($grupo as $jugadorId => $jugador)
								@php
								// contador de partidos jugados (0→p1, 1→p2)
								$matchCounter = 0;
								@endphp
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td style="white-space: nowrap;"><small>{{ $jugador['player_name'] }}</small></td>
									<td style="white-space: nowrap;"><small>{{ $jugador['club'] }}</small></td>

									{{-- Recorremos rondas 0,1,2 (P1,P2,P3) --}}
									@for ($i = 0; $i < 3; $i++)
										@php
										$isHighlighted=($jugadorId % 3)===$i;
										@endphp

										@if($isHighlighted)
										{{-- Descansa en esta ronda: dos celdas naranjas sin input --}}
										<td style="background-color: #F4C29F ;">
										</td>
										<td style="background-color: #F4C29F ;"></td>
										@else
										{{-- Juega: asignamos este bloque al siguiente partido en BD --}}
										@php
										$currentMatch = $matchCounter++; // 0 o 1
										@endphp
										@for($k = 0; $k < 2; $k++)
											<td>
											<input
												type="number"
												wire:model.defer="grupos.{{ $gIndex }}.{{ $jugadorId }}.p{{ $currentMatch + 1 }}.{{ $k }}"
												class="form-control form-control-sm text-center"
												style="padding:0 .25rem; font-size:1rem; line-height:1; height:1.5em; border:none; box-shadow:none; outline:none;" />
											</td>
											@endfor
											@endif

											@endfor

											{{-- Totales y promedio --}}
											<td>{{ $jugador['T_CAR'] }}</td>
											<td>{{ $jugador['T_ENT'] }}</td>
											<td><strong>{{ $jugador['PROM'] }}</strong></td>
											<td>
												<input
													type="text"
													wire:model.defer="grupos.{{ $gIndex }}.{{ $jugadorId }}.S_PASE_GRUPOS"
													class="form-control form-control-sm text-center"
													style="padding:0 .25rem; font-size:1rem; line-height:1; height:1.5em; border:none; box-shadow:none; outline:none;" />
											</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@endforeach
		</div>

	</div>

</div>