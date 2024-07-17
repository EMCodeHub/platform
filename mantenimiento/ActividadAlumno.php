<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Actividad del alumno</title>
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


//.............................................
function AvisosExcesoConexiones($IdAlumno,$conexion) {
    $devolver="";
    $numeroAvisos = 0;
    //.....total avisos
    	$FormatMailAl = "SELECT count(id_alumno) as contador
                             FROM vtavisoalumno
                            WHERE id_alumno = %d";
        $queMailAl = sprintf($FormatMailAl, $IdAlumno);
        $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
        $totMailAl = mysqli_num_rows($resMailAl);     
        if ($totMailAl > 0){
           while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {
            $numeroAvisos = $rowRegistros['contador'];
			$devolver .=  "Número de avisos: ".$rowRegistros['contador']."<br />";
	       }
        }
        mysqli_free_result($resMailAl);
    
    //....fechas aviso
    if ($numeroAvisos > 0){
	   $FormatMailAl = "SELECT fecha_aviso
                            FROM vtavisoalumno
                           WHERE id_alumno = %d
                        ORDER BY fecha_aviso";
       $queMailAl = sprintf($FormatMailAl, $IdAlumno);
       $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
       $totMailAl = mysqli_num_rows($resMailAl);     
       if ($totMailAl > 0){
           while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
			   $devolver .=  $rowRegistros['fecha_aviso']."<br />";
	       }
       }
       mysqli_free_result($resMailAl);
    }
return 	$devolver;
}
//.............................................
function CambiosPwd($IdAlumno,$conexion) {
    $devolver="";
    $numeroCambios = 0;
    //.....total avisos
    	$FormatMailAl = "SELECT count(id_alumno) as contador
                             FROM vtcambiopwd
                            WHERE id_alumno = %d";
        $queMailAl = sprintf($FormatMailAl, $IdAlumno);
        $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
        $totMailAl = mysqli_num_rows($resMailAl);     
        if ($totMailAl > 0){
           while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {
            $numeroCambios = $rowRegistros['contador'];
			$devolver .=  "Número de cambios: ".$rowRegistros['contador']."<br />";
	       }
        }
        mysqli_free_result($resMailAl);
    
    //....fechas aviso
    if ($numeroCambios > 0){
	   $FormatMailAl = "SELECT fecha_pwd
                            FROM vtcambiopwd
                           WHERE id_alumno = %d
                        ORDER BY fecha_pwd";
       $queMailAl = sprintf($FormatMailAl, $IdAlumno);
       $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
       $totMailAl = mysqli_num_rows($resMailAl);     
       if ($totMailAl > 0){
           while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
			   $devolver .=  $rowRegistros['fecha_pwd']."<br />";
	       }
       }
       mysqli_free_result($resMailAl);
    }
return 	$devolver;
}
//...........................................
function CartasEnviadas($IdAlumno,$conexion) {
    $devolver="";
	$FormatMailAl = "SELECT f_envio, fichero, asunto
                         FROM vtcartasregistros, vtcartascabecera
                        WHERE vtcartasregistros.id_carta = vtcartascabecera.id
                          and vtcartasregistros.id_alumno = %d
                     ORDER BY f_envio";
$queMailAl = sprintf($FormatMailAl, $IdAlumno);
$resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
$totMailAl = mysqli_num_rows($resMailAl);     
if ($totMailAl > 0){
    while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {			  
			$devolver .=  $rowRegistros['f_envio']." <b>Fichero: </b>".$rowRegistros['fichero']." <b>Asunto: </b>".$rowRegistros['asunto']."<br />";
	  }

}
mysqli_free_result($resMailAl);
return 	$devolver;
}
//...........................................
function Asesorias($IdAlumno,$conexion) {
    $devolver="";
	$FormatMailAl = "SELECT f_sesion, h_inicio, observa_cliente
                         FROM asesoriasesiones
                        WHERE id_alumno = %d
                     ORDER BY f_sesion";
$queMailAl = sprintf($FormatMailAl, $IdAlumno);
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
//........................................
function VerPermisos($usuario,$conexion) {
	$devolver = "";
	$FormatMailAl = "SELECT  vtpermisos.id_curso, web_titulo, vtpermisos.fecha_ini, vtpermisos.fecha_fin
                     FROM vtpermisos, vtcursos
				        WHERE vtpermisos.id_curso = vtcursos.id_curso
						    and  vtcursos.esta_activo > 0 
						    and ( vtpermisos.fecha_fin IS NULL OR YEAR(vtpermisos.fecha_fin) = 0  OR vtpermisos.fecha_fin >= CURDATE())
					      and id_usuario   = %d 
					      ORDER BY vtcursos.orden";
    $queMailAl = sprintf($FormatMailAl, $usuario);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);     
     if ($totMailAl > 0){
     	 while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
     	 	$cursoPagado = $rowMailAl['id_curso'];
     	 	array_push($permisos_usu, $cursoPagado);
     	 	$devolver .= "<b>Ini: </b>".$rowMailAl['fecha_ini']." <b>Fin: </b>".$rowMailAl['fecha_fin']." <b>Curso: </b>".$rowMailAl['id_curso']."-".$rowMailAl['web_titulo']."<br />";   	 	
     	 }
     }
