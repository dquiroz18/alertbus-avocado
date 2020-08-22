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
	               <span>Mantenimiento</span>
	               <span> >> </span>
	               <span class="active">Centro Costo</span>
	           </div>
	       </div>
	    </div>
	    <div class="row" id="alert" style="display: none;">
	    	<div class="col-sm-12">
	    		<div class="alert alert-success">
	            	<button type="button" id="alert-close">×</button>
	            	<h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            	<span id="alert-message"></span>
	         	</div>
	    	</div>
	    </div>
		<div class="row">
			<div class="col-sm-12">
				<div class="x_panel">
		        	<div class="x_title">
		        		<h3>Listado de Centro de Costos</h3>
		        		<div class="row">
		        			<div class="col-sm-4">
		        				<div class="form-group">
		        					<label>Empresa</label>
		        					<select id="cmbEmpresa" class="form-control">
		        						<option value="0">Seleccione</option>
		        						<?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		        							<?php if(Auth::user()->tipo == 'V'): ?>
					          				<?php $__currentLoopData = $idEmpresas = explode('-', Auth::user()->idEmpresas); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					          					<?php if($id == $emp->idEmpresa): ?>
					          						<option value="<?php echo e($emp->idEmpresa); ?>"><?php echo e($emp->razonSocial); ?></option>
					          					<?php endif; ?>
					          				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					          			<?php else: ?> 
					          				<option value="<?php echo e($emp->idEmpresa); ?>"><?php echo e($emp->razonSocial); ?></option>
					          			<?php endif; ?>
		        						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
		        					</select>
		        				</div>
		        			</div>
		        			<div class="col-sm-2">
		        				<br>
								<button type="button" id="buscar" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
		        			</div>
		        			<div class="clearfix"></div>
		        			<!-- 
		        				<div class="col-sm-4" id="showNewCentroCosto">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Centro de Costo</button>
		        			</div>
		        			 -->
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                	<th>Empresa</th>
				                    <th>Código</th>
				                    <th>Jerarquia</th>
				                    <th>Centro Costo</th>
				                    <!-- <th width="80px">Ver/Editar</th>
				                    <th width="80px">Eliminar</th> -->
				                </tr>
				            </thead>
				        </table>
		        	</div>
		        </div>
			</div>
		</div>  
	</div>

	<!-- delete ceco -->
	<div class="modal fade" tabindex="-1" role="dialog" id="delete">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Centro de Costo</h3>
	      </div>
	      <form>
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar el Centro de Costo?
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" id="btn-delete" class="btn btn-danger">Eliminar</button>
	       </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	 <!-- Nuevo ceco -->
	<div class="modal fade" tabindex="-1" role="dialog" id="new">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="font-weight: bold;">Datos del Centro de Costo</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form>
	      		<input type="hidden" name="id" id="txtIdN">
	      		<div class="row">
	      			<div class="form-group col-sm-4">
	      				<label>Empresa</label>
	    					<select name="idEmpresa" id="cmbEmpresaM" class="form-control" data-required="1">
	    						<option value="0">Seleccione</option>
	    						<?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    							<?php if(Auth::user()->tipo == 'V'): ?>
		          				<?php $__currentLoopData = $idEmpresas = explode('-', Auth::user()->idEmpresas); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		          					<?php if($id == $emp->idEmpresa): ?>
		          						<option value="<?php echo e($emp->idEmpresa); ?>"><?php echo e($emp->razonSocial); ?></option>
		          					<?php endif; ?>
		          				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		          			<?php else: ?> 
		          				<option value="<?php echo e($emp->idEmpresa); ?>"><?php echo e($emp->razonSocial); ?></option>
		          			<?php endif; ?>
	    						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
	    					</select>
	      			</div>
	      		</div>
	      		<div class="row">
	            <div class="form-group col-sm-4">
	              <label for="txtDocumentNumber">Código</label>
	              <input type="text" class="form-control" id="txtCodigo" maxlength="12" name="codigo" required>
	            </div>
	            <div class="form-group col-sm-8">
	            	<label>Centro Costo</label>
	            	<input type="text" name="descripcion" id="txtNombre" class="form-control" maxlength="30" required>
	            </div>
		      	</div>
	      </div>
	      <div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        	<button type="submit" id="btn-new" class="btn btn-primary">Guardar</button>
	       	</form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script>
		var centerColumns = [0, 1, 2];
	</script>
	<?php echo $__env->make('helpers.dataManagment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
		$('#buscar').click(function() {
	  	var o_id = $(this).parent().prev().find('select').val();
	  	data = getModelByParams({idEmpresa: o_id}, "<?php echo e(url('mantenimiento/centro-costos/listar')); ?>", 'GET');
	  	listarOnTable(2, 4, data, [0, 2], false, false, false);
	  });

		$('#new').on('show.bs.modal', function() {
			if (id != 0) {
				var ceco = getModelByParams({idCentroCosto: id}, "<?php echo e(url('mantenimiento/centro-costo')); ?>", 'GET');
				$('#cmbEmpresaM').val(ceco.idEmpresa);
				$('#txtCodigo').val(ceco.codigoCentroCosto);
				$('#txtNombre').val(ceco.nombreCentroCosto);
				$('#txtIdN').val(ceco.idCentroCosto);
			}
			else {
				$('#new form').trigger('reset');
				$('#txtIdN').val('');
			}
		});

		$('#delete').on('show.bs.modal', function () {
			$('#txtIdE').val(id);
		})

		$('#new form').submit(function(e) {
	  	e.preventDefault();
	  	if ($('#cmbEmpresaM').val() == 0) {
	  		alert('Seleccione una Empresa');
	  		return false;
	  	}
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/centro-costo')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#new form').trigger('reset');
				$('#new').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar el Centro de Costo. Contacte con Soporte");
				$('#alert').show();
				$('#new').modal('hide');
	  	}
	  });

	  $('#delete form').submit(function(e) {
	  	e.preventDefault();
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/centro-costo/delete')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#delete form').trigger('reset');
				$('#delete').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar el Centro de Costo. Contacte con Soporte");
				$('#alert').show();
				$('#delete').modal('hide');
	  	}
	  });

	  $('#delete, #new').on('hide.bs.modal', function(){
	  	id = 0;
	  });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>