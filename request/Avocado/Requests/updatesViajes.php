<?php 

require_once 'conexion.php';
$usuario = json_decode($_POST['usuario'], true);
$viajes = json_decode($_POST['viajes'], true);

$idsViajes = "";


    //echo var_dump($viajes);



for ($i = 0; $i < sizeof($viajes) ; $i++) {
    $viaje = $viajes[$i];
    $idsViajes = "".$idsViajes.$viaje['id'];
    if(sizeof($viajes)-1 != $i){
        $idsViajes = "".$idsViajes.",";
    }
}


$idUsuario = $usuario['id'];
$sql = "EXEC AlertBus_MOVIL_SPU_VerificarViajesProgramados '$idsViajes' , $idUsuario";

$resultado = sqlsrv_query($conexion, $sql);

$viajes = array();
$payload = array();

while( $row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC) ) {

    $fila = array(        
        'id'=> $row['ID'],
        'horaInicio'=> $row['HORA_INICIO'],
        'empresa'=> utf8_encode($row['EMPRESA']),
        'proveedor'=> utf8_encode($row['PROVEEDOR']),
        'conductor'=> utf8_encode($row['CONDUCTOR']),
        'tipoVehiculo'=> utf8_encode($row['TIPO_VEHICULO']),
        'placa'=> utf8_encode($row['PLACA']),
        'ruta'=> utf8_encode($row['RUTA']),
        'tipoTarifa'=> utf8_encode($row['TIPO_TARIFA']),
        'capacidad'=> $row['CAPACIDAD'],
        'restricciones'=> $row['RESTRICCIONES'],
        'deleted'=> $row['DELETED'],
        'updated'=> $row['UPDATED']
    );

    array_push($viajes, $fila);
}

if (count($viajes) > 0) {
	$user_data['success'] = 1;
    $user_data['viajes'] = $viajes;
}
else {
	$user_data['success'] = 0;
}

$payload = json_encode($user_data);
echo $payload;

?>