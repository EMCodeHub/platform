<?php
/* <a href="descarga.php?archivo=imagen5.jpeg" >Descargar imagen</a> */
/* SOLO  SE TRATAN TEMAS Y RECURSOS, LOS VIDEOS DEBEN LLAMAR A OTRO PHP, NO AL DE DESCARGA*/
session_start();
include_once('../conexion/conn_bbdd.php');
if (!isset($_SESSION['NumeroUsuario'])) {                                        
	$_SESSION['NumeroUsuario'] = 0;        
} 
if ($_SESSION['NumeroUsuario'] == 0) {
  exit();  
}

  	$carpetaRecurso = "../Foros/Recursos/";
   	$archivo = "";
	  $FormatArchivo = "SELECT  ficherorecurso
		                  FROM forosrecursos
				          WHERE id = %d ";
	  $queArchivo = sprintf($FormatArchivo, $_REQUEST['id']); 				  

      $resArchivo = mysqli_query($conexion, $queArchivo) or die(mysqli_error($conexion));
      $totArchivo = mysqli_num_rows($resArchivo);
   
   if ($totArchivo> 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resArchivo)) {
   	 	$archivo = $rowRegistros['ficherorecurso'];
   	 }
   }
mysqli_free_result($resArchivo);
$archivo = basename($archivo);
$ruta = $carpetaRecurso.$archivo;

if (is_file($ruta)) {
   //set_time_limit( 120);
   header('Content-Type: application/force-download');
   //header('Content-Disposition: attachment; filename='.$archivo);
   header('Content-Disposition: attachment; filename= "'.$archivo.'"');
   header('Content-Transfer-Encoding: binary');
   header('Content-Length: '.filesize($ruta));
   ob_clean();
   readfile($ruta);
      exit; 

} else {
   echo "NO EXISTE LA RUTA";
   exit();
}
?>