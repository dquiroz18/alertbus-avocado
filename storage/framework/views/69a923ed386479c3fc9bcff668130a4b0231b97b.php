<?php $__env->startSection('script_header'); ?>
	<script src="<?php echo e(asset('vendors/tinymce/tinymce.min.js')); ?>"></script>
  	<script>var editor = {
  		selector:'#paraderos',
  		language: 'es',
  		encoding: 'UTF-8',
  		entity_encoding: 'raw',
  		menu: {},
  		toolbar: 'undo redo | bullist',
  	}; tinymce.init(editor);</script>
<?php $__env->stopSection(); ?>

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
	               <span class="active">Ruta</span>
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
		        		<h3>Listado de Rutas</h3>
		        		<div class="row">
		        			<div class="col-sm-4" style="display: none;">
		        				<div class="form-group">
		        					<label>Transportista</label>
		        					<select id="cmbTransportista" class="form-control" >
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
		        			<div class="col-sm-4" id="showNewRuta">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Ruta</button>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                    <th width="80px">Código</th>
				                    <th width="200px">Origen</th>
				                    <th width="200px">Destino</th>
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
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Ruta</h3>
	      </div>
	      <form>
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar la Ruta?
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
	       	<h3 class="modal-title" style="font-weight: bold;">Datos de la Ruta</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form>
	      		<input type="hidden" name="id" id="txtIdN">
	      		<div class="row">
	      			<div class="col-sm-4" style="display: none;">
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
		            <div class="form-group col-sm-4">
		              <label for="txtCode">Código</label>
		              <input type="text" class="form-control" id="txtCodigo" maxlength="12" name="codigo" required>
		            </div>
		      	</div>
		      	<div class="row">
		            <div class="form-group col-sm-4">
		              <label for="txtOrigen">Origen</label>
		              <select class="form-control" id="txtOrigen" name="origen">
		              	<option value="0">Seleccione</option>
		              </select>
		            </div>
		            <div class="col-sm-1">
        				<br>
        				<button type="button" class="btn btn-primary" title="Agregar una opcion más" id="addOrigen"><i class="fa fa-plus"></i></button>
        			</div>
		            <div class="form-group col-sm-4">
		              <label for="txtDestino">Destino</label>
		              <select class="form-control" id="txtDestino" name="destino">
		              	<option value="0">Seleccione</option>
		              </select>
		            </div>
		            <div class="col-sm-1">
        				<br>
        				<button type="button" class="btn btn-primary" title="Agregar una opcion más" id="addDestino"><i class="fa fa-plus"></i></button>
        			</div>
		      	</div>
		      	<div class="row">
		      		<div class="form-group col-sm-12">
		      			<label>Descripción Ruta</label>
		      			<textarea name="paraderos" id="paraderos" class="form-control"></textarea>
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
		var centerColumns = [0, 1, 2, 3, 4, 5];
	</script>
	<?php echo $__env->make('helpers.dataManagment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
		$('#addOrigen').click(function() {
			if ($('#cmbTransportistaM').val() !=  null) {
				var origen = prompt("Nuevo Origen: ", "Ejem. Lima");
				if (origen == null) {
					alert("Ingrese un nombre válido");
					return;
				}
				else {
					var encontrado = false;
					for (var i = 0; i < origenes.length; i++) {
						if (origenes[i].origen == origen) {
							encontrado = true;
						}
					}
					if (!encontrado) {
						$('#txtOrigen').append('<option value="'+origen+'">'+origen+'</option>')
						$('#txtOrigen').find('option:last').prop('selected', 'selected');	
					}
					else {
						alert("Ya existe ese origen registrado");
					}
					
				}
			}
			else{
				alert("Seleccione un Transportista");
			}

		});
		$('#addDestino').click(function() {
			var id = $('#cmbTransportistaM').val();
			if (id != null) {
				var destino = prompt("Nuevo Destino: ", "Ejem. Lima");
				if (destino == null) {
					alert("Ingrese un nombre válido");
					return;
				}

				else {
					var encontrado = false;
					for (var i = 0; i < destinos.length; i++) {
						if (destinos[i].destino == destino) {
							encontrado = true;
						}
					}
					if (!encontrado) {
						$('#txtDestino').append('<option value="'+destino+'">'+destino+'</option>')
					$('#txtDestino').find('option:last').prop('selected', 'selected');
					}
					else {
						alert("Ya existe ese destino registrado");
					}
					
				}
			}
			else{
				alert("Seleccione un Transportista");
			}

		});
		$('#buscar').click(function() {
		  	var o_id = $(this).parent().prev().find('select').val();
		  	data = getModelByParams({idProveedor: o_id}, "<?php echo e(url('mantenimiento/rutas/listar')); ?>", 'GET');
		  	listarOnTable(1, 3, data, [0, 1], true, true, false);
		  });
		var origenes = null;
		var destinos = null;
		$('#cmbTransportistaM').change(function() {
			var id = $(this).val();
			$('#txtOrigen').html('<option value="0">Seleccione</option>');
			$('#txtDestino').html('<option value="0">Seleccione</option>');
			origenes = getModelByParams({idTransportista: id}, "<?php echo e(url('mantenimiento/rutas/origenes')); ?>", 'GET');
			select = $('#txtOrigen');
		  	listarOnSelect(0, 0, origenes, select);
		  	destinos = getModelByParams({idTransportista: id}, "<?php echo e(url('mantenimiento/rutas/destinos')); ?>", 'GET');
			select = $('#txtDestino');
		  	listarOnSelect(0, 0, destinos, select);
		});

		$('#new').on('show.bs.modal', function() {
			if (id != 0) {
				var model = getModelByParams({idRuta: id}, "<?php echo e(url('mantenimiento/ruta')); ?>", 'GET');
				$('#cmbTransportistaM').val(model.idProveedor);
				$('#cmbTransportistaM').trigger('change')
				$('#txtCodigo').val(model.codigoRuta);
				$('#txtOrigen').val(model.origen);
				$('#txtDestino').val(model.destino);
				$(tinymce.get('paraderos').getBody()).html(model.paraderos);
				$('#txtIdN').val(model.idRuta);
			}
			else {
				$('#new form').trigger('reset');
				$('#cmbTransportistaM').trigger('change')
				$('#txtIdN').val('');
			}
		});

		$('#delete').on('show.bs.modal', function () {
			$('#txtIdE').val(id);
		})

		$('#new form').submit(function(e) {
		  	e.preventDefault();
		  	/*if ($('#cmbTransportistaM').val() == 0) {
		  		alert('Seleccione un Transportista');
		  		return false;
		  	}*/
		  	if ($('#txtOrigen').val() == 0) {
		  		alert('Seleccione un Origen');
		  		return false;
		  	}
		  	if ($('#txtDestino').val() == 0) {
		  		alert('Seleccione un Destino');
		  		return false;
		  	}
		  	tinyMCE.triggerSave();
		  	var data = $(this).serialize();
		  	//console.log(data);
		  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/ruta')); ?>", 'POST')){
		  		var message = response.message;
		  		var success = response.success;
		  		showMessage(success, message);
		  		$('#buscar').trigger('click');
		  		$('#new form').trigger('reset');
				$('#new').modal('hide');
		  	}
		  	else {
					$('#alert-message').text("Error al guardar Ruta. Contacte con Soporte");
					$('#alert').show();
					$('#new').modal('hide');
		  	}
		  });

	  $('#delete form').submit(function(e) {
	  	e.preventDefault();
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "<?php echo e(url('mantenimiento/ruta/delete')); ?>", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#delete form').trigger('reset');
				$('#delete').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar Ruta. Contacte con Soporte");
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