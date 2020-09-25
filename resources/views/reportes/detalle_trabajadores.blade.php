@extends('layouts.reportes')

@section('name_reporte_breadcrumbs')
	<span class="active"><a href="{{ url('reportes/viaje-personal') }}">Manifiesto</a></span>
@endsection

@section('reporte_title')
	<h2>Manifiesto</h2>
@endsection

@section('beforeTable')
	<div class="col-sm-3">
		<a href="" id="pdf_" role="button" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf"></i> Generar Reporte de Manifiesto</a>
	</div>
@endsection

@section('masFiltros2')
		<div class="col-sm-3">
			<label for="vehiculo">Placa</label> 
			<select id="vehiculo" class="form-control">
				<option value="0">Seleccione</option>
			</select>
		</div>
@endsection

@section('content-table')
	<thead>
		<tr>
			@foreach ($header as $td)
				<th>{{ $td }}</th>
			@endforeach
		</tr>
	</thead>
@endsection

@section('script')
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script>
		var empresas = {!! json_encode($empresas) !!};
		var centrocostos = {!! json_encode($centrocostos) !!};
		var transportistas = {!! json_encode($transportistas) !!};
		var tiposViajes = {!! json_encode($tiposViajes) !!};
		var rutas = {!! json_encode($rutas) !!};
		var vehiculos = {!! json_encode($vehiculos) !!};
		

		$(document).ready(function () {
			tabla.buttons().container().prependTo( tabla.table().container() );
			for (var i = 0; i < empresas.length; i++) {
                ("{{Auth::user()->idEmpresa}}".split('-')).forEach(function(idEmpresa) {
					if(idEmpresa == empresas[i].idEmpresa)
						$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');								
				});
			}
			for (var i = 0; i < transportistas.length; i++) {
				@if (Auth::user()->tipo=='T')
					var idTransportista = {{ Auth::user()->idProveedor }};
					if (idTransportista == transportistas[i].idProveedor) {
						$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
					}
				@else
					$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');	
				@endif
			}
			$('#tipoViaje').parent().hide();
			$("#empresa option:first").attr('selected','selected');
			$('#empresa').trigger('change');
		});

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					$('#centrocosto').append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
		});

		$('#transportista').change(function () {
			var idTransportista = $(this).val();

			$('#ruta').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#tipoViaje').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#vehiculo').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < rutas.length; i++) {
				$('#ruta').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}

			for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					$('#tipoViaje').append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}
			for (var i = 0; i < vehiculos.length; i++) {
				$('#vehiculo').append('<option value="'+vehiculos[i].idVehiculo+'">'+vehiculos[i].placaVehiculo+'</option>');
			}
		});

		var tabla = $('#tabla').DataTable({ 
	        buttons: [
	            {
	                extend: 'excelHtml5',
	                title: 'Manifiesto'
	            }
	        ]
		 });
		$('#filtrar').click(function () {
			$('#loading').show();
			$('#tabla').hide();
			var idEmpresa = $('#empresa').val();
			var idCentroCosto = $('#centrocosto').val();
			var idTransportista = $('#transportista').val();
			var idTipoTarifa = $('#tipoViaje').val();
			var idRuta = $('#ruta').val();
			var idVehiculo = $('#vehiculo').val();

			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			@if (Auth::user()->tipo == 'T')
			if (idTransportista == 0) {
				alert("Seleccione el Transportista");
				$('#loading').hide();
				$('#tabla').show();
				return false;
			}
			@endif

			var sp_name = "SP_AlertBus_RPT_Viaje_Personal " + idVehiculo + ', ';

			var buscar_http = "{{ url('reportes/filtrar/') }}" + '/' + idEmpresa
																 + '/' + idCentroCosto
																 + '/' + idTransportista
																 + '/' + idTipoTarifa
																 + '/' + idRuta
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
							data[i].nombreCentroCosto,
							data[i].nombreProveedor,
							data[i].nombreRuta,
							data[i].nombreTipoVehiculo,
							data[i].placaVehiculo,							
							data[i].horaInicio,
							data[i].horaFin,							
							data[i].numeroDocumento,
							data[i].nombreTrabajador,
							data[i].tipoSuspension
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
			var idVehiculo = $('#vehiculo').val();

			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			var sp_name = "SP_AlertBus_RPT_Viaje_Personal " + idVehiculo + ', ';

			var buscar_http = "{{ url('reportes/manifiesto/pdf') }}" + '/' + idEmpresa
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
@endsection