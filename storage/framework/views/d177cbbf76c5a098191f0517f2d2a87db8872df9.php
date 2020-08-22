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
	               <span class="active">Conductor</span>
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
		        		<h3>Listado de Conductores</h3>
		        		<div class="row">
		        			<div class="col-sm-4">
		        				<div class="form-group">
		        					<label>Transportista</label>
		        					<select id="cmbTransportista" class="form-control">
		        						<option value="0">Seleccione</option>
		        						<?php $__currentLoopData = $transportistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					          				<?php if(Auth::user()->idProveedor != $transp->idProveedor): ?>
        										<option value="<?php echo e($transp->idProveedor); ?>"><?php echo e($transp->razonSocial); ?></option>	
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
		        			<div class="col-sm-4" id="showNewConductor">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Conductor</button>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                	<th width="300px">Transportista</th>
				                	<th>Nro. Documento</th>
				                    <th width="400px">Conductor</th>
				                    <th width="80px">Ver/Editar</th>
				                    <th width="80px">Eliminar</th>
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
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Conductor</h3>
	      </div>
	      <form>
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar el Conductor?
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
	       	<h3 class="modal-title" style="font-weight: bold;">Datos del Conductor</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form>
	      		<input type="hidden" name="id" id="txtIdN">
	      		<div class="row">
	      			<div class="col-sm-4">
        				<div class="form-group">
        					<label>Transportista</label>
        					<select id="cmbTransportistaM" class="form-control" name="transportista">
        						<option value="0">Seleccione</option>
        						<?php $__currentLoopData = $transportistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        							<?php if(Auth::user()->idProveedor != $transp->idProveedor): ?>
        								<option value="<?php echo e($transp->idProveedor); ?>"><?php echo e($transp->razonSocial); ?></option>	
        							<?php endif; ?>
        						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
        					</select>
        				</div>
        			</div>
	      		</div>
	      		<div class="row">
		            <div class="form-group col-sm-4" style="display: none;">
		              <label for="txtCode">Código</label>
		              <input type="text" class="form-control" id="txtCodigo" maxlength="12" name="codigo">
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtDocumentNumber">Nro. Documento</label>
		              <input type="number" class="form-control" id="txtNroDocumento" maxlength="8" max="99999999" name="nroDocumento" required>
		            </div>
		      	</div>
		      	<div class="row">
		            <div class="form-group col-sm-4">
		              <label for="txtApPaterno">Apellido Paterno</label>
		              <input type="text" class="form-control" id="txtApPaterno" maxlength="50" name="apPaterno" required>
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtApMaterno">Apellido Materno</label>
		              <input type="text" class="form-control" id="txtApMaterno" maxlength="50" name="apMaterno" required>
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtNombres">Nombres</label>
		              <input type="text" class="form-control" id="txtNombres" maxlength="50" name="nombres" required>
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
		var centerColumns = [0, 1, 3, 4];
	</script>
	<?php echo $__env->make('helpers.dataManagment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
		$('#txtNroDocumento').keyup(function() {
			var string = $(this).val();
			if (string.length > 8) {
				var forcedString = string.substr(0, 8);
				$(this).val(forcedString);
			}
		});
		$('#buscar').click(function() {
	  	var o_id = $(this).parent().prev().find('select').val();
	  	data = getModelByParams({idProveedor: o_id}, "<?php echo e(url('mantenimiento/conductores/listar')); ?>", 'GET');
	  	listarOnTable(2, 4, data, [0, 2], true, true, false);
	  });

		$('#new').on('show.bs.modal', function() {
			if (id != 0) {
				var model = getModelByParams({idConductor: id}, "<?php echo e(url('mantenimiento/conductor')); ?>", 'GET');
				$('#cmbTransportistaM').val(model.idProveedor);
				$('#txtCodigo').val(model.codigoConductor);
				$('#txtNroDocumento').val(model.numeroDocumento);
				$('#txtApPaterno').val(model.apellidoPaterno);
				$('#txtApMaterno').val(model.apellidoMaterno);
				$('#txtNombres').val(model.nombreConductor);
				$('#txtIdN').val(model.idConductor);
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
	  	if ($('#cmbTransportistaM').val() == 0) {
	  		alert('Seleccione un Transportista');
	  		return false;
	  	}
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/conductor')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#new form').trigger('reset');
			$('#new').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar Conductor. Contacte con Soporte");
				$('#alert').show();
				$('#new').modal('hide');
	  	}
	  });

	  $('#delete form').submit(function(e) {
	  	e.preventDefault();
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/conductor/delete')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#delete form').trigger('reset');
				$('#delete').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar Conductor. Contacte con Soporte");
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