mysqli_free_result($resMailAl);
return 	$devolver;
}    
//................................................................
function VerPermisosCaducados($usuario,$conexion) {
	$devolver = "";
	$FormatMailAl = "  SELECT vtpermisos.id_curso, web_titulo, vtpermisos.fecha_ini, vtpermisos.fecha_fin
                           FROM vtpermisos, vtcursos
				          WHERE vtpermisos.id_curso = vtcursos.id_curso
						    and  vtcursos.esta_activo > 0 
						    and  (YEAR(vtpermisos.fecha_fin) != 0 AND vtpermisos.fecha_fin <=  CURDATE())
   					        and id_usuario   = %d 
					      ORDER BY vtcursos.orden";
    $queMailAl = sprintf($FormatMailAl, $usuario);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);     
     if ($totMailAl > 0){
     	 while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
     	 	$cursoPagado = $rowMailAl['id_curso'];
     	 	array_push($permisos_usu, $cursoPagado);
     	 	$devolver .= "<b>CADUCADOS: </b>".$rowMailAl['fecha_ini']." <b>Curso: </b>".$rowMailAl['id_curso']."-".$rowMailAl['web_titulo']."<br />";   	 	
     	 }
     }
mysqli_free_result($resMailAl);
return 	$devolver;
}    
//......................................................
function ExisteRegistroGraris($PalumnoID,$conexion) {
	$FormatMailAl = "SELECT  id_alumno
                         FROM vtsesiongratis
				        WHERE id_alumno = %d
						limit 1";
    $queMailAl = sprintf($FormatMailAl, $PalumnoID);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);  
	mysqli_free_result($resMailAl);   
     if ($totMailAl > 0){
     	 return true;
     } else {
		 return false;
	 }
}
//...................................................
function VerSesionesGratis($PalumnoID,$conexion) {
    $devolver="";
	$n = 0;
	$FormatMailAl = "SELECT count(id) AS CONTADOR,pagina, sum(tiempo_segundos) AS TIEMPO
                         FROM vtsesiongratis 
                         WHERE id_alumno = %d
                         GROUP BY pagina
						 ORDER BY pagina
                      ";
$queMailAl = sprintf($FormatMailAl, $PalumnoID);
$resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));                                                        
$totMailAl = mysqli_num_rows($resMailAl);     
if ($totMailAl > 0){
    while ($rowRegistros = mysqli_fetch_assoc($resMailAl)) {	
	       $n++;
		   if ($n == 1) {
			  $devolver .= '<div class="contadorT">Veces</div><div class="paginaT">Página</div><div class="tiempoT">Segundos</div><div class="clear"></div>';
		   }	
	        $devolver .='<div class="contador">'.$rowRegistros['CONTADOR'].'</div><div class="pagina">'.$rowRegistros['pagina'].'</div><div class="tiempo">'.$rowRegistros['TIEMPO'].'</div><div class="clear"></div>';
	  }

}
mysqli_free_result($resMailAl);
return 	$devolver;	
	
}
//............................................................................................................................................
function ArrayPermisos($usuario,$conexion) {
	$array = array();
	$FormatMailAl = "SELECT  vtpermisos.id_curso
                     FROM vtpermisos, vtcursos
				            WHERE vtpermisos.id_curso = vtcursos.id_curso
						              and  vtcursos.esta_activo > 0 
						              and ( vtpermisos.fecha_fin IS NULL OR YEAR(vtpermisos.fecha_fin) = 0  OR vtpermisos.fecha_fin >= CURDATE())
					                and id_usuario   = %d 
					       ORDER BY  vtcursos.orden";
    $queMailAl = sprintf($FormatMailAl, $usuario);	
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);     
     if ($totMailAl > 0){
     	 while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
     	 	$curso = $rowMailAl['id_curso'];
     	 	array_push($array, $curso);
     	 }   
     } 
     mysqli_free_result($resMailAl);	
	 return $array; 				 
}
//............................................................................................................................................
function VerUsoCursos($usuario ,$conexion) {
	$permisos = ArrayPermisos($usuario,$conexion);
	$devolver ="";
	$longitud = count($permisos);
	
	//echo "<br />@@@ longitud vale--->".$longitud;
	
	if ($longitud == 0) {
		return $devolver;
	}
    for($i=0; $i < $longitud; $i++) {
		$devolver .='<div class="AccesoApartado">'.VerTituloCurso($permisos [$i], $conexion).'</div><div class="clear"></div>';
		$devolver .= '<div class="cursoElementoT">Elemento</div>';
        $devolver .= '<div class="cursoValoresT">Número</div>'; 
        $devolver .= '<div class="cursoValoresT">Visitados</div>'; 
        $devolver .= '<div class="cursoValoresT">% Visto</div>';
		$devolver .= '<div class="cursoValoresT">Núm de IPs</div>';
        $devolver .= '<div class="clear"></div>';
		
	    $devolver .= VerUsoTemas($usuario, $permisos [$i], $conexion);	  
		$devolver .= VerUsoRecursos($usuario, $permisos [$i], $conexion);	
		$devolver .= VerUsoVideos($usuario, $permisos [$i], $conexion); 	  
			  
    }
	
//echo "<br />@@@ fuera del bucle-->devolver= ".$devolver;	
return $devolver;	
}
//............................................................................................................................................
function VerTituloCurso($Pcurso, $conexion) {
    $tornar="";
   	$FormatMailAl = "SELECT id_curso, web_titulo
                         FROM vtcursos
				        WHERE id_curso   = %d 
					  ";
    $queMailAl = sprintf($FormatMailAl, $Pcurso);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
	
	//echo "<br />@@@ query --->".$queMailAl;
	
    $totMailAl = mysqli_num_rows($resMailAl);     
     if ($totMailAl > 0){
     	 while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
			 $tornar = $rowMailAl['id_curso']." - ".$rowMailAl['web_titulo'];	 	
     	 }
     }
     mysqli_free_result($resMailAl);
	 //echo "<br />@@@ tornar --->".$tornar;
     return 	$tornar;
 	
}
//............................................................................................................................................
function TemasIPs($usuario, $curso, $conexion) {
	$FormatMailAl = "SELECT    DISTINCT ip_conex
                           FROM   vtsesiones, vtusotema, vtalumnos, vtcurmodbloqtema, vtcursos
                          WHERE   vtsesiones.id         = vtusotema.id_sesion 
                            and   vtsesiones.id_alumno  = vtalumnos.id
							              and   vtcursos.id_curso     = %d 
                            and   vtalumnos.id          = %d 
                            and   vtusotema.id_recurso = vtcurmodbloqtema.id
                            and   vtusotema.id_curso   = vtcursos.id_curso";
    $queMailAl = sprintf($FormatMailAl, $curso, $usuario);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);  
	mysqli_free_result($resMailAl); 
    return $totMailAl;
}
//............................................................................................................................................
function VerUsoTemas($usuario, $curso, $conexion) {
  $porcentaje = 0;	
  $salida     = "";
  $Num        = count(CalculaTemasCurso($curso,$conexion));
  $Vistos     = count(CalculaTemasVisitados($curso,$usuario,$conexion));      
  $NumIPs     = TemasIPs($usuario, $curso, $conexion);
  if ($Num > 0) {
	 $porcentaje = ceil(100 * $Vistos / $Num); 
  }
        $salida .= '<div class="cursoElemento">Temas</div>';
        $salida .= '<div class="cursoValores">'.NoZero($Num).'</div>'; 
        $salida .= '<div class="cursoValores">'.NoZero($Vistos).'</div>'; 
        $salida .= '<div class="cursoValores">'.NoZero($porcentaje).'</div>';
		$salida .= '<div class="cursoValores">'.NoZero($NumIPs).'</div>';
        $salida .= '<div class="clear"></div>';
  return $salida;
}
//............................................................................................................................................
//............................................................................................................................................
function RecursosIPs($usuario, $curso, $conexion) {
	$FormatMailAl = "	SELECT   DISTINCT ip_conex
                           FROM   vtsesiones, vtusorecurso, vtalumnos, vtcurmodbloqrecurso, vtcursos
                          WHERE   vtsesiones.id         = vtusorecurso.id_sesion 
                            and   vtsesiones.id_alumno  = vtalumnos.id
                            and   vtcursos.id_curso     = %d 
                            and   vtalumnos.id          = %d 
                            and   vtusorecurso.id_recurso = vtcurmodbloqrecurso.id
                            and   vtusorecurso.id_curso   = vtcursos.id_curso";						
									
    $queMailAl = sprintf($FormatMailAl, $curso, $usuario);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);  
	mysqli_free_result($resMailAl);   
    return $totMailAl;
}
//............................................................................................................................................
function VerUsoRecursos($usuario, $curso, $conexion) {
  $porcentaje = 0;	
  $salida     = "";
  $Num        = count(CalculaRecursosCurso($curso,$conexion));
  $Vistos     = count(CalculaRecursosVisitados($curso,$usuario,$conexion));      
  $NumIPs     = RecursosIPs($usuario, $curso, $conexion);
  if ($Num > 0) {
	 $porcentaje = ceil(100 * $Vistos / $Num); 
  }
        $salida .= '<div class="cursoElemento">Recursos</div>';
        $salida .= '<div class="cursoValores">'.NoZero($Num).'</div>'; 
        $salida .= '<div class="cursoValores">'.NoZero($Vistos).'</div>'; 
        $salida .= '<div class="cursoValores">'.NoZero($porcentaje).'</div>';
		    $salida .= '<div class="cursoValores">'.NoZero($NumIPs).'</div>';
        $salida .= '<div class="clear"></div>';
  return $salida;
}
//...............................................................
function VideosIPs($usuario, $curso, $conexion) {
	$FormatMailAl = "  SELECT   DISTINCT ip_conex
                           FROM  vtsesiones, vtusovideo, vtalumnos, vtcurmodbloqvideo, vtcursos
                          WHERE  vtsesiones.id         = vtusovideo.id_sesion 
                            and  vtsesiones.id_alumno  = vtalumnos.id
                            and  vtcursos.id_curso     = %d 
							and  vtalumnos.id          = %d  
                            and  vtsesiones.id_alumno  = vtalumnos.id
                            and  vtusovideo.id_recurso = vtcurmodbloqvideo.id
                            and  vtusovideo.id_curso   = vtcursos.id_curso";
    $queMailAl = sprintf($FormatMailAl, $curso, $usuario);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl);  
	mysqli_free_result($resMailAl);   
    return $totMailAl;
}


