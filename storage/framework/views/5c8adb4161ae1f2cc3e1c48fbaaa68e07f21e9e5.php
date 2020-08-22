<?php $__env->startSection('main-content'); ?>
	<style>
		.table {
			margin-bottom: 0px !important;
		}
	</style>
	<div>
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Operaciones</span>
	               <span> >> </span>
	               <span class="active">Importar Programacion</span>
	           </div>
	       </div>
	    </div>
	    <?php if(session('message')): ?>
			<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            <?php echo session('message'); ?>

	         </div>
		<?php endif; ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="x_panel">
		        	<div class="x_title">
		        		<div class="row">
		        			<div class="col-sm-3">
		        				<a href="<?php echo e(url('viajes/plantilla/descargar')); ?>" target="_blank" class="btn btn-info" id="sinc_s360"><i class="fa fa-file-excel-o"></i> Descargar Plantilla</a>
		        			</div>
		        			<div class="col-sm-7">
		        				<form action="<?php echo e(url('viajes/plantilla/subir')); ?>" method="post" enctype="multipart/form-data">
		        					<?php echo e(csrf_field()); ?>

		        					<div class="col-sm-6">
		        						<input type="file" name="file" id="file" class="form-control" accept=".xlsx">	
		        					</div>
		        					<div class="col-sm-6">
		        						<button type="submit" class="btn btn-success"><i class="fa fa-arrow-left"></i> Subir Data</a>	
		        					</div>
		        				</form>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        </div>
			</div>
		</div>
		        
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>