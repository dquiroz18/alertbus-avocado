<!DOCTYPE html>
<html>
<head>
	<title> Reporte Manifiesto</title>
	<style>
		* {font-family: 'Roboto', sans-serif;}
		@page  { margin: 1.2cm; }
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
			<td colspan="2" style="border-color: white"><img src="<?php echo e(asset('login_/images/'.$logo)); ?>" style="width: 190px; float: left;"></td>
			<td colspan="8" style="border-color: white; text-align: right;"><?php echo e(date('d/m/Y H:i')); ?></td>
		</tr>
		<tr>
			<td colspan="10" height="90px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="10" style="border-color: white; text-align: center; font-weight: bold; font-size: 20px;">Manifiesto de Viaje</td>
		</tr>
		<tr>
			<td colspan="10" style="border-color: white; text-align: center;"><?php echo e($data[0]->fecha); ?></td>
		</tr>
			
		<?php $i = 1; ?>
		<tr>
			<td colspan="10" height="10px" style="border-color: white"></td>
		</tr>

		<tr>
			<td align="center" colspan="10" style="background-color: #2A3F54"><b style="color: white;">Datos Basicos</b></td>
		</tr>
		<tr>
			<td style="background-color: #ededed"><b>Fecha</b></td>
			<td align="center"><?php echo e($data[0]->fecha); ?></td>
			<td style="background-color: #ededed"><b>Transportista</b></td>
			<td colspan="7" align="center"><?php echo e($data[0]->nombreProveedor); ?></td>
		</tr>
		<tr><td colspan="10" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td style="background-color: #ededed"><b>Ruta</b></td>
			<td colspan="2" align="center"><?php echo e($data[0]->nombreRuta); ?></td>
			<td style="background-color: #ededed"><b>Placa</b></td>
			<td colspan="3" align="center"><?php echo e($data[0]->placaVehiculo); ?></td>
			<td colspan="2" style="background-color: #ededed"><b>Capacidad Vehículo</b></td>
			<td align="center"><?php echo e($data[0]->capacidad); ?></td>
		</tr>
		<tr><td colspan="10" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td style="background-color: #ededed"><b>Centro Costo</b></td>
			<td colspan="3" align="center"><?php echo e($data[0]->nombreCentroCosto); ?></td>
		</tr>
		<tr><td colspan="10" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td style="background-color: #ededed"><b>Hora Inicio</b></td>
			<td align="center"><?php echo e($data[0]->horaInicio); ?></td>
			<td style="background-color: #ededed"><b>Hora Fin</b></td>
			<td align="center"><?php echo e($data[0]->horaFin); ?></td>
		</tr>
		<tr><td colspan="10" height="1.5px" style="border-color: white"></td></tr>
		<tr>
			<td colspan="10" height="10px" style="border-color: white"></td>
		</tr>
		<tr>
			<td colspan="10" style="border-color: white"><b>Detalle de Pasajeros</b></td>
		</tr>
		<tr>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center" width="70px"><b>N°</b></td>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center" width="90px"><b>N° Documento</b></td>
			<td style="text-align: center; background: #2A3F54; color: white" colspan="6" align="center" width="230px"><b>Trabajador</b></td>
			<td style="text-align: center; background: #2A3F54; color: white" align="center" colspan="2" width="200px"><b>Area</b></td>
		</tr>
			<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td align="center"><?php echo e($i); ?><?php $i++ ?></td>
					<td align="center"><?php echo e($item->numeroDocumento); ?></td>
					<td colspan="6" style="padding-left: 10px"><?php echo e(ucwords($item->nombreTrabajador)); ?></td>
					<td align="center"><?php echo e($item->areaTrabajador); ?></td>
				</tr>
				<tr><td colspan="10" height="1px" style="border-color: white"></td></tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<tr >
			<td height="40px" colspan="10" style="border-color: white"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white; border-bottom: 1px solid #000"></td>
			<td colspan="1" style="border-color: white;"></td>
			<td colspan="4" style="border-color: white; border-bottom: 1px solid #000"></td>
			<td style="border-color: white;"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center">TRANSPORTISTA</td>
			<td colspan="1" style="border-color: white;"></td>
			<td colspan="4" style="border-color: white" align="center">EMPRESA</td>
			<td style="border-color: white;"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center"><?php echo e($data[0]->nombreProveedor); ?></td>
			<td colspan="1" style="border-color: white;"></td>
			<td colspan="4" style="border-color: white" align="center"><?php echo e($data[0]->nombreEmpresa); ?></td>
			<td style="border-color: white;"></td>
		</tr>

	</table>
</div>
</body>
</html>