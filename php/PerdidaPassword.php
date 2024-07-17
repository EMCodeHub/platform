<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$emailCli ="";
$pwdCli ="";
$FormatMaestros = "SELECT id, email, pwd
                   FROM vtalumnos
				   WHERE ( fecha_baja IS NULL OR YEAR(fecha_baja) = 0  OR fecha_baja >= CURDATE())
					 and UPPER(email) = UPPER('%s') ";

$queMaestros = sprintf($FormatMaestros, $_POST['usuario']);

//echo $queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros <  1){
	echo "E-mail no encontrado o permisos caducados";
	exit;
}

 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) { 
	 $emailCli = $rowMaestros['email'];
	 $pwdCli   = $rowMaestros['pwd'];
	 
 }

//..............................................................escribir el mail
$titulocorreo = "Su password";
$cuerpoComercial = "Le informamos su password: ".$pwdCli;
if (mail($emailCli,$titulocorreo,$cuerpoComercial) ) {
	echo "OK";	
} else {
	echo "Error enviando el correo";
}



?>