//............................................................................................................................................
function VerUsoVideos($usuario, $curso, $conexion) {
  $porcentaje = 0;	
  $salida     = "";
  $Num        = count(CalculaVideosCurso($curso,$conexion));
  $Vistos     = count(CalculaVideosVisitados($curso,$usuario,$conexion));      
  $NumIPs     = VideosIPs($usuario, $curso, $conexion);
  if ($Num > 0) {
	 $porcentaje = ceil(100 * $Vistos / $Num); 
  }
        $salida .= '<div class="cursoElemento">Videos</div>';
        $salida .= '<div class="cursoValores">'.NoZero($Num).'</div>'; 
        $salida .= '<div class="cursoValores">'.NoZero($Vistos).'</div>'; 
        $salida .= '<div class="cursoValores">'.NoZero($porcentaje).'</div>';
		$salida .= '<div class="cursoValores">'.NoZero($NumIPs).'</div>';
        $salida .= '<div class="clear"></div>';
  return $salida;
}
//............................................................................................................................................
function VerConexiones ($usuario, $conexion) {
    $devolver = "";
   	$FormatMailAl = "SELECT  * FROM
        (SELECT   ip_conex, vtusovideo.fecha AS FECHA, 'Vídeo' AS TIPO ,vtusovideo.id_recurso AS NUM_RECURSO, titulo_video AS TITULO, 
		          vtusovideo.id_curso AS NUM_CURSO, titulo_cur AS CURSO
           FROM   vtsesiones, vtusovideo, vtalumnos, vtcurmodbloqvideo, vtcursos
          WHERE   vtsesiones.id         = vtusovideo.id_sesion 
                  and   vtsesiones.id_alumno  = vtalumnos.id
                  and   vtusovideo.id_recurso = vtcurmodbloqvideo.id
                  and   vtusovideo.id_curso   = vtcursos.id_curso
                  and   vtalumnos.id = %d
          UNION
         SELECT   ip_conex, vtusotema.fecha AS FECHA, 'Tema' AS TIPO, vtusotema.id_recurso AS NUM_RECURSO, titulo_tema AS TITULO, vtusotema.id_curso AS NUM_CURSO, titulo_cur AS CURSO
           FROM   vtsesiones, vtusotema, vtalumnos, vtcurmodbloqtema, vtcursos
          WHERE   vtsesiones.id         = vtusotema.id_sesion 
                  and   vtsesiones.id_alumno  = vtalumnos.id
                  and   vtusotema.id_recurso = vtcurmodbloqtema.id
                  and   vtusotema.id_curso   = vtcursos.id_curso
                  and   vtalumnos.id = %d
          UNION
         SELECT   ip_conex, vtusorecurso.fecha AS FECHA, 'Recurso' AS TIPO, vtusorecurso.id_recurso AS NUM_RECURSO, titulo_recurso AS TITULO, 
		          vtusorecurso.id_curso AS NUM_CURSO, titulo_cur AS CURSO
           FROM   vtsesiones, vtusorecurso, vtalumnos, vtcurmodbloqrecurso, vtcursos
          WHERE   vtsesiones.id         = vtusorecurso.id_sesion 
                  and   vtsesiones.id_alumno  = vtalumnos.id
                  and   vtusorecurso.id_recurso = vtcurmodbloqrecurso.id
                  and   vtusorecurso.id_curso   = vtcursos.id_curso
                  and   vtalumnos.id = %d
          ) AS TABLA
            order by NUM_CURSO, TIPO,NUM_RECURSO, FECHA
		";
    $queMailAl = sprintf($FormatMailAl, $usuario, $usuario, $usuario);
    $resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion)); 
    $totMailAl = mysqli_num_rows($resMailAl); 
		$cabeceras = '<div class="AccesoNumT">Nº Cur</div>';
        $cabeceras .= '<div class="AcesoTipoT">Tipo</div>'; 
        $cabeceras .= '<div class="AccesoNumT">Nº Rec</div>'; 
        $cabeceras .= '<div class="AccesoTituloT">Título</div>';
		    $cabeceras .= '<div class="AccesoFechaT">Fecha</div>';
		    $cabeceras .= '<div class="AccesoIPT">IP</div>';
        $cabeceras .= '<div class="clear"></div>';  
     if ($totMailAl > 0){
	   $devolver .= $cabeceras;
	   $n = 0;
       while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
	    $n++;	   
		if ($control != $rowMailAl['NUM_CURSO'] && $n != 1) {
		   $devolver .= $cabeceras;	
		} else {
		   if ($control2 != $rowMailAl['TIPO'] && $n != 1) {
		      $devolver .= '<div class="AccesoRaya"></div><div class="clear"></div>';
		   }
		}
		$devolver .= '<div class="AccesoNum">'.$rowMailAl['NUM_CURSO'].'</div>';
        $devolver .= '<div class="AcesoTipo">'.$rowMailAl['TIPO'].'</div>'; 
        $devolver .= '<div class="AccesoNum">'.$rowMailAl['NUM_RECURSO'].'</div>'; 
        $devolver .= '<div class="AccesoTitulo">'.RellenaPuntos($rowMailAl['TITULO']).'</div>';
		$devolver .= '<div class="AccesoFecha">'.$rowMailAl['FECHA'].'</div>';
		$devolver .= '<div class="AccesoIP">'.$rowMailAl['ip_conex'].'</div>';
        $devolver .= '<div class="clear"></div>';
		$control = $rowMailAl['NUM_CURSO'];
		$control2 = $rowMailAl['TIPO'];
		
       }
     }
     mysqli_free_result($resMailAl);
	 //echo "<br />@@@ tornar --->".$tornar;
     return 	$devolver;
 		
	
}
//............................................................................................................................................
	    $tipoAlum      = "";
		$pais          = "";
		$ciudad        = "";
		$email         = "";
		$telefono      = "";
		$nombre        = "";
		$apellidos     = "";
        $ip            = "";
        $fecha_alta    = "";
        $fecha_baja    = "";
        $observaciones = "";
        $ultimaconnex  = "";
        $descriTipoAl  = "";
