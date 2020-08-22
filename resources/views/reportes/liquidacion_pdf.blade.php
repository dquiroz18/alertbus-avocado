<!DOCTYPE html>
<html>
<head>
	<title> Reporte Liquidacion</title>
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
			<td colspan="6" style="border-color: white; text-align: right;">{{ date('d/m/Y H:i') }}</td>
		</tr>
		<tr>
			<td colspan="8" height="50px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="8" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="8" height="10px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="8" align="center" style="border-color: white; text-align: center;"><h3>Liquidacion de Viajes</h3></td>
		</tr>
		<tr>
			<td colspan="8" style="border-color: white; text-align: center;">({{ date("d/m/Y", strtotime($desde)) }} - {{ date("d/m/Y", strtotime($hasta)) }})</td>
		</tr>

		@foreach ($proveedores as $proveedor)
			<tr >
				<td height="10px" colspan="8" style="border-color: white"></td>
			</tr>
			<tr>
				<td colspan="8" style="border-color: white; border-bottom: 1px solid grey"><h5>TRANSPORTISTA: {{ $proveedor[0]->nombreProveedor }}</h5></td>
			</tr>
			<tr >
				<td height="5px" colspan="8" style="border-color: white"></td>
			</tr>
			<tr>
				<td align="center" style="background: #2A3F54; color: white" width="20px"><b>N°</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="70px"><b>Fecha</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="200px"><b>Ruta</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="60px"><b>Tipo Vehiculo</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="60px"><b>Placa</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="100px"><b>Centro Costo</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="50px"><b>Cant. Pasj.</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="60px"><b>Tarifa</b></td>
			</tr>
			<?php $i = 1; ?>
			<?php $tarifa = 0; ?>
			@foreach ($proveedor as $row)
				<tr>
					<td align="center">{{ $i }}<?php $i++ ?></td>
					<td align="center">{{ $row->fecha }}</td>
					<td>{{ $row->nombreRuta }}</td>
					<td align="center">{{ $row->nombreTipoVehiculo }}</td>
					<td align="center">{{ $row->placaVehiculo }}</td>
					<td>{{ $row->nombreCentroCosto }}</td>
					<td align="center">{{ $row->cantPasajeros }}</td>
					<td align="center">S/. {{ $row->tarifa }}<?php $tarifa += $row->tarifa; ?></td>
				</tr>
				<tr >
					<td height="1px" colspan="8" style="border-color: white"></td>
				</tr>
			@endforeach
				<tr>
					<td colspan="7" align="right" style="background-color: #ededed"><b>TOTAL</b></td>
					<td align="center">S/. {{ $tarifa }}</td>
				</tr>
				<tr >
					<td height="40px" colspan="8" style="border-color: white"></td>
				</tr>
				<tr>
					<td style="border-color: white;"></td>
					<td colspan="2" style="border-color: white; border-bottom: 1px solid #000"></td>
					<td colspan="1" style="border-color: white;"></td>
					<td colspan="3" style="border-color: white; border-bottom: 1px solid #000"></td>
					<td style="border-color: white;"></td>
				</tr>
				<tr>
					<td style="border-color: white;"></td>
					<td colspan="2" style="border-color: white" align="center">TRANSPORTISTA</td>
					<td colspan="1" style="border-color: white;"></td>
					<td colspan="3" style="border-color: white" align="center">EMPRESA</td>
					<td style="border-color: white;"></td>
				</tr>
				<tr>
					<td style="border-color: white;"></td>
					<td colspan="2" style="border-color: white" align="center" valign="center">{{ $proveedor[0]->nombreProveedor }}</td>
					<td colspan="1" style="border-color: white;"></td>
					<td colspan="3" style="border-color: white" align="center" valign="center">{{ $empresa }}</td>
					<td style="border-color: white;"></td>
				</tr>
		@endforeach

	</table>
</div>
</body>
</html>