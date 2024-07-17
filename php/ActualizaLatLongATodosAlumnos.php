<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Actualiza Lat Long</title>

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
//.............................................................................
function GrabaLatLong($id,$ip_conex,$conexion) {
	echo "<br />@@@@@@ entramos en GrabaLatLong..........";
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_conex) );
  $Latitud  = $geoplugin['geoplugin_latitude'];
  $Longitud = $geoplugin['geoplugin_longitude'];
  $Ciudad   = $geoplugin['geoplugin_city'];
  echo "<br />@@@@@@ hemos averiguado latitud y longitud..........".$Latitud."   ".$Longitud ;
  $FormatProceso = "UPDATE vtsesiones set 
                           ciudad  = '%s',
						   latitud = %f,
						   longitud = %f
					 WHERE id = %d";
    $queProceso = sprintf($FormatProceso,$Ciudad,$Latitud,$Longitud,$id);
	 echo "<br />@@@@@@11@".$queProceso;
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
	echo "<br />@@@@@@ SALIMOS en GrabaLatLong..........";
}
?>
</head>

<body>
Llego al body<br />
<?php
//...........................inicio de página

	$FormatMaestros = "SELECT id,  ip_conex
                       FROM vtsesiones where LENGTH(ciudad) < 5
					   order by id";
						  
    $queMaestros = $FormatMaestros;		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
	
	  echo "<br />@@@".$queMaestros;                                                      
    $totMaestros = mysqli_num_rows($resMaestros); 
 	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
			  	$id              = $rowMaestros['id'];
		        $ip_conex        = $rowMaestros['ip_conex'];
				GrabaLatLong($id,$ip_conex,$conexion);
     	 }                                                       
  mysqli_free_result($resMaestros); 
  }   


//........................................ inicio págin



  

?>

</body>
</html>