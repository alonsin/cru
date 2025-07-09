<div>

	<div wire:ignore.self class="modal fade" id="modalGanadores" tabindex="-1" aria-labelledby="modalGanadoresLabel" aria-hidden="true">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-light text-dark">
					<h5 class="modal-title w-100 text-center m-0">
						<strong>🎲 GANADORES DE RONDA DE SUBITA 🎲</strong>
					</h5>
					<button type="button" class="btn-close" wire:click="cerrarModalGanadores" aria-label="Cerrar"></button>
				</div>

				<div class="modal-body">
					@php
					$chunks = collect($jugadoresganadores)->chunk(11);
					@endphp

					<div class="d-flex overflow-auto gap-3">
						@foreach ($chunks as $grupo)
						<div class="table-responsive" style="min-width: 300px;">
							<table class="table table-hover align-middle text-center">
								<thead class="table-dark text-white">
									<tr>
										<!-- <th style="width: 5%;">#</th> -->
										<th style="width: 65%;">Nombre del Jugador</th>
										<th style="width: 30%;">N° Sorteo</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($grupo as $index => $jugador)
									<tr>
										<!-- <td>{{ $loop->iteration }}</td> -->
										<td class="fw-semibold">{{ $jugador->player->name_player ?? 'Sin nombre' }}</td>
										<td>
											<input type="number"
												class="form-control form-control-sm text-center mx-auto"
												style="max-width: 80px;"
												wire:model.defer="numerosSorteo.{{ $jugador->id }}"
												min="1" />
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						@endforeach
					</div>

				</div>

				<div class="modal-footer justify-content-center">
					<button class="btn btn-success px-4" wire:click="guardarNumerosSorteo">
						<i class="bi bi-check-circle me-1"></i> Guardar
					</button>
					<button type="button" class="btn btn-secondary px-4" wire:click="cerrarModalGanadores">
						<i class="bi bi-x-circle me-1"></i> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>


	@script
	<script>
		Livewire.on('mostrarModalGanadores', e => {
			// Elimina cualquier backdrop anterior antes de abrir
			document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
			document.body.classList.remove('modal-open');
			document.body.style = '';

			// Luego muestra el modal
			const modalElement = document.getElementById('modalGanadores');
			const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
			modal.show();
		});


		Livewire.on('cerrarModalGanadores', () => {
			const modalElement = document.getElementById('modalGanadores');
			const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);

			modalInstance.hide();

			// Limpieza opcional del backdrop si persiste
			setTimeout(() => {
				document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
				document.body.classList.remove('modal-open');
				document.body.style = '';
			}, 400);
		});

		Livewire.on('sorteos-guardados-subita', () => {
			Swal.fire({
				icon: 'success',
				title: '¡Guardado!',
				text: 'Los sorteos se han guardado correctamente.',
				timer: 2000,
				showConfirmButton: false
			});
		});

		Livewire.on('error-numero-duplicado', (data) => {
			Swal.fire({
				icon: 'warning',
				title: 'Número Duplicado!',
				text: data.message,
				timer: 4000,
				showConfirmButton: true
			});
		});

		Livewire.on('sorteos-repetidos-subita', (data) => {
			Swal.fire({
				icon: 'warning',
				title: 'Numeros Duplicados!',
				text: data.message,
				timer: 4000,
				showConfirmButton: true
			});
		});
	</script>
	@endscript


</div>