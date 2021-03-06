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
	               <span class="active">Transportista</span>
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
		        		<h3>Listado de Transportistas</h3>
		        		<div class="row">
		        			<div class="col-sm-2">
		        				<br>
										<button type="button" id="buscar" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
		        			</div>
		        			<div class="clearfix"></div>
		        			<!-- 
		        				<div class="col-sm-4" id="showNewProveedor">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Transportista</button>
		        			</div>
		        			 -->
		        			
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                	<th>Codigo</th>
				                    <th>RUC</th>
				                    <th>Razón Social</th>
				                    <!-- 
				                    	<th width="80px">Ver/Editar</th>
				                    <th width="80px">Eliminar</th>
				                     -->
				                    
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
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Transportista</h3>
	      </div>
	      <form>
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar el Transportista?
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
	       	<h3 class="modal-title" style="font-weight: bold;">Datos del Transportista</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form>
	      		<input type="hidden" name="id" id="txtIdN">
	      		<div class="row">
		            <div class="form-group col-sm-4">
		              <label for="txtRuc">RUC</label>
		              <input type="number" class="form-control" id="txtRuc" maxlength="11" max="99999999999" name="ruc" required>
		            </div>
		            <div class="form-group col-sm-8">
		            	<label>Razón Social</label>
		            	<input type="text" name="descripcion" id="txtNombre" class="form-control" maxlength="100" required>
		            </div>
		      	</div>
		      	<div class="row" style="display: none;">
		            <div class="form-group col-sm-4">
		              <label for="txtDocumentNumber">Código</label>
		              <input type="text" class="form-control" id="txtCodigo" maxlength="12" name="codigo">
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
		var centerColumns = [0, 1];
	</script>
	<?php echo $__env->make('helpers.dataManagment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
		$('#txtRuc').keyup(function() {
			var string = $(this).val();
			if (string.length > 11) {
				var forcedString = string.substr(0, 11);
				$(this).val(forcedString);
			}
		});
		$('#buscar').click(function() {
	  	var o_id = $(this).parent().prev().find('select').val();
	  	data = getModelByParams({}, "<?php echo e(url('mantenimiento/proveedores/listar')); ?>", 'GET');
	  	listarOnTable(0, 2, data, [0], false, false, false);
	  });

		$('#new').on('show.bs.modal', function() {
			if (id != 0) {
				var model = getModelByParams({idProveedor: id}, "<?php echo e(url('mantenimiento/proveedor')); ?>", 'GET');
				$('#txtRuc').val(model.numeroRuc);
				$('#txtCodigo').val(model.codigoProveedor);
				$('#txtNombre').val(model.razonSocial);
				$('#txtIdN').val(model.idProveedor);
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
	  		alert('Seleccione una empresa');
	  		return false;
	  	}
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/proveedor')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#new form').trigger('reset');
				$('#new').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar Transportista. Contacte con Soporte");
				$('#alert').show();
				$('#new').modal('hide');
	  	}
	  });

	  $('#delete form').submit(function(e) {
	  	e.preventDefault();
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/proveedor/delete')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#delete form').trigger('reset');
				$('#delete').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar Transportista. Contacte con Soporte");
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