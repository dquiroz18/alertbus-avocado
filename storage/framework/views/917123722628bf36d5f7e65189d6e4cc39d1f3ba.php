<!DOCTYPE html>
<html>
<head>
	<title> Reporte Manifiesto</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		@page  { margin: 2cm; }
		body { margin: 0px; }
		h2 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 26px;}
		h3 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 24px;}
		h4 { margin-top: 0px; margin-bottom: 0px; font-weight: bold; font-size: 18px;}
		h5 { margin-top: 0px; margin-bottom: 0px; font-weight: normal; font-size: 14px;}
		td { font-size: 9px; }
		td b { font-size: 9px; }
	</style>
</head>
<body>
<div class="container">
	<table class="table table-bordered table-condensed">
		<tr>
			<td colspan="6" style="border-color: white"><?php echo e(date('d/m/Y H:i')); ?></td>
			<td colspan="2" style="border-color: white"><img src="<?php echo e(asset('images/logo.png')); ?>" style="width: 150px; float: right;"></td>
		</tr>
		<tr>
			<td colspan="8" height="20px" style="border-color: white; text-align: center;"></td>
		</tr>
		<tr>
			<td colspan="8" height="20px" style="border-color: white; text-align: center;"><h3>Manifiesto de Viaje</h3></td>
		</tr>
		<tr>
			<td colspan="6" style="border-color: white; background-color: #ededed"><b>Empresa</b></td>
			<td style="border-color: white; background-color: #ededed"><b>Fecha</b></td>
			<td style="border-color: white; background-color: #ededed"><b></b></td>
		</tr>

		<tr>
			<td colspan="6" style="border-color: white"><?php echo e($data[0]->nombreEmpresa); ?></td>
			<td style="border-color: white"><?php echo e($data[0]->fecha); ?></td>
			<td style="border-color: white"></td>
		</tr>
			
		<?php $i = 1; ?>
		<tr>
			<td colspan="8" height="10px" style="border-color: white"></td>
		</tr>

		<tr>
			<td align="center" colspan="8" style="background-color: #2A3F54"><b style="color: white;">Datos Basicos</b></td>
		</tr>
		<tr>
			<td style="background-color: #ededed"><b>Fecha</b></td>
			<td ><?php echo e($data[0]->fecha); ?></td>
			<td colspan="2" style="background-color: #ededed"><b>N° Doc Interno</b></td>
			<td colspan="2"><?php echo e($data[0]->idViaje); ?></td>
			<td style="background-color: #ededed"><b>Transportista</b></td>
			<td><?php echo e($data[0]->nombreProveedor); ?></td>
		</tr>
		<tr>
			<td style="background-color: #ededed"><b>Placa</b></td>
			<td ><?php echo e($data[0]->placaVehiculo); ?></td>
			<td colspan="2" style="background-color: #ededed"><b>Ruta</b></td>
			<td colspan="2"><?php echo e($data[0]->nombreRuta); ?></td>
			<td style="background-color: #ededed"><b>Centro Costo</b></td>
			<td><?php echo e($data[0]->nombreCentroCosto); ?></td>
		</tr>
		<tr>
			<td style="background-color: #ededed"><b>Hora Inicio</b></td>
			<td ><?php echo e($data[0]->horaInicio); ?></td>
			<td colspan="2" style="background-color: #ededed"><b>Hora Fin</b></td>
			<td colspan="2"><?php echo e($data[0]->horaFin); ?></td>
			<td style="background-color: #ededed"><b>Capacidad Vehí.</b></td>
			<td ><?php echo e($data[0]->capacidad); ?></td>

		</tr>

		<tr>
			<td colspan="8" height="10px" style="border-color: white"></td>
		</tr>
		<tr>
			<td colspan="8" style="border-color: white"><b>Detalle de Pasajeros</b></td>
		</tr>
		<tr>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center"><b>N°</b></td>
			<td style="text-align: center; background: #2A3F54; color: white"  align="center"><b>N° Documento</b></td>
			<td style="text-align: center; background: #2A3F54; color: white" colspan="6" align="center"><b>Trabajador</b></td>
		</tr>
			<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($i); ?><?php $i++ ?></td>
					<td><?php echo e($item->numeroDocumento); ?></td>
					<td colspan="6"><?php echo e(ucwords($item->nombreTrabajador)); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td colspan="6" align="right" style="background-color: #ededed"><b>Cant. Pasajeros</b></td>
			<td colspan="2"><?php echo e(($i-1)); ?></td>
		</tr>
		<tr >
			<td height="40px" colspan="9" style="border-color: white"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white; border-bottom: 1px solid #000"></td>
			<td colspan="2" style="border-color: white;"></td>
			<td colspan="3" style="border-color: white; border-bottom: 1px solid #000"></td>
			<td style="border-color: white;"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center">TRANSPORTISTA</td>
			<td colspan="2" style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center">EMPRESA</td>
			<td style="border-color: white;"></td>
		</tr>
		<tr>
			<td style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center"><?php echo e($data[0]->nombreProveedor); ?></td>
			<td colspan="2" style="border-color: white;"></td>
			<td colspan="3" style="border-color: white" align="center"><?php echo e($data[0]->nombreEmpresa); ?></td>
			<td style="border-color: white;"></td>
		</tr>

	</table>
</div>
</body>
</html>