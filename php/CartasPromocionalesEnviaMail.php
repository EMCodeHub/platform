<?php
session_start();
include_once('../conexion/conn_bbdd.php');
//require_once('CartasPromocionalesSeleccionarScript.php');
require_once('CartasPromocionalesEnviaMailScript.php');

echo EnviaMail($_REQUEST["asunto"], $_REQUEST["idAlumno"], $_REQUEST["afegirNom"], $_REQUEST['idCarta'],$_REQUEST['bodyCarta'] ,$conexion);

?>
