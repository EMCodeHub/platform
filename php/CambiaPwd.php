<?php
session_start();
include_once('../conexion/conn_bbdd.php');
$numeroUsuario = 0;

$FormatMaestros = "SELECT id 
                   FROM vtalumnos
				   WHERE ( fecha_baja IS NULL OR YEAR(fecha_baja) = 0  OR fecha_baja >= CURDATE())
					 and UPPER(email) = UPPER('%s')
					 and pwd   = '%s'";

$queMaestros = sprintf($FormatMaestros, $_POST['usuario'], $_POST["pwd"]);

   //echo $queMaestros;


$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros == 0 ){
	echo "Usuario o contraseña incorrectos";
	exit;
} else {
	while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$numeroUsuario = $rowMaestros['id'];
	}
	
}
 mysqli_free_result($resMaestros); 
 //..................................cambiamos contraseña
 
 $FormatMaestros = "UPDATE  vtalumnos set  pwd = '%s' where id = %d";
 $queMaestros = sprintf($FormatMaestros, $_POST['pwdNew'], $numeroUsuario);
  
  
  //echo $queMaestros;
  
  
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
 mysqli_free_result($resMaestros);
 
 
 //..................................anotamos fecha en que se cambia la contraseña para que el detector de múltiples conexiones seleccione movimientos a partir de esta fecha
 $FormatMaestros = "INSERT into vtcambiopwd (id_alumno,	 fecha_pwd ) values ('%d','%s') ";
 $queMaestros = sprintf($FormatMaestros, $numeroUsuario, date('Y-m-d') );

//echo "<br>@6@".$queMaestros;

 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
 mysqli_free_result($resMaestros);	

 session_destroy();

 echo "OK";

?>