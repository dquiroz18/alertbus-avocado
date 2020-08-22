<?php 
	
	require 'conexion.php';

	$return_inspeccionEvidencias = array();

	$usuario = $_POST['usuario'];
	$tracking = $_POST['tracking'];

	$usuario = json_decode($usuario, true);
	$tracking = json_decode($tracking, true);

	//Log de la data que  se  recibio
	setlocale(LC_TIME,"es_ES");
	$nameProcess="tracking".$usuario['id'];
	$jsonProcess=$tracking;
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

	for ($i=0; $i < count($tracking); $i++) {

		$fila = $tracking[$i];

		$idConductor = $usuario['id'];
	
		$fecha = $fila['dateTime'];
		$vel = $fila['speed'];
		$bearing = $fila['bearing'];
		$lat = $fila['latitud'];
		$lon = $fila['longitud'];

		
		$sql = "EXEC AlertBus_MOVIL_SPU_InsertarTracking $idConductor , '$fecha' , '$lat', '$lon' , $vel , $bearing";

		sqlsrv_query($conexion, $sql);

	}

	
	$success = 1;

	echo json_encode($success);


?>