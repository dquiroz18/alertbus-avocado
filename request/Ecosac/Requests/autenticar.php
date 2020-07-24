<?php

require_once 'conexion.php';

if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
}
else {
	exit();
}

$sql = "EXEC AlertBus_MOVIL_SPU_Autenticacion '$usuario', '$password'";

$resultado = sqlsrv_query($conexion, $sql);
 
$user_data = array('success' => 0, 'login' => array() );   

$count_user_data = 0;

$login = array();

while( $row = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC) ) {
    $count_user_data++;
    $fila = array(        
        'id'=> $row['ID'],// id usuario movil
        'user'=> utf8_encode($row['USUARIO']),
        'idSupervisor'=> utf8_encode($row['ID_SUPERVISOR']),//id ya sea vigilante o conductor
        'name'=> utf8_encode($row['FULL_NAME']),
        'typeUser'=> utf8_encode($row['TIPO_USUARIO'])
    
    );

    array_push($login, $fila);
}

if ($count_user_data > 0) {
	$user_data['success'] = 1;
    $user_data['login'] = $login;
    $payload = json_encode($user_data);
}
else {
	$payload = json_encode($user_data);
}

sqlsrv_close($conexion);

echo $payload;

?>