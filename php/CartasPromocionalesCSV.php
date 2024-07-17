<!doctype html>
<html lang="es">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?php
session_start();

if ($_SESSION['es_admin'] != 1 ) {
     //header("Location: ../index.php");
     //exit;
}

include_once('../conexion/conn_bbdd.php');
$fichero = "../CSVFicheros/".$_REQUEST['salida'];
	
$file = fopen($fichero, "w");	
    $FormatMaestros = "SELECT email,nombre
                         FROM vtcartasregistros, vtalumnos
                        WHERE vtcartasregistros.id_alumno = vtalumnos.id
                          AND vtcartasregistros.f_envio is NULL";

   $queMaestros = sprintf($FormatMaestros); 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
if ($totMaestros < 1) {
	echo "ERROR: No hay pendientes";
    exit;
}
 fwrite($file, "EMAILS PENDIENTES;NOMBRE" . PHP_EOL);
	while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
      $lineaSalida =  $rowRegistros['email'].";";
	  $lineaSalida .=  $rowRegistros['nombre'].";";
      fwrite($file, $lineaSalida . PHP_EOL);
    }
 fclose($file);
 mysqli_free_result($resMaestros);
	
 $FormatMaestros = "UPDATE vtcartasregistros
                       SET f_envio = CURDATE()
                     WHERE f_envio is NULL";

   $queMaestros = sprintf($FormatMaestros); 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));	
	mysqli_free_result($resMaestros);
	
?>
</html>