$FormatMailAl = "SELECT vtalumnos.id,  tipoalumno, pais, ciudad, email, telefono, nombre, apellidos, ultima_ip,	
                          fecha_alta,	fecha_baja,observaciones_medif, ultima_conexion, vttipoalumno.descripcion
                     FROM vtalumnos,vttipoalumno
				     WHERE vtalumnos.tipoalumno = vttipoalumno.id 
				           and vtalumnos.id= %d";
$queMailAl = sprintf($FormatMailAl, $_REQUEST['NumeroAlumno']);
	

$resMailAl = mysqli_query($conexion, $queMailAl) or die(mysqli_error($conexion));  
$totMailAl = mysqli_num_rows($resMailAl);    
 if ($totMailAl > 0){
	  while ($rowMailAl = mysqli_fetch_assoc($resMailAl)) {
		  $tipoAlum      = $rowMailAl['tipoalumno'];
		  $pais          = $rowMailAl['pais'];
		  $ciudad        = $rowMailAl['ciudad'];
		  $email         = $rowMailAl['email'];
		  $telefono      = $rowMailAl['telefono'];
		  $nombre        = $rowMailAl['nombre'];
		  $apellidos     = $rowMailAl['apellidos'];
          $ip            = $rowMailAl['ultima_ip'];
          $fecha_alta    = $rowMailAl['fecha_alta'];
          $fecha_baja    = $rowMailAl['fecha_baja'];
          $observaciones = $rowMailAl['observaciones_medif'];
          $ultimaconnex  = $rowMailAl['ultima_conexion'];
          $descriTipoAl  = $rowMailAl['descripcion'];       
   } 
 }
