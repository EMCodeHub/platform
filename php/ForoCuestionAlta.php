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
if (MensajeCorto($_REQUEST['descri_cuestion'],10)) {
   echo '<script>alert("NO GRABADO: Cuestión debe ser MÁS larga");</script>';
   $cadena = '../Foros/TemaForo.php?id='.$_REQUEST['num_tema'];
   echo '<script>window.location.href = "'.$cadena .'";</script>';
   exit();
}
if (MensajeCorto($_REQUEST['noise'],25)) {
   echo '<script>alert("NO GRABADO: Mensaje debe ser MÁS largo");</script>';
   $cadena = '../Foros/TemaForo.php?id='.$_REQUEST['num_tema'];
   echo '<script>window.location.href = "'.$cadena .'";</script>';
   exit();
}
/*if (MensajeCensurado($_REQUEST['descri_cuestion'],$conexion)) {
   echo '<script>alert("Mensaje NO GRABADO: La Cuestión contiene palabras INADECUADAS");</script>';
   $cadena = '../Foros/TemaForo.php?id='.$_REQUEST['num_tema'];
   echo '<script>window.location.href = "'.$cadena .'";</script>';
   exit(); 
}
if (MensajeCensurado($_REQUEST['noise'],$conexion)) {
   echo '<script>alert("Mensaje NO GRABADO: El Mensaje contiene palabras INADECUADAS");</script>';
   $cadena = '../Foros/TemaForo.php?id='.$_REQUEST['num_tema'];
   echo '<script>window.location.href = "'.$cadena .'";</script>';
   exit(); 
}*/

$ultimo = AltaCuestion($_REQUEST['num_tema'],$conexion);
$cadena = '../Foros/CuestionForo.php?id='.$ultimo;
echo '<script>window.location.href = "'.$cadena .'";</script>';
exit();




?>