<?php $this->layout('template', $template); ?>

<?php $this->start('css'); ?>
<style>
	.data-zone {
		width: 100%;
		min-height: 250px;
		position: relative;
	}
	.table-striped tbody tr:nth-child(even) {
		background-color: #fff;
	}
	.table thead th,
	.table tbody td {
		height: 25px;
		white-space: nowrap;
	}
	.label-container {
		max-width: 180px;
		white-space: normal;
	}
	.micro-label {
		margin: 2px;
		display: inline-block;
		background-color: #d3d7f9;
		padding: 3px;
		border-radius: 5px;
	}
	.floating-form {
		position: absolute;
		top: -8px;
		right: 0;
	}
	.all-rows {
		cursor: pointer;
	}
</style>
<?php $this->stop(); ?>

<?php $this->start('js'); ?>
<script src="<?php echo $web['link'] . 'comun/jquery.dataTables.min.js'; ?>"></script>
<script>
	$(function() {
		$('.radar-panel')
		.on('click','[role="refresh"]', function() {
			let $loading = mostrarLoading();
			
			window.location.reload();
		})
		.on('click','[role="submit"]', function() {
			let $form = $('.floating-form');
			let rows = $('.table tr[role="row"] input[type="checkbox"]:checked');
			let values = [];
			
			$(rows).each(function(indx, data) {
				values.push($(data).val());
			});
			
			$form.find('[name="rows"]').val(JSON.stringify(values));
			
			if (values.length == 0) {
				$.alert({
					type: 'orange',
					icon: 'fas fa-exclamation-triangle',
					title: 'SIN REGISTROS SELECCIONADOS',
					content: 'ES NECESARIO SELECCIONAR 1 O M&Aacute;S REGISTROS.'
				});
				
				return false;
			}
			
			$form.submit();
		})
		.on('click','th[role="all"]', function(e) {
			e.stopImmediatePropagation();
			
			inputState = !inputState;
			$('.table').find('input[type="checkbox"]').prop('checked', inputState);
			
			return false;
		});
	});
</script>
<?php $this->stop(); ?>

<div class="container-fluid">
	<?php echo $navbar; ?>
	<div class="radar-panel">
		<h1 class="title title-marginless">REGISTROS - AQUI VA EL TITULO</h1>
		<div class="panel-info">
			<h2>AQUI VA LA INFORMACION</h2>
		</div>
		<div class="panel-content">
			<div class="data-zone">
				<form method="post" class="floating-form">
					<button type="button" class="radar-btn" role="refresh">
						<span class="btn-img-label">REFRESCAR</span>
						<img src="#" class="ml-5">
					</button>
					<button type="button" class="radar-btn" role="submit">
						<span class="btn-img-label">ENVIAR</span>
						<img src="#" class="ml-5">
					</button>
					<textarea hidden name="rows"></textarea>
				</form>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="20">#</th>
							<th width="20" role="all" class="all-rows">-</th>
							<th width="60">NAME</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($registros as $k => $r) : ?>
							<tr>
								<td class="text-center">
									<?php echo $k+1; ?>
								</td>
								<td class="text-center">
									<input type="checkbox" name="exportar[]" value="<?php echo $r->id; ?>">
								</td>
								<td class="text-left">
									<strong>
										<?php echo strtoupper($r->name); ?>
									</strong>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>