<?php




$conexion = mysqli_connect("localhost", "root", "", "xyx");

//$conexion = mysqli_connect("qth840.xyz.com", "qth844", "Zyp", "qth844");


//mysqli_options($mysqlconn, MYSQLI_INIT_COMMAND, 'SET @@SESSION.sql_mode = NO_ENGINE_SUBSTITUTION');

mysqli_query($conexion,"SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");


$conexion = mysqli_connect("localhost", "root", "", "xyx");



mysqli_set_charset ( $conexion , 'utf8' );
?>