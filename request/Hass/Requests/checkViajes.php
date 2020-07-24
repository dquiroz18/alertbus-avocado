<?php 
	
	require 'conexion.php';

	$return_viajes = array();

	$usuario = $_POST['usuario'];
	$viajes = $_POST['viajes'];
	
	$usuario = json_decode($usuario, true);
	$viajes = json_decode($viajes, true);
	
	$user = $usuario['user'];
	$password = $usuario['password'];
/*
	$sql = "SELECT idUsuarioMovil, idInspector 
			FROM UsuarioMovil 
			WHERE nombreUsuario = '$user' AND passwordUsuario = '$password'";

	$resultado = sqlsrv_query($conexion, $sql);


	$row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC);


	$idUser = $row['idUsuarioMovil'];
	$idInspector = $row['idInspector'];
*/
//Log de la data que  se  recibio
setlocale(LC_TIME,"es_ES");
$nameProcess="chechViajes";
$jsonProcess=$viajes;
$path=$nameProcess.".txt";
$archivo = fopen($path, "a+");
	fwrite($archivo, PHP_EOL." </br> ");
	fwrite($archivo, PHP_EOL."************************************************************************************************************************************");
	fwrite($archivo, PHP_EOL."************************************************************************************************************************************");
	fwrite($archivo, PHP_EOL."<Agrego ".$nameProcess." ------>".strftime("%Y/%m/%d _____ %A a las %H:%M"));
	fwrite($archivo, PHP_EOL."==========================================================");
	fwrite($archivo, PHP_EOL."usuario=".json_encode($usuario));
	fwrite($archivo, PHP_EOL.$nameProcess."=".json_encode($jsonProcess));
fclose($archivo);
//fin de Log
	$return_viajes = array();

	for ($i=0; $i < count($viajes); $i++) {

		$fila = $viajes[$i];

		$idWeb = $fila['idWeb'];
		$comentario = utf8_decode($fila['comentario']);
		$hConfirmado = $fila['hConfirmado'];
		$userName = $usuario['user'];
		
		$sql = "EXEC AlertBus_MOVIL_SPU_ConfirmarViaje $idWeb , '$comentario','$hConfirmado' , '$userName'";

		$resultado = sqlsrv_query($conexion, $sql);//consultando

		$row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC);//obteniendo filas

		array_push($return_viajes,array("id"=>$fila['id'],"idWeb"=>$idWeb ));
		
	}

	if (count($return_viajes) == 0) {
		$res = json_encode(array("success" => 0));
	}
	else{
		$res = json_encode(array("success" => 1 , "data" => $return_viajes));
	}


	$archivo = fopen($path, "a+");
	fwrite($archivo, PHP_EOL."RESP=".$res);
	fwrite($archivo, PHP_EOL."************************************************************************************************************************************");
	fwrite($archivo, PHP_EOL."************************************************************************************************************************************");
	
	echo $res;
fclose($archivo);

?>