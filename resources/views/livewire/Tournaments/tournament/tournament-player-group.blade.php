<div>
	<div class="text-center mt-3">
		<button wire:click="saveDataGrupos" class="btn btn-success">
			Guardar Grupos
		</button>
	</div>
	@foreach ($grupos as $gIndex => $grupo)
	<div class="card shadow-sm rounded mb-4 mt-3">
		<div class="card-header bg-secondary text-white text-center fs-5 fw-bold">
			GRUPO {{ $gIndex + 1 }}
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
								<td style="background-color: #c4c7cb ;">
								</td>
								<td style="background-color: #c4c7cb ;"></td>
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