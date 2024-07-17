<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
<script>
	function nada(){
	  a=1;
	}
</script>
<?php

session_start();
$_SESSION['es_admin'] = 1;
$_SESSION['TipoAlumno'] = 1;
include_once('../conexion/conn_bbdd.php');
include_once('ConexionScrip.php'); 
include_once('ValidaLoginScript.php'); 
if ($_SESSION['es_admin'] == 0) {
	exit;
}
?>
</head>

<body>
Llego al body<br />
<?php
//...........................................................................
function GravaNuevoTipo($ID,$conexion){
    $FormatProceso = "UPDATE vtalumnos set 
                             tipoalumno  = %d 
					  WHERE id = %d";
    $queProceso = sprintf($FormatProceso,$_SESSION['TipoAlumno'],$ID);
	 echo "<br />@@@@@@11@".$queProceso;
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
}
//---------------------------------------------------------------------------------------
function ActualizaCiudadTelefono(){
  echo "<br/>@@@@Entro en pagina";
  echo "<br />@@@@@ Antes de la query";
	$FormatMaestros = "SELECT id, pais, ciudad, email, telefono, nombre, apellidos
                       FROM vtalumnos";
						  
    $queMaestros = sprintf($FormatMaestros, $de_pago, $usuario);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
	
	  echo "<br />@@@".$queMaestros;                                                      
    $totMaestros = mysqli_num_rows($resMaestros); 
 	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
			  	$numeroUsuario   = $rowMaestros['id'];
		        $paisFichero     = $rowMaestros['pais'];
		        $ciudadFichero   = $rowMaestros['ciudad'];
		        $email           = $rowMaestros['email'];
		        $telefonoFichero = $rowMaestros['telefono'];
		        $nombreAlumnoFichero = $rowMaestros['nombre'];
		        $apellidosFichero = $rowMaestros['apellidos'];
	            
				$ArrayDatos = ObtenerDatosSolicitud($email,$conexion);
		        if (count($ArrayDatos) > 0) {
			       $ArrayGrabado = ActualizaAlumnoDesdeSolicitud($numeroUsuario,$ArrayDatos,$nombreAlumnoFichero,$apellidosFichero,$ciudadFichero,$telefonoFichero,$conexion);
				                 	  
		        }
     	 	$_SESSION['TipoAlumno'] = 1;
     	 	$ID = $rowMaestros['id'];
     	 	echo "<br /> Alumno-->".$ID;
     	    RecalculaTipoAlumno($ID,$conexion);
     	    echo "<br /> Alumno-->".$ID."    Tipo: ".$_SESSION['TipoAlumno'];
     	    GravaNuevoTipo($ID,$conexion);
     	 }                                                       
  mysqli_free_result($resMaestros); 
  }    
}
//...........................inicio de página
function RecalculaLatLong() {
	$FormatMaestros = "SELECT id,  ip_conex
                       FROM vtsesiones";
						  
    $queMaestros = $FormatMaestros;		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
	
	  echo "<br />@@@".$queMaestros;                                                      
    $totMaestros = mysqli_num_rows($resMaestros); 
 	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
			  	$id              = $rowMaestros['id'];
		        $ip_conex        = $rowMaestros['ip_conex'];
				GrabaLatLong($id,$ip_conex);
     	 }                                                       
  mysqli_free_result($resMaestros); 
  }   
}

//.............................................................................
function GrabaLatLong($id,$ip_conex) {
	echo "<br />@@@@@@ entramos en GrabaLatLong..........";
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_conex) );
  $Latitud  = $geoplugin['geoplugin_latitude'];
  $Longitud = $geoplugin['geoplugin_longitude'];
  $Ciudad   = $geoplugin['geoplugin_city'];
  
  $FormatProceso = "UPDATE vtsesiones set 
                           ciudad  = '%s',
						   latitud = %f,
						   longitud = %f
					 WHERE id = %d";
    $queProceso = sprintf($FormatProceso,$Ciudad,$Latitud,$Longitud,$id);
	 echo "<br />@@@@@@11@".$queProceso;
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
}
//........................................ inicio págin
  echo "<br/>@@@@Entro en pagina";
  echo "<br />@@@@@ Antes de RecalculaLatLong()";
  //ActualizaCiudadTelefono();
  RecalculaLatLong();
  


  

?>

</body>
</html>