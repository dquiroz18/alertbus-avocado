<?php $__env->startSection('name_reporte_breadcrumbs'); ?>
	<span class="active"><a href="<?php echo e(url('reportes/viajes-liquidacion')); ?>">Liquidación</a></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('reporte_title'); ?>
	<h2>Liquidación</h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('masFiltros2'); ?>
	<div class="col-sm-3">
			<label for="placa">Placa</label> 
			<select id="placa" class="form-control">
				<option value="0">Seleccione</option>
			</select>
		</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('beforeTable'); ?>
	<div class="col-sm-3">
		<a href="" id="pdf_" role="button" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-table'); ?>
	<thead>
		<tr>
			<?php $__currentLoopData = $header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $td): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
					switch($td){
						case 'Placa':
							echo"<th width='100'>$td</th>";
							break;
						case 'Cant. Pasajeros':
							echo"<th width='80'>$td</th>";
							break;
						default:
							echo"<th>$td</th>";
							break;
					}
				?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tr>
	</thead>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('#transportista, #ruta, #centrocosto, #placa').select2();
    </script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script>
		var empresas = <?php echo json_encode($empresas); ?>;
		var centrocostos = <?php echo json_encode($centrocostos); ?>;
		var transportistas = <?php echo json_encode($transportistas); ?>;
		var tiposViajes = <?php echo json_encode($tiposViajes); ?>;
		var rutas = <?php echo json_encode($rutas); ?>;
		var placas = <?php echo json_encode($vehiculos); ?>;
		var centerColumns = [7, 8, 9];
		$(document).ready(function () {
			tabla.buttons().container().prependTo( tabla.table().container() );
			
			for (var i = 0; i < rutas.length; i++) {
				$('#ruta').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}
			for (var i = 0; i < empresas.length; i++) {
                ("<?php echo e(Auth::user()->idEmpresa); ?>".split('-')).forEach(function(idEmpresa) {
					if(idEmpresa == empresas[i].idEmpresa)
						$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');								
				});
			}
			$("#empresa option:first").attr('selected','selected');
			$('#empresa').trigger('change');
		});

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			$('#centrocosto').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					$('#centrocosto').append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}

			$('#transportista').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < transportistas.length; i++) {
				if (transportistas[i].idEmpresa.includes(idEmpresa)){
					<?php if(Auth::user()->tipo=='T'): ?>
						var idTransportista = <?php echo e(Auth::user()->idProveedor); ?>;
						if (idTransportista == transportistas[i].idProveedor) {
							$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
						}
					<?php else: ?>
						$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');	
					<?php endif; ?>
				}
			}
			<?php if(Auth::user()->tipo=='T'): ?>
				$("#transportista").val($("#transportista option:eq(1)").val());
				$('#transportista').trigger('change');
			<?php endif; ?>

		});

		$('#transportista').change(function () {
			var idTransportista = $(this).val();

			$('#tipoViaje').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#placa').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					$('#tipoViaje').append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}

			for (var i = 0; i < placas.length; i++) {
				if (idTransportista == placas[i].idProveedor) {
					$('#placa').append('<option value="'+placas[i].idVehiculo+'">'+placas[i].placaVehiculo+'</option>');
				}
			}
		});

		var tabla = $('#tabla').DataTable({
			"paging": true,
			"row": true,
			"order": [],
			createdRow: function( row ) {
				for (var i = 0; i < centerColumns.length; i++) {
					$(row).find('td:eq('+centerColumns[i]+')').css('text-align', 'center');
				}
			}, 
	        buttons: [
	            {
	                extend: 'excelHtml5',
	                title: 'Liquidacion'
	            }
	        ]
		 });
		$('#filtrar').click(function () {
			$('#loading').show();
			$('#tabla').hide();
			var idEmpresa = $('#empresa').val();
			var idCentroCosto = $('#centrocosto').val();
			var idTransportista = $('#transportista').val();
			var idRuta = $('#ruta').val();
			var idTipoTarifa = $('#placa').val();				
			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			if (idEmpresa == '0') {
				alert("Seleccione una Empresa");
				return false;
			}


			<?php if(Auth::user()->tipo == 'T'): ?>
			if (idTransportista == 0) {
				alert("Seleccione el Transportista");
				$('#loading').hide();
				$('#tabla').show();
				return false;
			}
			<?php endif; ?>

			var sp_name = "SP_AlertBus_RPT_Viaje_Liquidacion";

			var buscar_http = "<?php echo e(url('reportes/filtrar/')); ?>" + '/' + idEmpresa
																 + '/' + idCentroCosto
																 + '/' + idTransportista
																 + '/' + idRuta
																 + '/' + idTipoTarifa
																 + '/' + desde
																 + '/' + hasta
																 + '/' + sp_name;

			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: buscar_http,
				method: 'post',
				success: function(response){
					tabla.clear().draw();
					var data = response.dataset;
					for (var i = 0; i < data.length; i++) {
						tabla.row.add([
							data[i].nombreEmpresa,
							data[i].fecha,
							//data[i].nombreArea,
							data[i].nombreCentroCosto,
							data[i].nombreProveedor,
							data[i].nombreRuta,
							data[i].nombreTipoVehiculo,
							data[i].placaVehiculo,
							//data[i].nombreTipoTarifa,
							data[i].tarifa,
							data[i].cantPasajeros,
							data[i].ocupacion
						]).draw()
						
					}
					$('#loading').hide();
					$('#tabla').show();
				}
			});
		});
		$('#pdf_').click(function () {
			var idEmpresa = $('#empresa').val();
			var idCentroCosto = $('#centrocosto').val();
			var idTransportista = $('#transportista').val();
			var idTipoTarifa = $('#tipoViaje').val();
			var idRuta = $('#ruta').val();

			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			var sp_name = "SP_AlertBus_RPT_Viaje_Liquidacion";

			var buscar_http = "<?php echo e(url('reportes/liquidacion/pdf')); ?>" + '/' + idEmpresa
																 + '/' + idCentroCosto
																 + '/' + idTransportista
																 + '/' + idTipoTarifa
																 + '/' + idRuta
																 + '/' + desde
																 + '/' + hasta
																 + '/' + sp_name;

			$(this).attr('href', buscar_http);
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reportes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>