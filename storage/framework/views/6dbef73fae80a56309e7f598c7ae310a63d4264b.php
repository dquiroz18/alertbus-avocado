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
	               <span>Seguridad</span>
	               <span> >> </span>
	               <span class="active">Usuario Movil</span>
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
		        		<h3>Listado de Usuario Movil</h3>
		        		<div class="row">
		        			<div class="col-sm-2">
		        				<br>
								<button type="button" id="buscar" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
		        			</div>
		        			<div class="clearfix"></div>
		        			<div class="col-sm-4" id="showNewUWeb">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Usuario</button>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tbl_data">
				            <thead>
				                <tr>
				                	<th width="150px">Usuario</th>
				                	<th width="300px">Conductor</th>
				                    <th width="80px">Editar</th>
				                    <th width="80px">Desactivar/Activar</th>
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
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Desactivar Usuario</h3>
	      </div>
	      <form id="frm_delete">
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿ Desea Desactivar el Usuario ?
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" id="btn-delete" class="btn btn-danger">Desactivar</button>
	       </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- delete U Web -->
	<div class="modal fade" tabindex="-1" role="dialog" id="restaurar">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="color: green; font-weight: bold;">Activar Usuario</h3>
	      </div>
	      <form id="frm_restaurar">
	      	<input type="hidden" name="id" id="txtIdR">
	      <div class="modal-body">
	        <p>
	        	¿ Desea Activar el Usuario ?
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" id="btn-restaurar" class="btn btn-success">Activar</button>
	       </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	 <!-- Nuevo U Web -->
	<div class="modal fade" tabindex="-1" role="dialog" id="new">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="font-weight: bold;">Datos del Usuario</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form id="frm_save">
	      		<input type="hidden" name="id" id="txtIdN" value="0">
	      		<div class="row">
	      			<div class="col-sm-12">
	      				<label>Conductor </label>
	      				<input type="text" class="form-control" autocomplete="off" name="nombreTrabajador" id="nombreTrabajador" required>
	      				<div class="suggest-items"></div>
	      				<input type="hidden" name="idConductor" id="idConductor" required>
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
	       	</form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script src="<?php echo e(asset('app/mantenimiento/fundos.js')); ?>"></script>
	<script>
		
		$('#buscar').click(function () {
			listarUsuarios();
		});
		var t = $('#tbl_data').DataTable({
			createdRow: function( row ) {
				$(row).find('td:eq(0)').css('text-align', 'center');
			    $(row).find('td:eq(2)').css('text-align', 'center');
			    $(row).find('td:eq(3)').css('text-align', 'center');
			}
		});
		var lastPage = 0;
		$('#tbl_data').on( 'page.dt', function () {
			var info = t.page.info();
			lastPage = info.page;
		});
		function listarUsuarios() {
			$.ajaxSetup({
		      headers: {
		          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		      }
		    });

			$.ajax({
				url: "<?php echo e(url('usuarios/movil/listar')); ?>",
				method: 'post',
				success: function(response){
					var filas = response.data;
					t.clear().draw();
					for (var i = 0; i < filas.length; i++) {
						var button = '<button type="button" data-toggle="modal" data-target="#delete" class="btn btn-danger delete" data-idusuario="'+filas[i].idUsuarioMovil+'"><i class="fa fa-remove"></i></button>';
						if (filas[i].estado == 0){
							button = '<button type="button" data-toggle="modal" data-target="#restaurar" class="btn btn-success restaurar" data-idusuario="'+filas[i].idUsuarioMovil+'"><i class="fa fa-check"></i></button>'
						}

						t.row.add([
							filas[i].nombreUsuario,
							filas[i].nombreConductor,
							'<button type="button" data-toggle="modal" data-target="#new" class="btn btn-warning edit" data-idusuario="'+filas[i].idUsuarioMovil+'" data-idconductor="'+filas[i].idConductor+'" data-nombretrabajador="'+filas[i].nombreConductor+'" data-usuario="'+filas[i].nombreUsuario+'" ><i class="fa fa-edit"></i></button>',
							button
						]).draw();
						t.page.info();
						t.page(lastPage).draw('page');
					}
				},
				error: function(xmlhttprequest, textstatus, message){
					if (textstatus) {
						fundos = [];	
					}
				}
			});
		}

		
		var idUsuario = 0;
		$('#new').on('show.bs.modal', function () {
			$('.suggest-items').html('');
			var a = $('#txtIdN').val(); 
			if (a == '') {
				$('#frm_save').trigger('reset');
				$('#usuario').val('');	
				$('#password').val('');	
			}
		})
		$('#new').on('hide.bs.modal', function () {
			$('#frm_save').trigger('reset');
			$('#fundo').val('').trigger('change');
			$('#txtIdN').val('');
			$('#password').removeAttr('required');
			$('#password').attr('required', 'required');
		})
	    $('#tbl_data').on('click', '.edit', function(){
	    	$('#txtIdN').val($(this).data('idusuario'));
	    	$('#usuario').val($(this).data('usuario'));
	    	$('#idConductor').val($(this).data('idconductor'));
	    	$('#nombreTrabajador').val($(this).data('nombretrabajador'));
	    	$('#password').removeAttr('required');
	    	$('#password').val('');
	    });

	    $('#tbl_data').on('click', '.delete', function(){
	    	$('#txtIdE').val($(this).data('idusuario'));
	    });
	    $('#tbl_data').on('click', '.restaurar', function(){
	    	$('#txtIdR').val($(this).data('idusuario'));
	    });
	    $('#nombreTrabajador').keyup(function() {
			var string = $(this).val();
			if (string.length >= 3) {
				$.ajaxSetup({
	              headers: {
	                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	              }
	            });

				$.ajax({
					url: "<?php echo e(url('conductor')); ?>" + '/' + string,
					method: 'get',
					success: function(response){
						$('#nombreTrabajador').next('.suggest-items').html('<ul></ul>');
						var conductores = response.conductores;
						for (var i = 0; i < conductores.length; i++) {
							$('#nombreTrabajador').next('.suggest-items').find('ul').append('<li><a href="#" class="suggest" data-id="'+conductores[i].idConductor+'" data-conductor="'+conductores[i].nombreConductor+'">'+conductores[i].nombreConductor+'</a></li>');
						}
					}
				});
			}
		});
		$('.suggest-items').on('click', '.suggest', function (e) {
			e.preventDefault();
			var id = $(this).data('id');
			var conductor = $(this).data('conductor');
			if (conductor) {
				$('#idConductor').val(id);
				$('#nombreTrabajador').val(conductor);
			}
			$('.suggest-items').html('');
		});
	    $('#frm_save').submit(function(e) {
	    	e.preventDefault();	    	
	    	var data = $(this).serialize();
	    	$.ajaxSetup({
		      headers: {
		          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		      }
		    });

			$.ajax({
				url: "<?php echo e(url('usuarios/movil/guardar')); ?>",
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
				url: "<?php echo e(url('usuarios/movil/eliminar')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_message = response.message;
					$('#alert-message').text(rpt_message);
					$('#alert').show();
					$('#delete').modal('hide');
					listarUsuarios()
				},
				error: function(xmlhttprequest, textstatus, message){
					if (textstatus) {
						fundos = [];	
					}
				}
			});
	    });

	    $('#frm_restaurar').submit(function(e) {
	    	e.preventDefault();
	    	var data = $(this).serialize();
	    	$.ajaxSetup({
		      headers: {
		          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		      }
		    });

			$.ajax({
				url: "<?php echo e(url('usuarios/movil/restaurar')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_message = response.message;
					$('#alert-message').text(rpt_message);
					$('#alert').show();
					$('#restaurar').modal('hide');
					listarUsuarios()
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