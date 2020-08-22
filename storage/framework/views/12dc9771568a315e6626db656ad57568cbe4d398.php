<?php $__env->startSection('main-content'); ?>
<style type="text/css">
  /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
     
</style>
	<div class="col-sm-12">
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Reportes</span>
	               <span> >> </span>
	               <span><a href="<?php echo e(url('reportes/viajes/')); ?>">Viajes</a></span>
	               <span> >> </span>
	               <span class="active">Tracking</span>
	           </div>
	       </div>
	    </div>
	    <div class="x_panel">
        	<div class="x_title">
	            <h2>Detalle de Viaje</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<div class="row">
        			<div class="col-sm-6"><h2>Fecha: <?php echo e($detalle->fecha); ?></h2></div>
        			<div class="col-sm-6"><h2>Proveedor: <?php echo e($detalle->nombreProveedor); ?></h2></div>
        		</div>
        		<div class="row">
        			<div class="col-sm-6"><h2>Ruta: <?php echo e($detalle->nombreRuta); ?></h2></div>
        			<div class="col-sm-6"><h2>Placa: <?php echo e($detalle->placaVehiculo); ?></h2></div>
        		</div>
			    <iframe src="<?php echo e(url('tracking_iframe').'/'.$id); ?>" width="80%" height="600px"></iframe>
            </div>
        </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>