<script>
	
	//var centerColumns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
	var table = $('#tableManagment').DataTable({
		"paging": true,
		"row": true,
		"order": [],
		createdRow: function( row ) {
			for (var i = 0; i < centerColumns.length; i++) {
				$(row).find('td:eq('+centerColumns[i]+')').css('text-align', 'center');
			}
		}
	});

	var id = 0;
  $('#tableManagment').on('click', '.edit, .delete', function(){
  	id = $(this).data('id');
  });

  /**
  * @ids_, collection of ids_
  * @route, route attack
  * @method, GET OR POST

  */

  function getModelByParams(params_, route, method_) {
  	var data = [];
		$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

		$.ajax({
			url: route,
			method: method_,
			data: params_,
			async: false,
			success: function(response){
				data = response.data;
			},
			error: function(xmlhttprequest, textstatus, message){
				if (textstatus) {
					data = [];	
				}
			}
		});
		return data;
  }

  function saveModel(data, route, method_) {
  	var status = false;
		$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	    });

		$.ajax({
			url: route,
			method: method_,
			async: false,
			data: data,
			success: function(response){
				status = response;
			},
			error: function(xmlhttprequest, textstatus, message){
				if (textstatus) {
					status = false;
				}
			}
		});
		return status;
  }

  function showMessage(success, message) {
  	$('#alert-message').text(message);
		if (success == '0') {
			$('#alert').find('.alert').removeClass('alert-success');
			$('#alert').find('.alert').addClass('alert-danger');
		}
		else {
			$('#alert').find('.alert').addClass('alert-success');
			$('#alert').find('.alert').removeClass('alert-danger');	
		}
		$('#alert').show();
  }

  function ObjectToArray(obj) {
  	var result = Object.keys(obj).map(function (key) { 
          
        // Using Number() to convert key to number type 
        // Using obj[key] to retrieve key value 
        return [obj[key]]; 
    }); 
    return result;
  }

  var data = [];
  var id = 0;
	/**
	 * @data  is a collections of collection of items
	 * @table  is a DataTable
	 ** @data, they would be ordered like wanna show as columns header.
	 ** 
	*/
	function listarOnTable(columnIDNumber, columnPrincipalName, data, columnsToHide, hasBtnEdit, hasBtnDelete, hasBtnView) {
		table.clear().draw();
		var row = [];
		var auxColumnsToHide = [];
		for (var i = 0; i < data.length; i++) {
			row = ObjectToArray(data[i]);
			if (hasBtnView) {
				row.push('<button type="button" class="btn btn-info view" data-toggle="modal" data-target="#new" data-id="'+row[columnIDNumber]+'"><i class="fa fa-view"></i></button>')
			}
			if (hasBtnEdit) {
				row.push('<button type="button" class="btn btn-warning edit" data-toggle="modal" data-target="#new" data-id="'+row[columnIDNumber]+'"><i class="fa fa-edit"></i></button>')
			}
			if (hasBtnDelete) {
				row.push('<button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#delete" data-id="'+row[columnIDNumber]+'"><i class="fa fa-remove"></i></button>')
			}
			auxColumnsToHide = [];
			for (var x = 0; x < columnsToHide.length; x++) {
				auxColumnsToHide.push(columnsToHide[x]);
			}
			for (var j = 0; j < auxColumnsToHide.length; j++) {
				row.splice(auxColumnsToHide[j], 1);
				if ( (j+1) < auxColumnsToHide.length) {
					for (var h = (j+1); h < auxColumnsToHide.length; h++) {
						auxColumnsToHide[h] = auxColumnsToHide[h] - 1
					}
				}
			}
			table.row.add(row);
		}
		table.draw(false);
	}

	function listarOnSelect(columnIDNumber, columnPrincipalName, data, select) {
		select.html('<option value="0">Seleccione</option>');
		for (var i = 0; i < data.length; i++) {
			var array = ObjectToArray(data[i]);
			select.append('<option value="'+array[columnIDNumber]+'">'+array[columnPrincipalName]+'</option>');
		}
	}

</script>