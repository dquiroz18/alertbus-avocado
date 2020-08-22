<!DOCTYPE html>
<html>
<head>
	<title> Reporte Liquidacion</title>
	<style>
		* {font-family: 'Roboto', sans-serif;}
		@page  { margin: 1cm; }
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
			<td colspan="2" style="border-color: white"><img src="<?php echo e(asset('images/logo.png')); ?>" style="width: 100px; float: left;"></td>
			<td colspan="6" style="border-color: white; text-align: right;"><?php echo e(date('d/m/Y H:i')); ?></td>
		</tr>
		<tr>
			<td colspan="8" height="50px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="8" style="border-color: white;"><?php echo e($empresa); ?></td>
		</tr>
		<tr>
			<td colspan="8" height="10px" style="border-color: white;"></td>
		</tr>
		<tr>
			<td colspan="8" align="center" style="border-color: white; text-align: center;"><h3>Liquidacion de Viajes</h3></td>
		</tr>
		<tr>
			<td colspan="8" style="border-color: white; text-align: center;">(<?php echo e(date("d/m/Y", strtotime($desde))); ?> - <?php echo e(date("d/m/Y", strtotime($hasta))); ?>)</td>
		</tr>

		<?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr >
				<td height="10px" colspan="8" style="border-color: white"></td>
			</tr>
			<tr>
				<td colspan="8" style="border-color: white; border-bottom: 1px solid grey"><h5>TRANSPORTISTA: <?php echo e($proveedor[0]->nombreProveedor); ?></h5></td>
			</tr>
			<tr >
				<td height="5px" colspan="8" style="border-color: white"></td>
			</tr>
			<tr>
				<td align="center" style="background: #2A3F54; color: white" width="10px"><b>N°</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="70px"><b>Fecha</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="220px"><b>Ruta</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="60px"><b>Tipo Vehiculo</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="60px"><b>Placa</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="130px"><b>Centro Costo</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="50px"><b>Cant. Pasj.</b></td>
				<td align="center" style="background: #2A3F54; color: white" width="70px"><b>Tarifa</b></td>
			</tr>
			<?php $i = 1; ?>
			<?php $tarifa = 0; ?>
			<?php $__currentLoopData = $proveedor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td align="center"><?php echo e($i); ?><?php $i++ ?></td>
					<td align="center"><?php echo e($row->fecha); ?></td>
					<td><?php echo e($row->nombreRuta); ?></td>
					<td align="center"><?php echo e($row->nombreTipoVehiculo); ?></td>
					<td align="center"><?php echo e($row->placaVehiculo); ?></td>
					<td><?php echo e($row->nombreCentroCosto); ?></td>
					<td align="center"><?php echo e($row->cantPasajeros); ?></td>
					<td align="center">S/. <?php echo e($row->tarifa); ?><?php $tarifa += $row->tarifa; ?></td>
				</tr>
				<tr >
					<td height="1px" colspan="8" style="border-color: white"></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td colspan="7" align="right" style="background-color: #ededed"><b>TOTAL</b></td>
					<td align="center">S/. <?php echo e($tarifa); ?></td>
				</tr>
				<tr >
					<td height="40px" colspan="8" style="border-color: white"></td>
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
					<td colspan="3" style="border-color: white" align="center"><?php echo e($proveedor[0]->nombreProveedor); ?></td>
					<td colspan="1" style="border-color: white;"></td>
					<td colspan="3" style="border-color: white" align="center"><?php echo e($empresa); ?></td>
					<td style="border-color: white;"></td>
				</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</table>
</div>
</body>
</html>