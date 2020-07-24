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

    $sql = "EXEC AlertBus_MOVIL_SPU_ListarRestricciones $idViaje ";

    $resultado = sqlsrv_query($conexion, $sql);//consultando

    $restriccionesList = array();

    while( $row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC) ) {

        $fila = array(        
            'name'=> $row['RESTRICCION'],
            'descripcion'=> $row['DESCRIPCION']
        );
        array_push($restriccionesList, $fila);
    }

	if (count($restriccionesList) == 0) {
		$res = json_encode(array("success" => 0));
	}
	else{
		$res = json_encode(array("success" => 1 , "data" => $restriccionesList));
    }
    
    echo $res;

?>