<?php 

require_once 'conexion.php';
$usuario = json_decode($_POST['usuario'], true);
$idUsuario = $usuario['id'];
$sql = "EXEC AlertBus_MOVIL_SPU_ListarViajesProgramados $idUsuario";

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