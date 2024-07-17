<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ForosScript.php');
if (!isset($_SESSION['NumeroUsuario'])) {                                        
	$_SESSION['NumeroUsuario'] = 0;        
}  
if ($_SESSION['NumeroUsuario'] == 0) {                                        
    exit();       
} 


 //comprobamos que sea una petición ajax
 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
     
     $entradaNombre = $_FILES['userfile']['name'];
     $NumeroDelAlta = AltaRecurso($conexion);
     $salidaNombre  ="R".str_pad($NumeroDelAlta, 7, "0", STR_PAD_LEFT).$entradaNombre;
     
       if ($entradaNombre && move_uploaded_file($_FILES['userfile']['tmp_name'],"../Foros/Recursos/".$salidaNombre))  {
          sleep(15);//retrasamos la petición 15 segundos
          //echo $file;//devolvemos el nombre del archivo para pintar la imagen
           UpdateaRecurso($NumeroDelAlta,$salidaNombre,$conexion);  
           RecalculaRecursos($conexion);
           echo "OK";
           exit();
       } else {
           BorraRecurso($NumeroDelAlta,$conexion); 
       	   echo "Error en la transmision del recurso";
           exit();
       }  
    
 }else{
 	echo "Se ha producido una excepcon subiendo el recurso, repita el envio";
     throw new Exception("Error Processing Request");   
 } 


//..................................alta del registro en fororecursos, 
//...................................obtenemos el número del alta
//........si se tramsmite bien el fichero entonces updateamos el registro, si va mal, lo borramos

function AltaRecurso($conexion){
    $NumeroRecursoInsertado = 0;
    $FormatAlta = "INSERT INTO forosrecursos (id_forosmensajes, id_alumno, titulo, fecha_alta, fecha_baja, esta_activo)
                         VALUES (%d,%d,'%s','%s','000-00-00',0)";
    
    $queAlta = sprintf($FormatAlta,$_REQUEST['num_mensaje'],$_SESSION['NumeroUsuario'],strip_tags($_REQUEST['titulo_recurso']),date("Y-m-d"));
    //echo "<BR />@@@queTemas AltaRecurso 1-1>".$queAlta;
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    mysqli_free_result($resAlta); 
    //.................................................averiguar ID asignada
    $FormatMensajes = "SELECT max(id) AS ULTIMAID
                       FROM forosrecursos";
    $queMensajes = $FormatMensajes;
    $resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
    $totMensajes = mysqli_num_rows($resMensajes);     
    if ($totMensajes > 0){
	   while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
		  $NumeroRecursoInsertado = $rowMensajes['ULTIMAID']; 	 	         
	   }
    }
    mysqli_free_result($resMensajes); 
    return $NumeroRecursoInsertado;
}

//...................................recoger número del último alta
function UpdateaRecurso($numRecurso,$nombreFichero,$conexion) {
     $FormatAlta = "UPDATE forosrecursos
                       SET ficherorecurso = '%s', esta_activo = 1
                     WHERE id = %d";
    
    $queAlta = sprintf($FormatAlta,$nombreFichero,$numRecurso);
    //echo "<BR />@@@queTemas AltaRecurso 1-1>".$queAlta;
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    mysqli_free_result($resAlta); 
    
}
//...................................recoger número del último alta
function BorraRecurso($numRecurso,$conexion) {
    $FormatAlta = "DELETE FROM forosrecursos WHERE id = %d";
    $queAlta = sprintf($FormatAlta,$numRecurso);
    //echo "<BR />@@@queTemas AltaRecurso 1-1>".$queAlta;
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    mysqli_free_result($resAlta);  
}

//..................................delete de fororecursos, error en transmisión (le hemos dado de alta)
function RecalculaRecursos($conexion) {
$numero= 0;
$FormatTemas = "SELECT count(id) AS CONTADOR
                  FROM forosrecursos
                 WHERE (forosrecursos.fecha_baja IS NULL OR YEAR(forosrecursos.fecha_baja) = 0  OR forosrecursos.fecha_baja >= CURDATE())
                   and forosrecursos.esta_activo = 1 
                   and id_forosmensajes = %d ";
$queTemas = sprintf($FormatTemas,$_REQUEST['num_mensaje']);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$numero = $rowTemas['CONTADOR'];
	}
}
mysqli_free_result($resTemas); 

$FormatTemas = "UPDATE forosmensajes set num_recursos = %d WHERE id= %d";
$queTemas = sprintf($FormatTemas,$numero,$_REQUEST['num_mensaje']);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas); 
    
$FormatTemas = "UPDATE vtalumnos set mensajes_foro = mensajes_foro +1  WHERE id= %d";
$queTemas = sprintf($FormatTemas,$_SESSION['NumeroUsuario']);   
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas);   
  
    
}

    //.......................................actualizar numero de mensajes
    //ActualizaNumMensajes($numCuestion,$conexion);

?>