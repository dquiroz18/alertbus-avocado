@extends('layouts.layout')

@section('main-content')
	<style>
		.divtable {
			overflow-x: hidden;
			overflow-y: hidden;
    		white-space: nowrap;
		}
		.divtable tr td{
    		white-space: nowrap;
		}
		.divtable tr th{
    		white-space: nowrap;
		}
		.select2-container{
			height: 25px !important;
		}
		.select2 {
			width: 100%;
		}
		@media only screen and (min-width: 320px) and (max-width: 767px) {
		    #tablaProgramacion tbody {
		        border: 0;
		    }
		    #tablaProgramacion tbody tr {
		        margin-bottom: 20px !important;
		        display: block;
		        border-bottom: 0;
		    }
		    #tablaProgramacion tbody td {
		        display: block;
		        text-align: left;
		        font-size: 13px;
		        border: 0;
		        max-width: 74vw;
		    }
		    #tablaProgramacion tbody td.hasSpacing {
		        padding-bottom: 20px;
		    }
		    #tablaProgramacion tbody td:last-child {
		        border-bottom: 0;
		    }
		    #tablaProgramacion tbody td:before {
		        content: attr(data-label);
		        float: left;
		        text-transform: uppercase;
		        font-weight: bold;
		    }
		}
	</style>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<div class="col-sm-12">
        <form id="frmProgramar">
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Operaciones</span>
	               <span> >> </span>
	               <span class="active"><a href="{{ url('tareos/validacion') }}">Programar Viajes</a></span>
	           </div>
	       </div>
	    </div>
	    <div class="row" id="alert" style="display: none;">
	    	<div class="col-xs-12 col-sm-12">
	    		<div class="alert alert-success">
	            	<button type="button" id="alert-close">×</button>
	            	<h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            	<span id="alert-message"></span>
	         	</div>
	    	</div>
	    </div>
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
        			<div class="col-xs-12 form-group col-sm-3">
        				<label for="empresa">Empresa</label>
						<select id="empresa" class="form-control">
						</select>
						<input type="hidden" name="empresa" id="txtEmpresa">
        			</div>
        			<div class="col-xs-12 form-group col-sm-1">
        				<label>Programar</label>
        				<br>
						<button type="button" class="btn btn-info" id="programar">
							<i class="fa fa-calendar"></i>
						</button>
        			</div>
        		</div>
        		<div class="row" id="filtros" style="display: none;">
        			<div class="col-xs-12 form-group col-sm-3">
        				<span>
        					Nro. viajes a programar: <input type="number" width="80px" id="nroFilas" min="0">
        				</span>
        				<button type="button" class="btn btn-primary" id="agregarFilas">
        					<i class="fa fa-check"></i>
        				</button>
        			</div>
        			<div class="col-xs-12 col-sm-7"></div>
        			<div class="col-xs-12 form-group col-sm-2">
        				<button type="submit" id="registrar" class="btn btn-success"><i class="fa fa-check"></i> Registrar</button>
        			</div>
        		</div>
            </div>
        </div>
        <div class="x_panel">
        	<div class="x_content">
        		<div class="col-xs-12 col-sm-12 divtable">
        			<table class="table table-condensed table-bordered" id="tablaProgramacion" style="width: 140vw">
			            <thead>
			                <tr>
			                	<th style="width: 25px;">Nro.</th>
			                    <th style="width: 70px;">Fecha</th>
			                    <th style="width: 50px;">Hora</th>
			                    <th style="width: 150px;">Centro Costo</th>
			                    <th style="width: 250px;">Transportista</th>
			                    <th style="width: 150px;">Ruta</th> 
			                    <th style="width: 100px;">Tipo de Vehículo</th>
			                    <th style="width: 100px;">Tarifa</th>
			                    <th style="width: 100px;">Tarifa Final</th>
			                    <th style="width: 80px;">Eliminar</th>
			                </tr>
			            </thead>
			        </table>
        		</div>
			        
        	</div>
        </div>
        </form>
	</div>
@endsection

