<?php $__env->startSection('main-content'); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.table {
			margin-bottom: 0px !important;
		}
	</style>
	<div>
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Seguridad</span>
	               <span> >> </span>
	               <span class="active">Usuario Web</span>
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
		        		<h3>Listado de Usuario Web</h3>
		        		<div class="row">
		        			<div class="col-sm-4" style="display: none;" >
		        				<div class="form-group">
		        					<label>Transportista</label> <br>
		        					<select id="cmbProveedor" class="form-control" style="width: 100%">
		        						<option value="0">Seleccione</option>
		        						<?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		        							<option value="<?php echo e($proveedor->idProveedor); ?>"><?php echo e($proveedor->razonSocial); ?></option>
		        						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
		        					</select>
		        				</div>
		        			</div>
		        			<div class="col-sm-2">
		        				<br>
								<button type="button" id="buscar" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
		        			</div>
		        			<div class="clearfix"></div>
		        			<div class="col-sm-4" id="showNewU Web">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Usuario</button>
		        			</div>
		        		</div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tbl_data">
				            <thead>
				                <tr>
				                	<th>Usuario</th>
				                    <th>Tipo</th>
				                	<th width="300px">Empresa</th>
				                    <th width="80px">Editar</th>
				                    <th width="80px">Eliminar</th>
				                </tr>
				            </thead>
				        </table>
		        	</div>
		        </div>
			</div>
		</div>
		        
	</div>

	<!-- delete U Web -->
	<div class="modal fade" tabindex="-1" role="dialog" id="delete">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Usuario</h3>
	      </div>
	      <form id="frm_delete">
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿ Desea Eliminar el Usuario ?
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

	 <!-- Nuevo U Web -->

	<form id="frm_save">
	<div class="modal fade" tabindex="-1" role="dialog" id="new">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="font-weight: bold;">Datos del Usuario</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
      		<input type="hidden" name="id" id="txtIdN">
      		<div class="row">
      			<div class="col-sm-4">
	      			<label>Tipo Usuario *</label>
	      			<select name="tipo" id="tipo" class="form-control">
	      				<option value="A">Administrador</option>
	      				<option value="T">Transportista</option>
	      			</select>
	      		</div>
	      		<div class="col-sm-8" id="showCmbEmpresa">
    				<div class="form-group">
    					<label>Empresa</label> <br>
    					<select id="cmbEmpresa" name="empresa[]" class="form-control select2" multiple="multiple" style="width: 100%">
    						<?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    							<option value="<?php echo e($empresa->idEmpresa); ?>"><?php echo e($empresa->razonSocial); ?></option>
    						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
    					</select>
    				</div>
    			</div>
      			<div class="col-sm-8" id="showCmbTransportista" style="display: none;">
    				<div class="form-group">
    					<label>Transportista</label> <br>
    					<select id="cmbProveedor2" name="proveedor" class="form-control" style="width: 100%">
    						<option value="0">Seleccione</option>
    						<?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    							<option value="<?php echo e($proveedor->idProveedor); ?>"><?php echo e($proveedor->razonSocial); ?></option>
    						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
    					</select>
    				</div>
    			</div>
      		</div>
      		<div class="row">
            <div class="form-group col-sm-4">
              <label>Usuario *</label>
              <input type="text" class="form-control" id="usuario" maxlength="12" name="usuario" autocomplete="off" required>
            </div>
            <div class="form-group col-sm-8">
            	<label>Contraseña *</label>
            	<input type="password" name="password" id="password" class="form-control" maxlength="30" autocomplete="off" required>
            </div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        	<button type="submit" id="btn-new" class="btn btn-primary">Guardar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script>
		$('#cmbProveedor').select2();
		$('#cmbProveedor2').select2({
			dropdownParent: $('#new')
		});
		$('#cmbEmpresa').select2();
		function listarUsuarios() {
			$.ajaxSetup({
		      headers: {
		          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		      }
		    });

			$.ajax({
				url: "<?php echo e(url('usuarios/web/listar')); ?>",
				method: 'post',
				success: function(response){
					var filas = response.data;
					t.clear().draw();
					for (var i = 0; i < filas.length; i++) {
						t.row.add([
							filas[i].nombreUsuario,
							filas[i].tipoUsuario,
							filas[i].nombreEmpresa,
							'<button type="button" data-toggle="modal" data-target="#new" class="btn btn-warning edit" data-idusuario="'+filas[i].idUsuarioWeb+'" data-tipo="'+filas[i].tipoUsuario+'" data-usuario="'+filas[i].nombreUsuario+'" data-idempresa="'+filas[i].idEmpresa+'" data-idproveedor="'+filas[i].idProveedor+'"><i class="fa fa-edit"></i></button>',
							'<button type="button" data-toggle="modal" data-target="#delete" class="btn btn-danger delete" data-idusuario="'+filas[i].idUsuarioWeb+'"><i class="fa fa-remove"></i></button>'
						]).draw();
					}
				},
				error: function(xmlhttprequest, textstatus, message){
					if (textstatus) {
						fundos = [];	
					}
				}
			});
		}

		$('#buscar').click(function () {
			listarUsuarios();
		})

		var t = $('#tbl_data').DataTable({
			createdRow: function( row ) {
			    $(row).find('td:eq(0)').css('text-align', 'center');
			    $(row).find('td:eq(1)').css('text-align', 'center');
			    $(row).find('td:eq(2)').css('text-align', 'center');
			    $(row).find('td:eq(4)').css('text-align', 'center');
			    $(row).find('td:eq(5)').css('text-align', 'center');
			    $(row).find('td:eq(6)').css('text-align', 'center');
			}
		});

		var idUsuario = 0;

		$('#new').on('show.bs.modal', function () {
			var a = $('#txtIdN').val(); 
			if (!a) {
				$('#frm_save').trigger('reset');
				$('#usuario').val('');	
				$('#password').val('');	
			}
		});

		$('#new').on('hide.bs.modal', function () {
			$('#frm_save').trigger('reset');
			$('#txtIdN').val('');
			$('#password').removeAttr('required');
			$('#password').attr('required', 'required');
			$('#cmbProveedor2').val('');
			$('#cmbProveedor2').trigger('change');
			$('#cmbEmpresa').val('');
			$('#cmbEmpresa').trigger('change');
		});

    $('#tbl_data').on('click', '.edit', function(){
    	$('#txtIdN').val($(this).data('idusuario'));
    	$('#usuario').val($(this).data('usuario'));
    	$('#tipo').val($(this).data('tipo').substring(0, 1));
    	$('#tipo').trigger('change');
    	$('#cmbProveedor2').val($(this).data('idproveedor'));
    	$('#cmbProveedor2').trigger('change');
    	var fs = $(this).data('idempresa')
    	if(fs != undefined){
	    	var ff = fs;
	    	if (fs.length > 1) {
	    		ff = fs.split('-')	
	    	}
    	}
    	$('#cmbEmpresa').val(ff);
    	$('#cmbEmpresa').trigger('change');
    	$('#password').val('');
    	$('#password').removeAttr('required');
    });

    $('#tbl_data').on('click', '.delete', function(){
    	$('#txtIdE').val($(this).data('idusuario'));
    });

    $('#tipo').change(function () {
    	if($(this).val() == 'A'){
    		$('#cmbProveedor2').val('0');
    		$('#cmbProveedor2').trigger('change');
    		$('#showCmbTransportista').hide();
    		$('#showCmbEmpresa').show();
    		$('#cmbEmpresa').val('');
			$('#cmbEmpresa').trigger('change');
    	}
    	else{
    		$('#cmbEmpresa').val('');
			$('#cmbEmpresa').trigger('change');
    		$('#showCmbEmpresa').hide();
    		$('#showCmbTransportista').show();
    	}
    });

	  $('#frm_save').submit(function(e) {
    	e.preventDefault();
    	if ($('#tipo').val() == 'A') {
    		if ($('#cmbEmpresa').val() == null) {
    			alert("Seleccione una Empresa");
    			return false;
    		}
    	}
    	if ($('#tipo').val() == 'T') {
    		if ($('#cmbProveedor2').val() == '0') {
    			alert("Seleccione un Transportista");
    			return false;
    		}
    	}
    	//return false;
    	var data = $(this).serialize();
    	//alert($('#cmbFundos2').val());
    	//return false;
    	$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	    });

			$.ajax({
				url: "<?php echo e(url('usuarios/web/guardar')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_message = response.message;
					$('#alert-message').text(rpt_message);
					if (response.success=='0') {
						$('#alert').find('.alert').removeClass('alert-success');
						$('#alert').find('.alert').addClass('alert-danger');
					}
					else {
						$('#alert').find('.alert').addClass('alert-success');
						$('#alert').find('.alert').removeClass('alert-danger');	
					}
					$('#alert').show();
					$('#new').modal('hide');
					listarUsuarios();
				},
				error: function(xmlhttprequest, textstatus, message){
					if (textstatus) {
						fundos = [];	
					}
				}
			});
	  });

    $('#frm_delete').submit(function(e) {
    	e.preventDefault();
    	var data = $(this).serialize();
    	$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	    });

			$.ajax({
				url: "<?php echo e(url('usuarios/web/eliminar')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_message = response.message;
					$('#alert-message').text(rpt_message);
					$('#alert').show();
					$('#delete').modal('hide');
					listarUsuarios();
				},
				error: function(xmlhttprequest, textstatus, message){
					if (textstatus) {
						fundos = [];	
					}
				}
			});
	  });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>