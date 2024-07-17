<?php
/* <a href="descarga.php?archivo=imagen5.jpeg" >Descargar imagen</a> */
/* SOLO  SE TRATAN TEMAS Y RECURSOS, LOS VIDEOS DEBEN LLAMAR A OTRO PHP, NO AL DE DESCARGA*/
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/VTSesionesUsoRecursosScript.php');
if (!isset($_SESSION['NumeroCurso'])) { 
  exit;
}


/*$numero2 = count($_REQUEST);
$tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
$valores2 = array_values($_REQUEST);// obtiene los valores de las varibles
for($i=0;$i<$numero2;$i++){ 
    echo $tags2[$i]."=".$valores2[$i]."   "; 
}
*/



$fichero = "";
$imagen  = "";
if ($_REQUEST[tipo] == "T") {
	$fichero = "vtcurmodbloqtema";
	$imagen  = "ficheroPDF";
} else if ($_REQUEST[tipo] == "R") {
  $fichero = "vtcurmodbloqrecurso";
  $imagen  = "nomfic_recurso";
} else {
	echo "Tipo incorrecto";
	exit();
}
//........................................................
InsertaUsoRecurso($_REQUEST[tipo],$_REQUEST['id'],$conexion);
//........................................................
  	$carpetaCurso = "";
   	$archivo = "";

	  $FormatArchivo = "SELECT carpetadeficheros, %s 
                         FROM    vtcursos, vtcursomodulo, vtcurmodbloque,%s
					     WHERE   vtcursomodulo.id_vtcurso = vtcursos.id_curso
					       and   vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
						   and   %s.id_vtcurmodbloque = vtcurmodbloque.id_bloque 
					       and   id = %d";
	  $queArchivo = sprintf($FormatArchivo, $imagen,$fichero,$fichero, $_REQUEST['id']); 				  
				
			
			
			
				// echo 	  $queArchivo;
   
   $resArchivo = mysqli_query($conexion, $queArchivo) or die(mysqli_error($conexion));
   $totArchivo = mysqli_num_rows($resArchivo);
   
   if ($totArchivo> 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resArchivo)) {
   	 	$carpetaCurso = $rowRegistros['carpetadeficheros'];
   	 	$archivo = $rowRegistros[$imagen];
   	 }
   }
mysqli_free_result($resArchivo);


$archivo = basename($archivo);

//echo "<br>Nombre Carpeta-->".$carpetaCurso."   Nombre Fichero-->".$archivo."<br>";


$ruta = "../VIDEOTUTORIALES/".$carpetaCurso."/".$archivo;

//echo "<br>ruta--->".$ruta."<br>";
//.........................................control pirateo ------ enviar aviso de múltiples conexiones o llamar a fichero ---------- PENDIENTE



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