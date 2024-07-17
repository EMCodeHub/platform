<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>VERIFICAR Anoteciones en vtusovideo</title>



</head>
<body>
<?php
include_once('../conexion/conn_bbdd.php');
session_start();

if (!isset($_REQUEST['Borrar'])) {                                       
	$_REQUEST['Borrar'] = 0;              
}
//.......................................................................................
function CalculaVideosCurso($curso,$conexion){
  $Array_Devolver = array();
  $FormatArray = "SELECT  vtcurmodbloqvideo.id AS ID_NUM, titulo_video
  FROM  vtcurmodbloqvideo, vtcurmodbloque, vtcursomodulo, vtcursos
 WHERE  vtcurmodbloqvideo.id_vtcurmodbloque = vtcurmodbloque.id_bloque
   and  vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
   and  vtcursomodulo.id_vtcurso = vtcursos.id_curso
   and  vtcursos.esta_activo > 0
   and  vtcursomodulo.esta_activo > 0
   and  vtcurmodbloque.esta_activo > 0
   and  vtcurmodbloqvideo.esta_activo > 0
   and  vtcursos.id_curso = %d
   ORDER BY ID_NUM";
    $queArray = sprintf($FormatArray, $curso);		
    $resArray = mysqli_query($conexion, $queArray) or die(mysqli_error($conexion));                                                     
    $totArray = mysqli_num_rows($resArray);  	
	if ($totArray > 0){
     	 while ($rowArray = mysqli_fetch_assoc($resArray)) {
     	 	$curso = $rowArray['ID_NUM'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resArray); 
     } 
	return $Array_Devolver;
}
//........................................................................................

function ProcesaUsoVideo($conexion){
    $ArrayVideosDelCurso = array();
	$FormatMaestros = "SELECT DISTINCT id_curso, id_recurso
	                   FROM vtusovideo
	                   ORDER BY id_curso, id_recurso	
                  	";
    $queMaestros = $FormatMaestros;
    
    echo "<bt />@@@ ---ProcesaUsoVideo()--->".$queMaestros;
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
		$numCurso = 0;
		$control = 0;
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
	    	$numCurso = $rowMaestros['id_curso'];
			$numVideo = $rowMaestros['id_recurso'];
     	 	if ($control != $numCurso) {
     	 		//........................................Recalculo el array
				echo "<br/>@@@id_curso-->".$numCurso."  VIDEOS:";
				$ArrayVideosDelCurso = CalculaVideosCurso($numCurso,$conexion);
				echo count($ArrayVideosDelCurso);
				echo "<br/> Numero de videos ".count($ArrayVideosDelCurso)."--->";
	            for($i=0; $i < count($ArrayVideosDelCurso); $i++) {
		           echo $ArrayVideosDelCurso[$i]." , ";
	            }
     	 	}
			if (ExisteRecurso($ArrayVideosDelCurso,$numVideo,$conexion) == false) {
				//echo "<br/>@@@ Curso -->".$numCurso."  Video Número --->".$numVideo;
				echo ImprimeREgistros($numCurso, $numVideo, $conexion);
			}
     	 	$control = $rowMaestros['id_curso']; 	 	
     	 }
     }
	 
echo "<br />@@@ Proceso ACABADO <br/><br/>";	 
mysqli_free_result($resMaestros);
	
	
}
//.................................................................
function ImprimeREgistros($numCurso, $numVideo, $conexion) {
 $FormatArray = "SELECT  vtusovideo.id, vtusovideo.id_curso, vtusovideo.id_recurso, vtusovideo.fecha, email
                   FROM  vtusovideo, vtsesiones, vtalumnos
				  WHERE  vtsesiones.id = vtusovideo.id_sesion
				    and  vtsesiones.id_alumno = vtalumnos.id
                    and  vtusovideo.id_curso = %d
					and  vtusovideo.id_recurso = %d
					ORDER BY id";
    $queArray = sprintf($FormatArray, $numCurso, $numVideo);
	//echo "<br />@@@--ImprimeREgistros-->".$queArray;
			
    $resArray = mysqli_query($conexion, $queArray) or die(mysqli_error($conexion));                                                     
    $totArray = mysqli_num_rows($resArray);  
	//echo "--Número Registros Afectados-->".$totArray;
	if ($totArray > 0){
     	 while ($rowArray = mysqli_fetch_assoc($resArray)) {
			echo "<br >Registro: ".$rowArray['id']."   Curso: ".$rowArray['id_curso']."   Recurso: ".$rowArray['id_recurso']."   Fecha: ".$rowArray['fecha']."  ".$rowArray['email'];
			 
			if ($_REQUEST['Borrar'] == 1) {
			   BorraElRegistro($rowArray['id'],$conexion);
			}
		 }                                                       
     mysqli_free_result($resArray); 
     } 
	 echo "<br />";
}
//...............................................
function BorraElRegistro($Pid,$conexion) {
 $FormatFichero = "DELETE  
                     FROM vtusovideo
                     WHERE id = %d";
    $queFichero = sprintf($FormatFichero, $Pid);		
    $resFichero = mysqli_query($conexion, $queFichero) or die(mysqli_error($conexion));                                                     
    mysqli_free_result($resFichero); 
    echo "<br />BORRADO FINAL ....>".$Pid;
}

//...............................................
function ExisteRecurso($PArrayVideosDelCurso,$numCurso,$conexion) {
	$longitud = count($PArrayVideosDelCurso);
	for($i=0; $i < $longitud; $i++) {
		if ($PArrayVideosDelCurso [$i] == $numCurso) {
			return true;
		}
	}
	return false;	
}
//...............................................
?>

	   <br />
	   Has llegado al body de VERIFICAR Anoteciones en vtusovideo version 2
       
       <br />El parámetro---->Borrar: <?php echo $_REQUEST['Borrar']."#" ?>;
		<br />	<br />
		<?php ProcesaUsoVideo($conexion)  ?>
         <br /><br />
        <?php
        if ($_REQUEST['Borrar'] == 1) {
			echo "<br >...............................................REGISTROS BORRADOS";
		} else {
		   echo "<br >.....INFORME PARAMETRO Borrar=1....para limpiar registros (Proceso actual-->NO borrado)";
		}
		?>

<br/>

</body>
</html>