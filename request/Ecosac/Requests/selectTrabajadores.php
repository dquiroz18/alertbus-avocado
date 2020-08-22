<?php 
	
	require 'conexion.php';

/*
	$usuario = $_POST['usuario'];
	$usuario = json_decode($usuario, true);
    
    
	$user = $usuario['user'];
    $password = $usuario['password'];
*/
    $idViaje = $_POST['idViaje'];

    //$idViaje = 1;

    $sql = "EXEC AlertBus_MOVIL_SPU_ListarTrabajadores $idViaje ";

    $resultado = sqlsrv_query($conexion, $sql);//consultando

    $pasajeros = array();

    while( $row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC) ) {

        $fila = array(        
            'dni'=> $row['NRO_DOCUMENTO'],
            'name'=> $row['TRABAJADOR'],
            'hIngreso'=> $row['HORA_INGRESO'],
            'restriccion'=> $row['RESTRICCION']
        );
        array_push($pasajeros, $fila);
    }

	if (count($pasajeros) == 0) {
		$res = json_encode(array("success" => 0));
	}
	else{
		$res = json_encode(array("success" => 1 , "data" => $pasajeros));
    }
    
    echo $res;

?>