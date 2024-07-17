<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ValidaLoginScript.php');
$TipoConexion = "FORMULARIO";

if (ConexionOK(htmlentities(addslashes($_POST['usuario'])),htmlentities(addslashes($_POST["pwd"])),$TipoConexion,$conexion) == "OK") {
	echo "OK";
} else {
	echo "Error en usuario o contraseña o actualizar página para ingresar";
}
?>