mysqli_free_result($resMailAl);
//............................................................................................................................................

    
?>
    
    
    
    
    
    
    
<div class="gris"> Actividad del alumno: <?php echo $_REQUEST['NumeroAlumno'] ?></div>
<div>
    <div class="etiqueta">Nombre:</div>
    <div class="etiquetaDatos"> <?php echo $nombre." ".$apellidos ?></div>
    <div class="clear"></div>
</div>
<div>
    <div class="etiqueta">E-mail / Teléfono:</div>
    <div class="etiquetaDatos"> <?php echo $email." <b>Tfn:</b> ".$telefono ?> </div>
    <div class="clear"></div>
</div>
<div>
    <div class="etiqueta">Tipo alumno:</div>
    <div class="etiquetaDatos"> <?php echo $tipoAlum."-".$descriTipoAl ?></div>
    <div class="clear"></div>
</div>
<div>
    <div class="etiqueta">Ciudad-País:</div>
    <div class="etiquetaDatos"> <?php echo $ciudad." <b>País: </b>".$pais ?></div>
    <div class="clear"></div>
</div>
<div>
    <div class="etiqueta">Observaciones Medif:</div>
    <div class="etiquetaDatos"> <?php echo $observaciones ?></div>
    <div class="clear"></div>
</div>
<div>
    <div class="etiqueta">Fechas:</div>
    <div class="etiquetaDatos"> <?php echo "<b>Alta: </b>".$fecha_alta." <b>Baja: </b>".$fecha_baja ?> </div>
    <div class="clear"></div>
