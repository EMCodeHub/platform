<?php
session_start();
include_once('../conexion/conn_bbdd.php');

$correoEnviado = 0;
  $FormatVTavisos =    "SELECT max(fecha_aviso) as dia
                        FROM   vtavisoalumno
					    WHERE  id_alumno = %d";
   $queVTavisos = sprintf($FormatVTavisos, $_SESSION['NumeroUsuario']); 
   $resVTavisos = mysqli_query($conexion, $queVTavisos) or die(mysqli_error($conexion));
   $totVTavisos = mysqli_num_rows($resVTavisos);
   if ($totVTavisos > 0) {  
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTavisos)) {
		 if ($rowRegistros['dia'] >=  date("Y-m-d")) {
             $correoEnviado = 1;
		 }
   	 }
    }
  mysqli_free_result($resVTavisos);	
if ($correoEnviado > 0 ) {
    echo "OK";
	return; 
}
$FormatMaestros = "insert into vtavisoalumno (id_alumno, fecha_aviso)
values (%d,'%s') ";
$queMaestros = sprintf($FormatMaestros, $_SESSION['NumeroUsuario'],date("Y-m-d"));
 //..........ejecutar query                                                                                                        
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
 mysqli_free_result($resMaestros); 
echo "OK";
?>