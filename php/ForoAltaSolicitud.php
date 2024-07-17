<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
// FUNCIONES: ....................
function ExisteSolicitud($mail,$conexion) {
	$FormatMaestros = "SELECT id 
	                   FROM forosolicitudes
	                   WHERE email = '%s'";	                   
    $queMaestros = sprintf($FormatMaestros, trim($mail));
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 return true;
     }			 				
     return false; 
}
//.......................................................
function AltaSolicitud($conexion) {
  $nombre       = $_POST['nombre'];
  $descripcion  = $_POST['descripcion'];
  $email        = trim(strtolower($_POST['email']));
  $palabra      = $_POST['palabra'];
  $Numero_Alta = 0;
  $ip = getRealIP();	
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
  $pais =  $geoplugin['geoplugin_countryCode']."-".$geoplugin['geoplugin_countryName'];
  $ciudad = $geoplugin['geoplugin_city'];
  $FormatMaestros = "INSERT INTO forosolicitudes 
                                (`id`, `email`, `alias`,`descripción`,`pwd`,`fecha_alta`,`ip`,`pais`,`ciudad`) 
                         VALUES (NULL,'%s','%s','%s','%s', CURRENT_TIMESTAMP,'%s','%s','%s');";
$queMaestros = sprintf($FormatMaestros, $email, $nombre, $descripcion,$palabra,$ip,$pais,$ciudad);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 
return true;  	
}
		  
//........Si ya existe como alumno..............................
if (ExisteMailUsuario($_POST['email'],$conexion) > 0) {
    echo "Ya eres usuario del Foro";
    exit;
}
//........Si ya tiene solicitud-->vtforosolicitud   ..............................
if (ExisteSolicitud($_POST['email'],$conexion) == true) {
    echo "OK";
    exit;
} else {
    if (AltaSolicitud($conexion)) {
       echo "OK"; 
    } else {
       echo "ERROR insertando el alta";
    }
}
?>