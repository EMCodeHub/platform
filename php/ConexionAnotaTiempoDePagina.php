<?php
session_start();
include_once('../conexion/conn_bbdd.php');
 
 //echo "<br />@@FicheroDeSesiones-->".$_SESSION['FicheroDeSesiones'];
 
 //echo "<br />@@FicheroDeSesiones length-->".$_SESSION['FicheroDeSesiones'].length;
 //echo "<br />@@id registro-->".$_SESSION['Id_FicheroDeSesiones'];
 
 
 if ($_SESSION['FicheroDeSesiones'] == ""  || $_SESSION['Id_FicheroDeSesiones'] == 0 ) {
 	//echo "<br />@@Nos vamos sin grabar";
 	exit;
 }
 $FormatMaestros = "UPDATE  ".$_SESSION['FicheroDeSesiones']." set  tiempo_segundos = %d where id = %d";
 $queMaestros = sprintf($FormatMaestros, $_REQUEST['segundos'], $_SESSION['Id_FicheroDeSesiones']);
  
  //echo "<br />@@ queMaestros-->".$queMaestros;
  
  
  
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
 mysqli_free_result($resMaestros);
 
?>