@section('script')
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script>
		var empresas = {!! json_encode($empresas) !!};

		//var areas = {!! json_encode($areas) !!};

		var centrocostos = {!! json_encode($centrocostos) !!};

		var transportistas = {!! json_encode($transportistas) !!};

		var rutas = {!! json_encode($rutas) !!};

		var tiposVehiculos = {!! json_encode($tiposVehiculos) !!};

		var tiposViajes = {!! json_encode($tiposViajes) !!};

		var tarifas = {!! json_encode($tarifas) !!};
		
		var inputFecha = $('<input type="date" class="fechas form-control" name="fechas[]" value="'+"{{ date('Y-m-d') }}"+'">');
		var inputHora = $('<input type="time" class="horas form-control" name="horas[]" style="width: 100%">');
		var inputPrecios = $('<input type="text" class="precios form-control" name="precios[]" style="width: 100%">');
		
		var comboRutas = $('<select class="rutas form-control" name="rutas[]" style="width: 100%">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTransportistas = $('<select class="transportistas form-control" name="transportistas[]" style="width: 100%">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTiposVehiculos = $('<select class="tiposVehiculos form-control" name="tiposVehiculos[]" style="width: 100%">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboTarifas = $('<select class="tarifas form-control" name="tarifas[]" style="width: 100%">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');
		var comboCentroCostos = $('<select class="centrocostos form-control" name="centrocostos[]" style="width: 100%">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');

		/*var comboAreas = $('<select class="areas form-control" name="areas[]">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');*/

		var comboTiposViajes = $('<select class="tiposViajes form-control" name="tiposViajes[]" style="width: 100%">'+
			        			'<option value="0">Seleccione</option>'+
			        		'</select>');

		var btnDeletes = $('<button class="btn btn-danger deletes"><i class="fa fa-trash"></i></button>');

		var lastPage = 0;
		$('#tablaProgramacion').on( 'page.dt', function () {
			var info = tablaProgramacion.page.info();
			lastPage = info.page;
		});

		function isMobile(){
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
				return true;
		}

		$(document).ready(function () {
			for (var i = 0; i < empresas.length; i++) {
                ("{{Auth::user()->idEmpresa}}".split('-')).forEach(function(idEmpresa) {
					if(idEmpresa == empresas[i].idEmpresa)
						$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');								
				});
			}
			$("#empresa option:first").attr('selected','selected');
			$('#empresa').trigger('change');
			if (isMobile()) {
				$('.divtable').hide();
			}
		});

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			/*for (var i = 0; i < areas.length; i++) {
				if (idEmpresa == areas[i].idEmpresa) {
					comboAreas.append('<option value="'+areas[i].idArea+'">'+areas[i].nombreArea+'</option>');
				}
			}*/
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					comboCentroCostos.append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
			comboTransportistas.html('<option value="0">Seleccione</option>');
			for (var i = 0; i < transportistas.length; i++) {
				if (transportistas[i].idEmpresa.includes(idEmpresa))
					comboTransportistas.append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
			}
		});

		$('#tablaProgramacion').on('change', '.transportistas', function () {
			var idTransportista = $(this).val();

			comboRutas.find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			comboTiposVehiculos.find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			//comboTiposViajes.find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < rutas.length; i++) {
				comboRutas.append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}

			for (var i = 0; i < tiposVehiculos.length; i++) {
    			if(idTransportista == tiposVehiculos[i].idProveedor)
					comboTiposVehiculos.append('<option value="'+tiposVehiculos[i].idTipoVehiculo+'">'+tiposVehiculos[i].nombreTipoVehiculo+'</option>');
			}

			/*for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					comboTiposViajes.append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}*/

			$(this).parent().next('td').find('select').remove();
			$(this).parent().next('td').find('.select2').remove();
			$(this).parent().next('td').append(comboRutas.prop('outerHTML'));
			$('.rutas').select2();

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
			comboTarifas.append('<option value="0"> Seleccione');

			var encontrado = false;
			precio = 0;
			for (var i = 0; i < tarifas.length; i++) {
				var hasta = tarifas[i].hasta;
				if (hasta == null) {
					hasta = "{{ date('Y-12-30') }}";
				}
				if (idRuta == tarifas[i].idRuta &&
					idTipoVehiculo == tarifas[i].idTipoVehiculo
					) {
					var idTarifa = tarifas[i].idTarifa;
					var precio = tarifas[i].precio;
					comboTarifas.append('<option value="'+tarifas[i].idTarifa+'">'+parseFloat(tarifas[i].precio).toFixed(2)+'</option>');
					encontrado = true;
				}
			}
			//comboTarifas.hide();
			$(this).parent().next('td').find('select').remove();
			$(this).parent().next('td').append(comboTarifas.prop("outerHTML")).find('select').val(idTarifa);
			//$(this).parent().next('td').html(comboTarifas.prop("outerHTML"));
			$(this).parent().next('td').next('td').find('input').remove();
			$(this).parent().next('td').next('td').append(inputPrecios.prop("outerHTML")).find('input').val(parseFloat(precio).toFixed(2));

		});

		$('#tablaProgramacion').on('change', '.tarifas', function () {
			var valor = $(this).find('option:selected').text();
			if (valor!="Seleccione") $(this).parent().next('td').find('input').val(valor);
			else $(this).parent().next('td').find('input').val('');
			
		});

		$('#tablaProgramacion').on('change', '.rutas', function () {
			$(this).parent().next('td').find('select').val('0');
			$(this).parent().next('td').next('td').find('select').trigger('change');
			$(this).parent().next('td').next('td').find('select').val('0');

		});

		$('#tablaProgramacion').on('click', '.deletes', function () {
			tablaProgramacion
		        .row( $(this).parents('tr') )
		        .remove()
		        .draw();
		    tablaProgramacion.page.info();
			tablaProgramacion.page(lastPage).draw('page');
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
			$('#empresa').prop('disabled', true);
			$('#txtEmpresa').val(idEmpresa);
			if (isMobile()) {
				$('#nroFilas').prop('readonly', true);
				$('#nroFilas').val('1');
				$('#agregarFilas').trigger('click');
				$('#agregarFilas').prop('disabled', true);
			}
		});

		var tablaProgramacion = $('#tablaProgramacion').DataTable({
			createdRow: function( row ) {
			    $(row).find('td:eq(0)').css('text-align', 'center');
			    $(row).find('td:eq(9)').css('text-align', 'center');
			    $(row).find('.centrocostos').select2();
			    $(row).find('.transportistas').select2();
			    $(row).find('.rutas').select2();
			    $(row).find('.centrocostos').parent().addClass('hasSpacing');
			    $(row).find('.transportistas').parent().addClass('hasSpacing');
			    $(row).find('.rutas').parent().addClass('hasSpacing');
			}
		});
		$('#menu_toggle').click();
		var nro = 1;
		$('#agregarFilas').click(function () {
			var nroFilas = $('#nroFilas').val();
			if (!nroFilas) {
				nroFilas = 0;
			}
			if (nroFilas > 0 && !isMobile()) {
				for (var i = 0; i < nroFilas; i++) {
					tablaProgramacion.row.add([
						(i+1),
						inputFecha.prop('outerHTML'),
						inputHora.prop('outerHTML'),
						//comboAreas.prop('outerHTML'),
						comboCentroCostos.prop('outerHTML'),
						comboTransportistas.prop('outerHTML'),
						comboRutas.prop('outerHTML'),
						comboTiposVehiculos.prop('outerHTML'),
						comboTarifas.prop('outerHTML'),
						inputPrecios.prop('outerHTML'),
						btnDeletes.prop('outerHTML')
					]);
					nro += 1;
				}
				tablaProgramacion.draw(false);
			}
			else{
				tablaProgramacion.row.add([
					'LLene todos los campos',
					'<label>Fecha</label><br/>'+
					inputFecha.prop('outerHTML'),
					'<label>Hora</label><br/>'+
					inputHora.prop('outerHTML'),
					'<label>CentroCosto</label><br/>'+
					comboCentroCostos.prop('outerHTML'),
					'<label>Transportista</label><br/>'+
					comboTransportistas.prop('outerHTML'),
					'<label>Ruta</label><br/>'+
					comboRutas.prop('outerHTML'),
					'<label>T. Vehiculo</label><br/>'+
					comboTiposVehiculos.prop('outerHTML'),
					'<label>Tarifa</label><br/>'+
					comboTarifas.prop('outerHTML'),
					'<label>Precio</label><br/>'+
					inputPrecios.prop('outerHTML'),
					''
				]);
				tablaProgramacion.draw(false);
				$('#tablaProgramacion').find('thead').css('display','none')
				$('#tablaProgramacion').css('width','75vw')
				$('.divtable').find('.row:first').hide()
				$('.divtable').find('.row:last').hide()
				$('.divtable').show()
			}
		});

	$('#nroFilas').keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        return false;
	    }
	});

	</script>
	<script>
		$('#frmProgramar').submit(function (e) {
			e.preventDefault();
			hasErrors = false;
			cCampos = 0;
			cabecera = ['Nro.', 'Fecha', 'Hora', 'Centro Costo', 'Transportista', 'Ruta' , 'Tipo de Vehículo',];

			var rows = tablaProgramacion.$('tr', {"filter": "applied"});// viewlist is

			$.each(rows, function (fila) {
				//check fila empty
				cCampos = 0;
				$(this).find('td').each( function() {
					if($(this).find('select').val() == '0' || $(this).find('select').val() == ''){
						cCampos += 1;
					}
					if($(this).find('input').val() == '' || $(this).find('input').val() == '0'){
						cCampos += 1;
					}
				});
				if (cCampos != 5) {
					$(this).find('td').each( function(columna) {
						if($(this).find('select').val() == '0' || $(this).find('select').val() == ''){
							hasErrors = true;
							alert("Error en la fila: " + (fila+1) + ", columna: " + cabecera[columna]);
							return false;
						}
						if($(this).find('input').val() == '' || $(this).find('input').val() == '0'){
							hasErrors = true;
							alert("Error en la fila: " + (fila+1) + ", columna: " + cabecera[columna]);
							return false;
						}
					});
				}
				if (hasErrors) {
					return false;
				}
			});
			if (hasErrors) {
				return false;
			}
			data = tablaProgramacion.$('input, select').serialize();
			data = data + '&empresa=' + $('#empresa').val();
			console.log(data);
			//return false;
			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "{{ url('viajes/programar') }}",
				method: 'POST',
				data: data,
				success: function(response){
					tablaProgramacion.clear().draw();
					var message = response.message;
					$('#alert-message').text(message);
					if (response.success == '0') {
						$('#alert').find('.alert').removeClass('alert-success');
						$('#alert').find('.alert').addClass('alert-danger');
					}
					else {
						$('#alert').find('.alert').addClass('alert-success');
						$('#alert').find('.alert').removeClass('alert-danger');	
					}
					$('#alert').show();
				}
			});
		})
	</script>

@endsection