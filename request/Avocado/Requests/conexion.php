<?php
	
  /* Conectarse a la Base de datos*/
	$server_name = "35.167.15.182";
  	$database = "AlertBusAvocado";
  	$user = "delicatesse";
  	$password = "p4yf00d";

    $connectionInfo = array("Database"=>$database, "UID"=>$user, "PWD"=>$password);

	$conexion = sqlsrv_connect($server_name, $connectionInfo);

	if( $conexion === false ) {
        die(print_r(sqlsrv_errors(),true));
    }

    //http://php.net/manual/es/function.sqlsrv-fetch-array.php

?>