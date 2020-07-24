<!DOCTYPE html>
<html>
<head>
	<title> Reporte Manifiesto</title>
	<style>
		* {font-family: 'Roboto', sans-serif;}
		@page { margin: 1cm; }
		body { margin: 0px; }
		h2 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 24px;}
		h3 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 20px;}
		h4 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 16px;}
		h5 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 14px;}
		td { font-size: 12px; }
		td b { font-size: 12px; }
	</style>
</head>
<body>
<div class="container">
	<table>
		<tr>
			<td colspan="2" style="border-color: white"><img src="{{ asset('login_/images/'.$logo) }}" style="width: 190px; float: left;"></td>
			<td colspan="7" style="border-color: white; text-align: right;">{{ date('d/m/Y H:i') }}</td>
		</tr>
		<tr>
			<td colspan="9" height="50px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="9" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="9" height="10px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="9" align="center" style="border-color: white; text-align: center;"><h3>Manifiesto de Viaje</h3></td>
		</tr>
			
		<?php $i = 1; ?>
		<tr>
			<td colspan="9" height="10px" style="border-color: white"></td>
		</tr>

		<tr>
			<td align="center" colspan="9" style="background-color: #2A3F54"><b style="color: white;">Datos Basicos</b></td>
		</tr>
		<tr>
			<td style="background-color: #ededed"><b>Fecha</b></td>
			<td align="center">{{ $data[0]->fecha }}</td>
			<td style="background-color: #ededed"><b>Transportista</b></td>
			<td colspan="6" align="center">{{ $data[0]->nombreProveedor }}</td>
		</tr>
		<tr><td colspan="9" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td style="background-color: #ededed"><b>Ruta</b></td>
			<td colspan="2" align="center">{{ $data[0]->nombreRuta }}</td>
			<td style="background-color: #ededed"><b>Placa</b></td>
			<td align="center">{{ $data[0]->placaVehiculo }}</td>
			<td style="background-color: #ededed"><b>Capacidad</b></td>
			<td align="center">{{ $data[0]->capacidad }}</td>
			<td></td>
		</tr>
		<tr><td colspan="9" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<!-- <td style="background-color: #ededed"><b>Area</b></td> -->
			<!-- <td colspan="2" align="center"></td> -->
			<td colspan="3" style="background-color: #ededed"><b>Centro Costo</b></td>
			<td colspan="6" align="center">{{ $data[0]->nombreCentroCosto }}</td>
		</tr>
		<tr><td colspan="9" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td style="background-color: #ededed"><b>Hora Inicio</b></td>
			<td align="center">{{ $data[0]->horaInicio }}</td>
			<td style="background-color: #ededed"><b>Hora Fin</b></td>
			<td align="center">{{ $data[0]->horaFin }}</td>
		</tr>
		<tr><td colspan="9" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td colspan="9" height="10px" style="border-color: white"></td>
		</tr>
		<tr>
			<td colspan="9" style="border-color: white"><b>Detalle de Pasajeros</b></td>
		</tr>
		<tr>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center" width="50px"><b>N°</b></td>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center" width="90px"><b>N° Documento</b></td>
			<td style="text-align: center; background: #2A3F54; color: white" colspan="6" align="center" width="390px"><b>Trabajador</b></td>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center" width="50px"><b>N° Asiento</b></td>
		</tr>
			@foreach ($data as $item)
				<tr>
					<td align="center">{{ $i }}<?php $i++ ?></td>
					<td align="center">{{ $item->numeroDocumento }}</td>
					<td colspan="6" style="padding-left: 10px">{{ ucwords($item->nombreTrabajador) }}</td>
					<td align="center">{{ $item->nroAsiento }}</td>
				</tr>
				<tr><td colspan="9" height="1px" style="border-color: white"></td></tr>
			@endforeach
		<tr >
			<td height="40px" colspan="9" style="border-color: white"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white; border-bottom: 1px solid #000"></td>
			<td colspan="1" style="border-color: white;"></td>
			<td colspan="3" style="border-color: white; border-bottom: 1px solid #000"></td>
			<td style="border-color: white;"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center">TRANSPORTISTA</td>
			<td colspan="1" style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center">EMPRESA</td>
			<td style="border-color: white;"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white;" align="center" valign="center">{{ $data[0]->nombreProveedor }}</td>
			<td colspan="1" style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center" valign="center">{{ $data[0]->nombreEmpresa }}</td>
			<td style="border-color: white;"></td>
		</tr>

	</table>
</div>
</body>
</html>