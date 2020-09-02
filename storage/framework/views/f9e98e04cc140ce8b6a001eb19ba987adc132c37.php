<?php $__env->startSection('name_reporte_breadcrumbs'); ?>
	<span class="active"><a href="<?php echo e(url('reportes/viajes')); ?>">Viajes Realizados</a></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('reporte_title'); ?>
	<h2>Viajes Realizados</h2>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('masFiltros2'); ?>
	<div class="col-sm-3">
			<label for="placa">Placa</label> 
			<select id="placa" class="form-control">
				<option value="0">Seleccione</option>
			</select>
		</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-table'); ?>
	<thead>
		<tr>
			<?php $__currentLoopData = $header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $td): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<th><?php echo e($td); ?></th>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tr>
	</thead>	
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<?php echo $__env->make('helpers.dataManagment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('#transportista, #ruta, #centrocosto').select2();
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
		var centerColumns = [12, 13, 14, 15, 16];
		$(document).ready(function () {
			for (var i = 0; i < empresas.length; i++) {
                ("<?php echo e(Auth::user()->idEmpresa); ?>".split('-')).forEach(function(idEmpresa) {
					if(idEmpresa == empresas[i].idEmpresa)
						$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');								
				});
			}
			for (var i = 0; i < transportistas.length; i++) {
				<?php if(Auth::user()->tipo=='T'): ?>
					var idTransportista = <?php echo e(Auth::user()->idProveedor); ?>;
					if (idTransportista == transportistas[i].idProveedor) {
						$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
					}
				<?php else: ?>
					$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');	
				<?php endif; ?>
			}
			<?php if(Auth::user()->tipo=='T'): ?>
				$("#transportista").val($("#transportista option:eq(1)").val());
				$("#transportistaE").val($("#transportistaE option:eq(1)").val());
				$('#transportista').trigger('change');
				$('#transportistaE').trigger('change');
			<?php endif; ?>
			$("#empresa option:first").attr('selected','selected');
			$('#empresa').trigger('change');
		});

		$('#empresa').change(function () {
			$('#centrocosto').html('<option value="0">Seleccione</option>');
			var idEmpresa = $(this).val();
			data = getModelByParams({idEmpresa: idEmpresa}, "<?php echo e(url('mantenimiento/centro-costos/listar')); ?>", 'GET');
			var select = $('#centrocosto');
	  		listarOnSelect(2, 4, data, select);
		});

		$('#transportista').change(function () {
			var idTransportista = $(this).val();

			$('#ruta').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#tipoViaje').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#placa').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < rutas.length; i++) {
				$('#ruta').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}

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
			"order": [],
			createdRow: function( row ) {
				for (var i = 0; i < centerColumns.length; i++) {
					$(row).find('td:eq('+centerColumns[i]+')').css('text-align', 'center');
				}
			},
			dom: 'Bfrtip',
	        buttons: [
	            {
	                extend: 'excelHtml5',
	                title: 'Viajes'
	            }
	        ]
		 });
		$('#filtrar').click(function () {
			$('#loading').show();
			$('#tabla').hide();
			var idEmpresa = $('#empresa').val();
			var idCentroCosto = $('#centrocosto').val();
			var idTransportista = $('#transportista').val();
			var idVehiculo = $('#placa').val();
			var idRuta = $('#ruta').val();
			var realizados = $('#realizados').val();
			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			<?php if(Auth::user()->tipo == 'T'): ?>
			if (idTransportista == 0) {
				alert("Seleccione el Transportista");
				$('#loading').hide();
				$('#tabla').show();
				return false;
			}
			<?php endif; ?>

			localStorage.setItem('desde', desde);
			localStorage.setItem('hasta', hasta);
			localStorage.setItem('idEmpresa', idEmpresa);
			localStorage.setItem('idTransportista', idTransportista);
			localStorage.setItem('realizados', realizados);

			var sp_name = "SP_AlertBus_RPT_Viaje ";

			var buscar_http = "<?php echo e(url('reportes/filtrar/')); ?>" + '/' + idEmpresa
																 + '/' + idCentroCosto
																 + '/' + idTransportista
																 + '/' + idRuta
																 + '/' + idVehiculo
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
					var data = response.dataset;
					localStorage.setItem('data', JSON.stringify(data));
					fillTable(data);
					$('#loading').hide();
					$('#tabla').show();

				}
			});
		});

		function fillTable(data) {
			tabla.clear().draw();
			for (var i = 0; i < data.length; i++) {
				tabla.row.add([
					'<a href="'+"<?php echo e(url('reportes/viajes/detalle/')); ?>"+"/"+data[i].idViaje+'" title="Ver Detalle" class="btn btn-info"><i class="fa fa-eye"></i></a>',
					'<a target="_blank" href="'+"<?php echo e(url('reportes/viajes/tracking/')); ?>"+"/"+data[i].idViaje+'" title="Ver Tracking" class="btn btn-success"><i class="fa fa-globe"></i></a>',
					'<a target="_blank" href="'+"<?php echo e(url('reportes/viajes/manifiesto/')); ?>"+"/"+data[i].idViaje+'" title="Descargar Manifiesto" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>',
					data[i].nombreEmpresa,
					data[i].fecha,
					//data[i].nombreArea,
					data[i].nombreCentroCosto,
					data[i].nombreProveedor,
					data[i].nombreRuta,
					data[i].nombreTipoVehiculo,
					//data[i].nombreTipoTarifa,
					data[i].tarifa,
					data[i].nombreConductor,					
					data[i].placaVehiculo,
					data[i].horaInicio,
					data[i].horaFin,
					data[i].duracion,
					data[i].cantPasajeros,
					data[i].ocupacion
				]).draw()
				
			}
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reportes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>