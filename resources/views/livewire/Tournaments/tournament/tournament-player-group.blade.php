<div>
	<h1>hola aui epsu</h1>
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
							<th rowspan="2">CLUB ENTIDAD</th>
							<th colspan="2">P1</th>
							<th colspan="2">P2</th>
							<th colspan="2">P3</th>
							<th rowspan="2">TCAR</th>
							<th rowspan="2">TENT</th>
							<th rowspan="2">PROMEDIO</th>
							<th rowspan="2">SORTEO</th>
						</tr>
						<tr>
							<th>CAR</th><th>ENT</th>
							<th>CAR</th><th>ENT</th>
							<th>CAR</th><th>ENT</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($grupo as $jIndex => $jugador)
							<tr>
								<td>{{ $jIndex + 1 }}</td>
								<td>{{ $jugador->name_player ?? '' }}</td>
								<td>{{ $jugador->club_entidad ?? '' }}</td>

								{{-- P1 --}}
								<td @if($jIndex == 0 || $jIndex == 3) style="background-color: orange;" disabled @endif></td>
								<td @if($jIndex == 0 || $jIndex == 3) style="background-color: orange;" @endif></td>

								{{-- P2 --}}
								<td @if($jIndex == 1 || $jIndex == 4) style="background-color: orange;" @endif></td>
								<td @if($jIndex == 1 || $jIndex == 4) style="background-color: orange;" @endif></td>

								{{-- P3 --}}
								<td @if($jIndex == 2 || $jIndex == 5) style="background-color: orange;" @endif></td>
								<td @if($jIndex == 2 || $jIndex == 5) style="background-color: orange;" @endif></td>

								<td></td>
								<td></td>
								<td></td>
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