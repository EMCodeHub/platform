<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Actividad del cliente</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
session_start();
//...........................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
function NoNull($num) {
	if (is_null($num)) {
	  return "....";
	} else {
	  return $num;
	}
}

//...........................................................................
function RellenaPuntos($txt) {
	$longTexto = strlen($txt);
	$relleno = "";
	if ($longTexto < 60) {
		$relleno = str_repeat(".",60-$longTexto);
		return $txt.$relleno;
	}
	return $txt;
}
//...........................................................................
function RespuestasCheckout($IDOrder,$conexion) {
 $patternEmail = '/\semail=(.*?)\s/s';
 $patternTarjetaProcesasa = '/credit_card_processed=(.*?)zip=/s';
 $patternImporte = '/li_0_price=(.*?)\s/s';
 $patternSolicitud = '/\smerchant_order_id=(.*?)\s/s';



        $cabeceras = '<div class="AccesoCheckGenericoT">ID Checkout</div>';
        $cabeceras .= '<div class="AccesoCheckGenerico2T">Fecha</div>'; 
        $cabeceras .= '<div class="AccesoCheckGenericoT">Proceso Ok</div>'; 
        $cabeceras .= '<div class="AccesoCheckGenericoT">&nbsp;</div>'; 
		$cabeceras .= '<div class="AccesoCheckGenericoObsT">Error</div>';
		$cabeceras .= '<div class="clear"></div>';  

    $devolver = "";
	$FormatrowMvCkeckout = "SELECT DISTINCT (order_number), id, dia,  proceso_ok ,  respuesta, error 
                              FROM vtcheckout
                             WHERE order_number = '%s' ";
   $querowMvCkeckout = sprintf($FormatrowMvCkeckout, $IDOrder);
   $resrowMvCkeckout = mysqli_query($conexion, $querowMvCkeckout) or die(mysqli_error($conexion));                                                        
   $totrowMvCkeckout = mysqli_num_rows($resrowMvCkeckout);     
   if ($totrowMvCkeckout > 0){
      while ($rowrowMvCkeckout= mysqli_fetch_assoc($resrowMvCkeckout)) {			  
	    $devolver .= $cabeceras;   
	    $devolver .= '<div class="AccesoGenerico">'.$rowrowMvCkeckout['id'].'</div>';
        $devolver .= '<div class="AccesoGenerico2">'.$rowrowMvCkeckout['dia'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.$rowrowMvCkeckout['proceso_ok'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">&nbsp;</div>';
        $devolver .= '<div class="AccesoGenericoObs">'.$rowrowMvCkeckout['error'].'</div>'; 
		//$devolver .= '<div class="AccesoGenericoObs">'.$rowrowMvCkeckout['respuesta'].'</div>';
		$devolver .= '<div class="clear"></div>';
		$devolver .= '<div class="AccesoCheckRaya"></div>'; 
		$devolver .= '<div class = "arialpeq8">'.$rowrowMvCkeckout['respuesta'].'</div>';
		   if (preg_match_all($patternTarjetaProcesasa,$rowrowMvCkeckout['respuesta'],$matchesTm2)) {
				           $num_matchesTm2 = count($matchesTm2[1]);
                           if ($num_matchesTm2 > 0) {
					          $devolver .= "<BR>TARJETA PROCESADA -->".$matchesTm2[1][0];
					       }	
           } 
   
		    if (preg_match_all($patternImporte ,$rowrowMvCkeckout['respuesta'],$matchesTm2)) {
				           $num_matchesTm2 = count($matchesTm2[1]);
                           if ($num_matchesTm2 > 0) {
					          $devolver .= "<BR>IMPORTE -->".$matchesTm2[1][0];
					       }	
           } 
          if (preg_match_all($patternSolicitud ,$rowrowMvCkeckout['respuesta'],$matchesTm2)) {
				           $num_matchesTm2 = count($matchesTm2[1]);
                           if ($num_matchesTm2 > 0) {
					          $devolver .= "<BR>SOLICITUD -->".$matchesTm2[1][0];
					       }	
           } 
          if (preg_match_all($patternEmail ,$rowrowMvCkeckout['respuesta'],$matchesTm2)) {
				           $num_matchesTm2 = count($matchesTm2[1]);
                           if ($num_matchesTm2 > 0) {
					          $devolver .= "<BR>E-MAIL -->".$matchesTm2[1][0];
					       }	
           } 
        $devolver .= '<div class="AccesoCheckRaya"></div>'; 
		$devolver .= '<div class="clear"></div>';
      
	  }
    }
mysqli_free_result($resrowMvCkeckout);
return 	$devolver;
}




//...........................................................................
function CobrosEnVtcobros($IDSolicitud,$conexion) {
        $cabeceras = '<div class="AccesoFacGenericoT">ID vtcobros</div>';
        $cabeceras .= '<div class="AccesoFacGenericoT">Fecha</div>'; 
        $cabeceras .= '<div class="AccesoFacGenericoT">importe</div>'; 
        $cabeceras .= '<div class="AccesoFacGenericoT">order number</div>'; 
		$cabeceras .= '<div class="AccesoFacGenericoObsT">e-mail</div>';
		$cabeceras .= '<div class="clear"></div>';  

    $devolver = "";
	$FormatMvtcobros = "SELECT id, email_cliente, date(fecha_emision) , numero_orden, importe    
                         FROM vtcobros
                        WHERE  id_solicitud = %d";
   $queMvtcobros = sprintf($FormatMvtcobros, $IDSolicitud);
   $resMvtcobros = mysqli_query($conexion, $queMvtcobros) or die(mysqli_error($conexion));                                                        
   $totMvtcobros = mysqli_num_rows($resMvtcobros);     
   if ($totMvtcobros > 0){
      while ($rowMvtcobros= mysqli_fetch_assoc($resMvtcobros)) {			  
	    $devolver .= $cabeceras;   
	    $devolver .= '<div class="AccesoGenerico">'.$rowMvtcobros['id'].'</div>';
        $devolver .= '<div class="AccesoGenerico">'.$rowMvtcobros['date(fecha_emision)'].'</div>'; 
        $devolver .= '<div class="AccesoGenericoNum">'.$rowMvtcobros['importe'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.$rowMvtcobros['numero_orden'].'</div>'; 
		$devolver .= '<div class="AccesoGenericoObs">'.$rowMvtcobros['email_cliente'].'</div>';
		$devolver .= '<div class="clear"></div>';
		$devolver .= RespuestasCheckout($rowMvtcobros['numero_orden'], $conexion);     
	  }
    }
mysqli_free_result($resMvtcobros);
return 	$devolver;
}

//...........................................................................
function SolicitudesCursadas($Pemail,$conexion) {
        $cabeceras = '<div class="AccesoGenericoT">ID Solicitud</div>';
        $cabeceras .= '<div class="AccesoGenericoT">Fecha</div>'; 
        $cabeceras .= '<div class="AccesoGenericoT">Tipo</div>'; 
        $cabeceras .= '<div class="AccesoGenericoT">Lote</div>'; 
		$cabeceras .= '<div class="AccesoGenericoObsT">Observaciones</div>';
		$cabeceras .= '<div class="clear"></div>'; 
		$devolver = ""; 
  	$FormatMailAl = "SELECT id, tipomensaje, fecha_mail, obser_cliente,  lotedecursos  
                         FROM vtsolicitudes
                        WHERE email_cliente = '%s' 
						ORDER BY fecha_mail
                       ";
   $queMailAl = sprintf($FormatMailAl, $Pemail);
   $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
   $totMailAl = mysqli_num_rows($resMailAl);     
   if ($totMailAl > 0){
      $devolver .='<div class="AccesoApartado">Solicitudes Cursadas por el Alumno</div><div class="clear"></div>';

      while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
			//$devolver .=  $rowRegistros['id'].'-'.$rowRegistros['fecha_mail']." <b>Tipo: </b>".$rowRegistros['tipomensaje']." <b>Observaciones: </b>".$rowRegistros['obser_cliente']."<br />";
         $devolver .=  $cabeceras;
        
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['id'].'</div>';
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['fecha_mail'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['tipomensaje'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['lotedecursos'].'</div>'; 
		$devolver .= '<div class="AccesoGenericoObs">'.$rowRegistros['obser_cliente'].'</div>';
	    $devolver .= '<div class="clear"></div>';
	      
		      $devolver .=   CobrosEnVtcobros($rowRegistros['id'],$conexion);
	  }
    }
mysqli_free_result($resMailAl);
return 	$devolver;
}

//...........................................................................
function SolicitudesDeCobro($Pemail,$conexion) {
        $cabeceras = '<div class="AccesoGenericoT">ID Solicitud</div>';
        $cabeceras .= '<div class="AccesoGenericoT">F. Emisión</div>'; 
        $cabeceras .= '<div class="AccesoGenericoT">Importe</div>'; 
        $cabeceras .= '<div class="AccesoGenericoT">F. Cobro</div>'; 
		$cabeceras .= '<div class="AccesoGenericoObsT">Descripción</div>';
		$cabeceras .= '<div class="clear"></div>'; 
		$devolver = ""; 
  	$FormatMailAl = "SELECT id, f_emision, importe, f_cobro, id_cobrosotros, descripcion
                         FROM vtsolcobro
                        WHERE email_destino = '%s' 
						ORDER BY f_emision
                       ";
   $queMailAl = sprintf($FormatMailAl, $Pemail);
   $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
   $totMailAl = mysqli_num_rows($resMailAl);     
   if ($totMailAl > 0){
      $devolver .='<div class="AccesoApartado">Solicitudes de Cobros</div><div class="clear"></div>';

      while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
         $devolver .=  $cabeceras;
        
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['id'].'</div>';
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['f_emision'].'</div>'; 
        $devolver .= '<div class="AccesoGenericoNum">'.$rowRegistros['importe'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.NoNull($rowRegistros['f_cobro']).'</div>'; 
		$devolver .= '<div class="AccesoGenericoObs">'.$rowRegistros['descripcion'].'</div>';
	    $devolver .= '<div class="clear"></div>';
	      
		      $devolver .=   CobrosEnVtcobrosOtros($rowRegistros['id_cobrosotros'],$conexion);
	  }
    }
mysqli_free_result($resMailAl);
return 	$devolver;
}
//...........................................................................
function CobrosManuales($Pemail,$conexion) {
        $cabeceras = '<div class="AccesoFacGenericoT">ID vtcobrosman.</div>';
        $cabeceras .= '<div class="AccesoFacGenericoT">F. Emisión</div>'; 
        $cabeceras .= '<div class="AccesoFacGenericoT">Importe</div>'; 
        $cabeceras .= '<div class="AccesoFacGenericoT">Entidad</div>'; 
		$cabeceras .= '<div class="AccesoFacGenericoObsT">Descripción</div>';
		$cabeceras .= '<div class="clear"></div>'; 
		$devolver = ""; 
  	$FormatMailAl = "SELECT id, fecha_emision, importe_original, origen_entidad, observaciones
                         FROM vtcobrosmanual
                        WHERE email_cliente = '%s' 
						ORDER BY fecha_emision
						                       ";
   $queMailAl = sprintf($FormatMailAl, $Pemail);
   $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
   $totMailAl = mysqli_num_rows($resMailAl);     
   if ($totMailAl > 0){
      $devolver .='<div class="AccesoApartado">Cobros Manuales</div><div class="clear"></div>';
      $devolver .=  $cabeceras;
      while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['id'].'</div>';
        $devolver .= '<div class="AccesoGenerico">'.$rowRegistros['fecha_emision'].'</div>'; 
        $devolver .= '<div class="AccesoGenericoNum">'.$rowRegistros['importe_original'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.NoNull($rowRegistros['origen_entidad']).'</div>'; 
		$devolver .= '<div class="AccesoGenericoObs">'.$rowRegistros['observaciones'].'</div>';
	    $devolver .= '<div class="clear"></div>';
	  }
    }
mysqli_free_result($resMailAl);
return 	$devolver;
}

//...........................................................................
function CobrosEnVtcobrosOtros($IDSolicitud,$conexion) {
        $cabeceras = '<div class="AccesoFacGenericoT">ID vtcobrosotros</div>';
        $cabeceras .= '<div class="AccesoFacGenericoT">Fecha</div>'; 
        $cabeceras .= '<div class="AccesoFacGenericoT">importe</div>'; 
        $cabeceras .= '<div class="AccesoFacGenericoT">order number</div>'; 
		$cabeceras .= '<div class="AccesoFacGenericoObsT">N.Factura</div>';
		$cabeceras .= '<div class="clear"></div>';  

    $devolver = "";
	$FormatMvtcobros = "SELECT id, email_cliente, date(fecha_emision) , numero_orden, importe, numero_factura   
                         FROM vtcobrosotros
                        WHERE  id = %d";
   $queMvtcobros = sprintf($FormatMvtcobros, $IDSolicitud);
   $resMvtcobros = mysqli_query($conexion, $queMvtcobros) or die(mysqli_error($conexion));                                                        
   $totMvtcobros = mysqli_num_rows($resMvtcobros);     
   if ($totMvtcobros > 0){
      while ($rowMvtcobros= mysqli_fetch_assoc($resMvtcobros)) {			  
	    $devolver .= $cabeceras;   
	    $devolver .= '<div class="AccesoGenerico">'.$rowMvtcobros['id'].'</div>';
        $devolver .= '<div class="AccesoGenerico">'.$rowMvtcobros['date(fecha_emision)'].'</div>'; 
        $devolver .= '<div class="AccesoGenericoNum">'.$rowMvtcobros['importe'].'</div>'; 
        $devolver .= '<div class="AccesoGenerico">'.$rowMvtcobros['numero_orden'].'</div>'; 
		$devolver .= '<div class="AccesoGenericoObs">'.$rowMvtcobros['numero_factura'].'</div>';
		$devolver .= '<div class="clear"></div>';
		$devolver .= RespuestasCheckout($rowMvtcobros['numero_orden'], $conexion);     
	  }
    }
mysqli_free_result($resMvtcobros);
return 	$devolver;
}
//...........................................
function Asesorias($Mail,$conexion) {
    $devolver="";
	$FormatMailAl = "SELECT f_sesion, h_inicio, observa_cliente
                         FROM asesoriasesiones
                        WHERE email = '%s'
                     ORDER BY f_sesion";
$queMailAl = sprintf($FormatMailAl, $Mail);
$resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
$totMailAl = mysqli_num_rows($resMailAl);     
if ($totMailAl > 0){
    while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
			$devolver .=  $rowRegistros['f_sesion']." <b>Hora: </b>".$rowRegistros['h_inicio']." <b>Observaciones: </b>".$rowRegistros['observa_cliente']."<br />";
	  }

}
mysqli_free_result($resMailAl);
return 	$devolver;
}

//............................................................................................................................................
	$email = $_REQUEST['Email'];
//............................................................................................................................................

    
?>
    
<div class="gris"> Actividad del cliente: <?php echo $_REQUEST['Email'] ?></div>
 
<div>
<div class="etiqueta">Asesorías:</div>
    <div class="etiquetaDatos"> <?php echo  Asesorias($_REQUEST['Email'] ,$conexion) ?>  </div>
    <div class="clear"></div>
</div>  



<div>
    <div class="etiqueta">Solicitudes y Facturas:</div>
    <div class="etiquetaDatos">
     <?php  echo  SolicitudesCursadas($email ,$conexion); ?> 
      <?php echo  SolicitudesDeCobro($email ,$conexion); ?>
      <?php echo  CobrosManuales($email ,$conexion); ?>
    </div>
    <div class="clear"></div>
</div>

<br /><br /><br /><br />
</body>
</html>