<?php 

require_once 'conexion.php';
$dni = $_POST['dni'];
$sql = "EXEC AlertBus_MOVIL_SPU_BuscarTrabajador '$dni'";



$resultado = sqlsrv_query($conexion, $sql);


$trabajador;

$payload = array();
if($resultado != false){

while( $row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC) ) {

    $trabajador = $row;
    /*
    array(        
        'dni'=> $row['NRO_DOCUMENTO'],
        'nombre'=> utf8_encode($row['TRABAJADOR']),
        'estado'=> utf8_encode($row['SUSPENCION'])
    );
    */

}
}
if (isset( $trabajador) ) {
	$user_data['success'] = 1;
    $user_data['trabajador'] = $trabajador;
}
else {
	$user_data['success'] = 0;
}

$payload = json_encode($user_data);
echo $payload;

?>