</div>


<div>
<?php
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
  $pais_C = (trim($paisFichero) != "" ? $paisFichero : $geoplugin['geoplugin_countryCode']."-".$geoplugin['geoplugin_countryName']);
  $ciudad_C = (trim($ciudadFichero) != "" ? $ciudadFichero : $geoplugin['geoplugin_city']);
?>
    <div class="etiqueta">Última conexión:</div>
    <div class="etiquetaDatos"> <?php echo "<b>Fecha: </b>".$ultimaconnex." <b>IP: </b>".$ip." <b>Ciudad: </b>".$ciudad_C." ".$pais_C ?> </div>
    <div class="clear"></div>
</div>
 <div>
    <div class="etiqueta">Avisos Exceso Conexiones:</div>
    <div class="etiquetaDatos"> <?php echo  AvisosExcesoConexiones($_REQUEST['NumeroAlumno'] ,$conexion) ?>  </div>
    <div class="clear"></div>
</div>     
    
  <div>
    <div class="etiqueta">Cambios de Password:</div>
    <div class="etiquetaDatos"> <?php echo  CambiosPwd($_REQUEST['NumeroAlumno'] ,$conexion) ?>  </div>
    <div class="clear"></div>
</div>      
    
   
<div>
    <div class="etiqueta">Cartas Promocionales:</div>
    <div class="etiquetaDatos"> <?php echo  CartasEnviadas($_REQUEST['NumeroAlumno'] ,$conexion) ?>  </div>
    <div class="clear"></div>
