<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('ValidaLoginScript.php');
include_once('ParametrosClass.php');
$mailRepetido = 0;  // no repetido, de momento, (email_cliente+id_curso+fecha_mail+tipomensaje)
$NumeroDeMails = 0; // anotaremos la solicitud si son menos de 20 al dia, para evitar saturaciones por repeticion
$id_solicitud = 0;
$FormatMaestros = "SELECT id
                    FROM  vtsolicitudes
                   WHERE  RTRIM(LOWER(email_cliente)) =   RTRIM(LOWER('%s'))
                     and  id_curso      =   %d    
                     and  fecha_mail    =  '%s'
					           and  tipomensaje   =  '%s' ";
$queMaestros = sprintf($FormatMaestros,$_POST['CBemail'], $_POST['NumIdCurso'], date("Y-m-d"), $_POST['tipomensaje']);

$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	$NumeroDeMails = $totMaestros;
	$mailRepetido = 1;   //.................ya ha enviado el mail antes
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		 $id_solicitud = $rowVTMaestros['id'];
	 }	
}
 mysqli_free_result($resMaestros);
 
if ($NumeroDeMails < 20) {
CompruebaDatosSolicitud($conexion);
$FormatMaestros = "insert into vtsolicitudes (id_curso,lotedecursos, importe, fecha_mail, tipomensaje, email_cliente,  email_receptor, agente_inscriptor,repeticiones_intentos)
values (%d, '%s','%d','%s','%s','%s','%s','%s',1) ";
$queMaestros = sprintf($FormatMaestros, $_POST['NumIdCurso'],$_POST['NumIdCurso'],$_POST['precio'],date("Y-m-d"), $_POST['tipomensaje'], $_POST['CBemail'], $_POST['mailemisor'],$_POST['agente']);

} else {
	$FormatMaestros = "
	UPDATE vtsolicitudes SET
	repeticiones_intentos = repeticiones_intentos +1
	where id  =  %d
	";
   $queMaestros = sprintf($FormatMaestros, $id_solicitud); 	   
}
 //..........ejecutar query                                                                                                        
 $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                         
 mysqli_free_result($resMaestros); 
 //...................................ENVIAR MAIL SI REPETICIÓN = 0 Y CONFIGURACIÓN LO PERMITE
 $escribirAOrganizador = 0;
 $FormatMaestros = "SELECT recibir_mail_intentos_pago
                   FROM vtparametros
				 ";
$queMaestros = sprintf($FormatMaestros);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                        
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	
	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
		 $escribirAOrganizador = $rowVTMaestros['recibir_mail_intentos_pago'];
	 }	
}
 mysqli_free_result($resMaestros);
 
 //.....................................
 if ($mailRepetido == 0 &&  $escribirAOrganizador > 0) {
	$titulocorreo  = $_REQUEST["tipomensaje"].':  '.$_REQUEST["CBemail"]."\n\n";
    $cuerpoComercial = "=== SOLICITANTE  ===================================================\n";
    $cuerpoComercial .= "EMAIL: ".$_REQUEST["CBemail"]."\n";
    $cuerpoComercial .= "=== VIDEOTUTORIAL  ================================================\n";
    $cuerpoComercial .= "TÍTULO: ".$_REQUEST["NumIdCurso"].'-'.$_REQUEST["tituloCurso"]."\n";
    $cuerpoComercial .= "===================================================================\n\n";
    $cuerpoComercial .= "El cliente intenta comprar. Mira la tabla de solicitudes\n";
		
	mail($_POST['mailemisor'],$titulocorreo,$cuerpoComercial);                     
 } 
echo "OK";
?>