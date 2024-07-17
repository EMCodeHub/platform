<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$salida = "ERROR";
$FormatMaestros = "insert into vtsolcobro (f_emision, email_destino, importe, moneda, concepto, descripcion) values ('%s','%s',%d,'%s','%s','%s') ";
$queMaestros = sprintf($FormatMaestros, $_POST['f_emision'],$_POST['email'],$_POST['importe'],$_POST['moneda'],$_POST['concepto'],$_POST['descripcion']);                                                                                                       
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
mysqli_free_result($resMaestros); 


//....averiguar id del alta
    $FormatUltimaId = "SELECT max(id) AS ULTIMAID FROM vtsolcobro";
    $queUltimaId = $FormatUltimaId;
    $resUltimaId = mysqli_query($conexion, $queUltimaId) or die(mysqli_error($conexion));  
    $totUltimaId = mysqli_num_rows($resUltimaId);     
	   while ($rowUltimaId = mysqli_fetch_assoc($resUltimaId)) {
		  $salida = $rowUltimaId['ULTIMAID']; 	 	         
	   }
    mysqli_free_result($resUltimaId);
echo $salida;
?>