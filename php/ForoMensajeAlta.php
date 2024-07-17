<?php
include_once('../conexion/conn_bbdd.php');
session_start();
include_once('ForosScript.php');
if (!isset($_SESSION['NumeroUsuario'])) {                                        
	$_SESSION['NumeroUsuario'] = 0;        
}  
if ($_SESSION['NumeroUsuario'] == 0) {                                        
	header("Location: ../Foros/Foro.php");
    exit;       
} 

/*$numero2 = count($_REQUEST);
$tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
$valores2 = array_values($_REQUEST);// obtiene los valores de las varibles


for($i=0;$i<$numero2;$i++){ 
    echo '<BR />'.$tags2[$i]." = ".$valores2[$i]."   "; 
}
*/
if (MensajeCorto($_REQUEST['noise'],25)) {
   echo '<script>alert("Mensaje NO GRABADO: mensaje debe ser MAS largo");</script>';
   $cadena = '../Foros/CuestionForo.php?id='.$_REQUEST['num_cuestion'].'#M'.$_REQUEST['num_mensaje_padre'];
   echo '<script>window.location.href = "'.$cadena .'";</script>';
   exit();
}
/*if (MensajeCensurado($_REQUEST['noise'],$conexion)) {
   echo '<script>alert("Mensaje NO GRABADO: Contiene palabras INADECUADAS");</script>';
   $cadena = '../Foros/CuestionForo.php?id='.$_REQUEST['num_cuestion'].'#M'.$_REQUEST['num_mensaje_padre'];
   echo '<script>window.location.href = "'.$cadena .'";</script>';
   exit(); 
}*/

$ultimo = AltaMensaje($_REQUEST['num_mensaje_padre'],$_REQUEST['num_cuestion'],$conexion);
$cadena = '../Foros/CuestionForo.php?id='.$_REQUEST['num_cuestion'].'#M'.$ultimo;
echo '<script>window.location.href = "'.$cadena .'";</script>';
exit();




?>