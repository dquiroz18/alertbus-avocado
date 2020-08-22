<?php $__env->startSection('main-content'); ?>
	<style>
		.divtable {
			overflow-x: scroll;
    		white-space: nowrap;
		}
	</style>
	<div class="col-sm-12">
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Operaciones</span>
	               <span> >> </span>
	               <span class="active"><a href="<?php echo e(url('tareos/validacion')); ?>">Programar Viajes</a></span>
	           </div>
	       </div>
	    </div>
	    <?php if(session('message')): ?>
	    	<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Exito</h4>
               	<?php echo session('message'); ?>

             </div>
	    <?php endif; ?>
	    <form action="<?php echo e(url('viajes/programar')); ?>" method="POST">
	    <?php echo e(csrf_field()); ?>

	    <div class="x_panel">
        	<div class="x_title">
	            <h2>Programar Viajes</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="empresa">Empresa</label>
						<select name="empresa" id="empresa" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-1">
        				<label>Programar</label>
        				<br>
						<button type="button" class="btn btn-info" id="programar">
							<i class="fa fa-calendar"></i>
						</button>
        			</div>
        		</div>
        		<div class="row" id="filtros" style="display: none;">
        			<div class="form-group col-sm-5">
        				<p>
        					Nro. viajes a programar: <input type="number" width="80px" id="nroFilas">
        				</p>
        				<button type="button" class="btn btn-primary" id="agregarFilas">
        					<i class="fa fa-check"></i>
        				</button>
        			</div>
        			<div class="form-group col-sm-4">
        				<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Registrar</button>
        			</div>
        		</div>
            </div>
        </div>
        <div class="x_panel">
        	<div class="x_content">
        		<div class="col-sm-12 divtable">
        			<table class="table table-striped table-bordered table-condensed" id="tablaProgramacion">
			            <thead>
			                <tr>
			                	<th>Nro.</th>
			                    <th>Fecha</th>
			                    <th>Hora</th>
			                    <th>Centro Costo</th>
			                    <th>Transportista</th>
			                    <th>Ruta</th> 
			                    <th>Tipo de Vehículo</th>
			                    <th>Tarifa</th>
			                    <th>Tarifa Final</th>
			                </tr>
			            </thead>
			        </table>
        		</div>
			        
        	</div>
        </div>
        </form>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script>
		var empresas = <?php echo json_encode($empresas); ?>;

		var centrocostos = <?php echo json_encode($centrocostos); ?>;

		var transportistas = <?php echo json_encode($transportistas); ?>;

		var rutas = <?php echo json_encode($rutas); ?>;

		var tiposVehiculos = <?php echo json_encode($tiposVehiculos); ?>;

		var tiposViajes = <?php echo json_encode($tiposViajes); ?>;

		var tarifas = <?php echo json_encode($tarifas); ?>;
		
		var inputFecha = $('<input type="date" class="fechas" name="fechas[]" value="'+"<?php echo e(date('Y-m-d')); ?>"+'">');
		var inputHora = $('<input type="time" class="horas" name="horas[]">');
		var inputPrecios = $('<input type="text" class="precios" name="precios[]" style="width: 80px;">');
		
		var comboRutas = $('<select class="rutas" name="rutas[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTransportistas = $('<select class="transportistas" name="transportistas[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTiposVehiculos = $('<select class="tiposVehiculos" name="tiposVehiculos[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTarifas = $('<select class="tarifas" name="tarifas[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboCentroCostos = $('<select class="centrocostos" name="centrocostos[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTiposViajes = $('<select class="tiposViajes" name="tiposViajes[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');

		$(document).ready(function () {
			for (var i = 0; i < empresas.length; i++) {
				$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');
			}
			for (var i = 0; i < transportistas.length; i++) {
				comboTransportistas.append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
			}
		});

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					comboCentroCostos.append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
		});

		$('#tablaProgramacion').on('change', '.transportistas', function () {
			var idTransportista = $(this).val();

			comboRutas.find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			comboTiposVehiculos.find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			//comboTiposViajes.find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < rutas.length; i++) {
				if (idTransportista == rutas[i].idProveedor) {
					comboRutas.append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
				}
			}

			for (var i = 0; i < tiposVehiculos.length; i++) {
				if (idTransportista == tiposVehiculos[i].idProveedor) {
					comboTiposVehiculos.append('<option value="'+tiposVehiculos[i].idTipoVehiculo+'">'+tiposVehiculos[i].nombreTipoVehiculo+'</option>');
				}
			}

			/*for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					comboTiposViajes.append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}*/

			$(this).parent().next('td').find('select').remove();
			$(this).parent().next('td').append(comboRutas.prop('outerHTML'));

			$(this).parent().next('td').next('td').find('select').remove();
			$(this).parent().next('td').next('td').append(comboTiposVehiculos.prop('outerHTML'));

			/*$(this).parent().next('td').next('td').next('td').find('select').remove();
			$(this).parent().next('td').next('td').next('td').append(comboTiposViajes.prop('outerHTML'));
			$(this).parent().next('td').next('td').next('td').find('select').trigger('change');*/
		});
		$('#tablaProgramacion').on('change', '.fechas', function () {
			$(this).parent().next('td').next('td').next('td').next('td').next('td').find('select').trigger('change');
		});
		$('#tablaProgramacion').on('change', '.tiposVehiculos', function () {
			//var idTipoTarifa = $(this).val();

			var idTipoVehiculo = $(this).val();

			var idRuta = $(this).parent().prev('td').find('select').val();

			var idTransportista = $(this).parent().prev('td').prev('td').find('select').val();
			var fecha = $(this).parent().prev('td').prev('td').prev('td').prev('td').prev('td').find('input').val();

			comboTarifas.find('option').remove().end();

			var encontrado = false;

			for (var i = 0; i < tarifas.length; i++) {
				if (idTransportista == tarifas[i].idProveedor &&
					idRuta == tarifas[i].idRuta &&
					idTipoVehiculo == tarifas[i].idTipoVehiculo &&
					(fecha >= tarifas[i].desde && fecha <= tarifas[i].hasta)
					) {
					var idTarifa = tarifas[i].idTarifa;
					var precio = tarifas[i].precio;
					comboTarifas.append('<option value="'+tarifas[i].idTarifa+'">'+tarifas[i].precio+'</option>').val(tarifas[i].idTarifa);
					encontrado = true;
					break;
				}
			}
			if (!encontrado) {
				precio = 0;
			}
			else {
				precio = comboTarifas.find('option:selected').text();
			}
			comboTarifas.hide();
			$(this).parent().next('td').html('');
			$(this).parent().next('td').append('<input type="text" readonly value="'+precio+'" style="width: 80px;"/>').append(comboTarifas.prop("outerHTML"));
			//$(this).parent().next('td').html(comboTarifas.prop("outerHTML"));
			$(this).parent().next('td').next('td').find('input').remove();
			$(this).parent().next('td').next('td').append(inputPrecios.prop("outerHTML")).find('input').val(precio);

		});

		$('#tablaProgramacion').on('change', '.rutas', function () {
			$(this).parent().next('td').find('select').val('0');
			$(this).parent().next('td').next('td').find('select').trigger('change');

			$(this).parent().next('td').next('td').find('select').val('0');

		});
/*
		$('#tablaProgramacion').on('change', '.tiposVehiculos', function () {
			$(this).parent().next('td').find('select').val('0');
			$(this).parent().next('td').find('select').trigger('change');
		});*/

		$('#programar').click(function () {
			var idEmpresa = $('#empresa').val();
			if (idEmpresa == 0) {
				alert("Seleccione una Empresa");
				return ;
			}
			$('#filtros').show();
		});

		var tablaProgramacion = $('#tablaProgramacion').DataTable();
		$('#menu_toggle').click();
		var nro = 1;
		$('#agregarFilas').click(function () {
			var nroFilas = $('#nroFilas').val();
			if (!nroFilas) {
				nroFilas = 0;
			}
			if (nroFilas > 0) {
				for (var i = 0; i < nroFilas; i++) {
					tablaProgramacion.row.add([
						nro,
						inputFecha.prop('outerHTML'),
						inputHora.prop('outerHTML'),
						comboCentroCostos.prop('outerHTML'),
						comboTransportistas.prop('outerHTML'),
						comboRutas.prop('outerHTML'),
						comboTiposVehiculos.prop('outerHTML'),
						comboTarifas.prop('outerHTML'),
						inputPrecios.prop('outerHTML')
					]).draw()
					nro += 1;
				}
			}
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>