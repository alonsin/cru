<div>
	<div class="d-flex justify-content-end mb-3">
		<button type="button" wire:click="saveDataGrupos" class="btn btn-success px-4 py-2 fw-bold">
			GUARDAR GRUPOS
		</button>
	</div>
	@foreach ($grupos as $gIndex => $grupo)
	<div class="card shadow-sm rounded mb-4">
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
						@foreach ($grupo as $jugadorId  => $jugador)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td style="white-space: nowrap;"><small>{{ $jugador['player_name'] }}</small></td>
							<td style="white-space: nowrap;"><small>{{ $jugador['club'] }}</small></td>

							@for ($i = 0; $i < 3; $i++) {{-- P1, P2, P3 (dos columnas por cada uno) --}}
								@for ($k=0; $k < 2; $k++)
								@php
								$isHighlighted=$jugadorId % 3==$i;
								@endphp
								<td @if($isHighlighted) style="background-color: #FCBF66;" @endif>
								@unless($isHighlighted)
								<input
									type="number"
									wire:model.defer="grupo.{{ $jugador['id'] }}.p{{ $i + 1 }}.{{ $k }}"
									class="form-control form-control-sm text-center"
									style="padding: 0px 2px; font-size: 1rem; line-height: 1; height: 0.5em; font-weight: bold; border: none !important; box-shadow: none !important; outline: none;" />


								@endunless
								</td>
								@endfor
								@endfor

								<td>10</td>
								<td>11</td>
								<td>12</td>
								<td>{{ $jugador->sorteo ?? '' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endforeach


</div>