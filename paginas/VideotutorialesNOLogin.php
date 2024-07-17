<?php 
session_start();
include_once('../conexion/conn_bbdd.php');

$FormatMaestros = "UPDATE vtsesiones 
                      SET `fecha_fin` = CURRENT_TIMESTAMP
				           WHERE id  = %d;";

$queMaestros = sprintf($FormatMaestros, $_SESSION['NumeroSesion']);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 

  $_SESSION['ver_curso'] = 0;
  $_SESSION['NumeroSesion'] = 0;                                              
	$_SESSION['NumeroUsuario'] = 0;                                           
	$_SESSION['es_admin'] = 0;                                             
	$_SESSION['es_colaborador'] = 0;                                          
	$_SESSION['permisos'] = array();                                               
	$_SESSION['TipoAlumno'] = 1;                                          
	$_SESSION['LeadNumero'] = 0;                                        
	$_SESSION['FicheroDeSesiones'] = "";                                           
	$_SESSION['Id_FicheroDeSesiones'] = 0;                                          
	$_SESSION['cookieGrabada'] = 0;        
	$_SESSION['LeadRecalculado'] = 0; 
	$COcaducidad = 60 * 60 * 24 * 30 + time(); // en 1  meses
	$COTipo ="L";   
	setcookie("Tipo", $COTipo, $COcaducidad); 
  setcookie("Referencia",1, $COcaducidad); 
    
$destino = 'Location:http://'.$_SERVER['HTTP_HOST'];
header($destino);
exit;

?>