</div>  
<div>
<div class="etiqueta">Asesorías:</div>
    <div class="etiquetaDatos"> <?php echo  Asesorias($_REQUEST['NumeroAlumno'] ,$conexion) ?>  </div>
    <div class="clear"></div>
</div>  



<div>
    <div class="etiqueta">Solicitudes y Facturas:</div>
    <div class="etiquetaDatos">
     <?php echo  SolicitudesCursadas($email ,$conexion); ?> 
      <?php echo  SolicitudesDeCobro($email ,$conexion); ?>
      <?php echo  CobrosManuales($email ,$conexion); ?>
    </div>
    <div class="clear"></div>
</div>


<div>
    <div class="etiqueta">Permisos:</div>
    <div class="etiquetaDatos"> <?php echo  VerPermisos($_REQUEST['NumeroAlumno'] ,$conexion) ?></div>
    <div class="etiquetaDatos"> <?php echo  VerPermisosCaducados($_REQUEST['NumeroAlumno'] ,$conexion) ?></div>
    <div class="clear"></div>
</div>

<?php if(ExisteRegistroGraris($_REQUEST['NumeroAlumno'],$conexion)) { ?>
    <div>
        <div class="etiqueta">Páginas visitadas GRATIS:</div>
        <div class="etiquetaDatos"> <?php echo  VerSesionesGratis($_REQUEST['NumeroAlumno'],$conexion) ?></div>
        <div class="clear"></div>
    </div>
<?php } ?>

<div>
    <div class="etiqueta">Temas, recursos y vídeos:</div>
    <div class="etiquetaDatos"> <?php echo VerUsoCursos($_REQUEST['NumeroAlumno'],$conexion) ?></div>
    <div class="clear"></div>
</div>
<div>
    <div class="etiqueta">Accesos a contenidos:</div>
    <div class="etiquetaDatos"> <?php echo VerConexiones ($_REQUEST['NumeroAlumno'],$conexion) ?></div>
    <div class="clear"></div>
</div>
<br /><br /><br /><br />
</body>
</html>