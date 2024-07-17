<?php
//.....funciones CartasPromocionales Seleccionar, será llamada desde el menú gestión para activar reenvíos de cartas
function EmpiezaPor($string, $startString) { 
  $len = strlen($startString); 
  return (substr($string, 0, $len) === $startString); 
} 
//.............................................................
function BuscaCartas($conexion){
   $CarpetaCartas ="../cartas/PomocionSemanal"; 
   if (is_dir($CarpetaCartas)) {
      if ($dh = opendir($CarpetaCartas)) { 
			     $return =  '<select id="cartaElegida" name="cartaElegida" onchange="VerCarta()">';
				 $return = $return.'<option></option>';
                 while (($file = readdir($dh)) !== false) { 
				     if (!EmpiezaPor($file, "." ) && is_dir($CarpetaCartas."/".$file) <>1 ) {
				      $return = $return. '<option >'.$file.'</option>';
				     }
                     //echo "<br>".$file." es directorio-->".EmpiezaPor( $file, "." );
				 }
                 $return = $return.'</select>';
		         return $return; //..................................................................................input propio
      } //opendir    
    
   }
}
//........................................................
 function DibujaChecksCursos($conexion) {
	        $txtSaliente = "";
			$FormatCheck = "SELECT id_curso, web_titulo  
		                      FROM vtcursos  
		                     WHERE vtcursos.esta_activo > 0 
							   and   ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE()) ";  
           $FormatCheck .= " ORDER BY id_curso";
           $queCheck = sprintf($FormatCheck);
           $resCheck = mysqli_query($conexion, $queCheck) or die(mysqli_error($conexion)); 
           $totCheck = mysqli_num_rows($resCheck);     

if ($totCheck == 0){
	return $txtSaliente;
}

	while ($rowCheck = mysqli_fetch_assoc($resCheck)) {
      $txtSaliente .="";
      $txtSaliente .= '<input type="checkbox" value="';
      $txtSaliente .= $rowCheck['id_curso'].'" ';
      $txtSaliente .= 'name="checkbox" onchange="LimpiaCalculos()"/>';
      $txtSaliente .='&nbsp; &nbsp;'.$rowCheck['id_curso']."-".$rowCheck['web_titulo'];   
	  $txtSaliente .='<br />';
      
	}
  mysqli_free_result($resCheck); 
	return $txtSaliente;
 }  
//.....................................................................
function ObtenerMailPruebas($conexion){
//.....obtener el correo secundario para no inundar de emails el correo principal 
      $MailSecundario = "";
      $FormatCorreo2 = "SELECT  correoelectronico 
			                    FROM emailscomerciales  
			                   WHERE tipocorreo = 2";  
      $queCorreo2 = sprintf($FormatCorreo2);
      $resCorreo2 = mysqli_query($conexion, $queCorreo2) or die(mysqli_error($conexion)); 
      $totCorreo2 = mysqli_num_rows($resCorreo2);     
      while ($rowCorreo2 = mysqli_fetch_assoc($resCorreo2)) {
         $MailSecundario = $rowCorreo2['correoelectronico'];  
      }
      mysqli_free_result($resCorreo2); 
      return $MailSecundario; 
}          
//.....................................................................
function ObtenerIDPruebas($conexion,$CorreoElectronico){
//.....obtener el ID del usuario de pruebas
      $IDPruebas = 0;
      $FormatCorreo2 = "SELECT id FROM vtalumnos WHERE email='%s'";  
      $queCorreo2 = sprintf($FormatCorreo2,$CorreoElectronico);
      $resCorreo2 = mysqli_query($conexion, $queCorreo2) or die(mysqli_error($conexion)); 
      $totCorreo2 = mysqli_num_rows($resCorreo2);     
      while ($rowCorreo2 = mysqli_fetch_assoc($resCorreo2)) {
         $IDPruebas = $rowCorreo2['id'];  
      }
      mysqli_free_result($resCorreo2); 
      return $IDPruebas;
}
//.....................................................................          
function ReenviarCPendientes ($conexion,$llamadaDeMenu)  {
    //Llamaremos a esta función desde CartasPromocionalesSeleccionar o desde menú gestión: variará la respuesta en función del origen de la llamada
    //---0-- se llama desde CartasPromocionalesSeleccionar.php
    //---1-- se llama desde index (para reenviar cartas  si hay pendientes)
    //..........................................................................
    // Devolverá el cógigo javascript en función de la situación:
    //  1-> Liberar pantalla
    //  2-> Bloquear pantalla y no hacer nada
    //  3-> Bloquear pantalla e iniciar reenvíos
    //.......//...........//............/...........//.....................................hay pendientes ?
     $HayPendientes = 0;
     $MasDeDiezMil = 0;
     $MasDeQuinceMinutos = 1;
     $IdCartaPendiente = 0;
     $FormatPendientes = "SELECT count(id) as CONTADOR FROM vtcartasregistros WHERE f_envio is null";  
      $quePendientes = sprintf($FormatPendientes);
      $resPendientes = mysqli_query($conexion, $quePendientes) or die(mysqli_error($conexion)); 
      $totPendientes = mysqli_num_rows($resPendientes);     
      while ($rowPendientes = mysqli_fetch_assoc($resPendientes)) {
         $HayPendientes = $rowPendientes['CONTADOR'];  
      }
      mysqli_free_result($resPendientes); 
      // ................................................................se han enviado 10.000 cartas hoy (SON 99 POR LOTE) 
      if ($HayPendientes > 0) {
         $FormatEnviadas = "SELECT count(id) as CONTADOR FROM vtcartasregistros 
                             WHERE TIMESTAMPDIFF(DAY,f_envio,CURRENT_TIMESTAMP) < 1";  
         $queEnviadas = $FormatEnviadas;
         $resEnviadas = mysqli_query($conexion, $queEnviadas) or die(mysqli_error($conexion)); 
         $totEnviadas = mysqli_num_rows($resEnviadas);     
         while ($rowEnviadas = mysqli_fetch_assoc($resEnviadas)) {
            if($rowEnviadas['CONTADOR'] >= 10000 ) {
                $MasDeDiezMil = 1;
            }  
         }
         mysqli_free_result($resEnviadas); 
      }
     // .............................................................último envío hace más de 20 minutos?
      if ($HayPendientes > 0 && $MasDeDiezMil == 0) {
          //..... averiguar la id de la carta pendiente
          $FormatIdCarta = "SELECT DISTINCT id_carta as CARTA FROM vtcartasregistros 
                             WHERE f_envio is null";  
          $queIdCarta = sprintf($FormatIdCarta);
          $resIdCarta = mysqli_query($conexion, $queIdCarta) or die(mysqli_error($conexion)); 
          $totIdCarta = mysqli_num_rows($resIdCarta);     
          while ($rowIdCarta = mysqli_fetch_assoc($resIdCarta)) {
              $IdCartaPendiente = $rowIdCarta['CARTA'];  
          }
          mysqli_free_result($resIdCarta); 
          //..................hace más de 20 minutos ?
          $FormatTiempo = "SELECT TIMESTAMPDIFF(SECOND,f_ultimoenvio,CURRENT_TIMESTAMP) as SEGUNDOS 
                             FROM vtcartascabecera
                            WHERE id = %d";  
          $queTiempo = sprintf($FormatTiempo, $IdCartaPendiente);
          $resTiempo = mysqli_query($conexion, $queTiempo) or die(mysqli_error($conexion)); 
          $totTiempo = mysqli_num_rows($resTiempo);     
          while ($rowTiempo = mysqli_fetch_assoc($resTiempo)) {
             if ($rowTiempo['SEGUNDOS'] <= 60*15 ) {
                 $MasDeQuinceMinutos = 0;
             }  
          }
          mysqli_free_result($resTiempo); 
      }
      //............................DEVOLUCIÓN RESULTADOS
      $situacion = 1;
      if ($HayPendientes == 0) {
         $situacion =  1;               //.......Liberar pantalla  
      }  else {
            if ($MasDeDiezMil  == 0 ) {
                if ($MasDeQuinceMinutos == 0){
                  $situacion =  2;      //...........Bloquear pantalla 
                } else {
                  $situacion =  3;      //...........Iniciar reenvíos 
                }
           }  else {
              $situacion =  2;    //...........Bloquear pantalla 
           }
      }
      //.................................................generar código javascript
    $devolver = "";
    switch ($situacion) {
    case 1:   //...........................................................Pantalla libre
        $devolver = '$("#datosFormPrincipal").css("display","block");
                     $("#datosFormBloqueo").css("display","none");
                     $("#datosFormReenvio").css("display","none");';
        break;   
    case 2:   //...........................................................Pantalla bloqueada
         $devolver = '$("#datosFormPrincipal").css("display","none");
                      $("#datosFormBloqueo").css("display","block");
                      $("#datosFormReenvio").css("display","none");';
        break;   
    case 3:   //...........................................................Pantalla reenvíos
         $devolver = '$("#datosFormPrincipal").css("display","none");
                      $("#datosFormBloqueo").css("display","none");
                      $("#datosFormReenvio").css("display","block");
                      $("#botonSalir").css("display","none"); 
                      $("#enviosAnteriores").css("display","none");
                      ReenviaCartasPendientes()';
        break;   
 }  
    if ($llamadaDeMenu == 0) {
        return  $devolver;  //...devolvemos el script  
    } else {
        return  $situacion;   //...devolvemos el número de situación, si desde index obtenemos un 3 llamaremos a CartasPromocionalesSeleccionar.php para reenviar correos pendientes
    }
     
} 
//.....................................................................
function CartaUltimoEnvio ($conexion) {
  //.... fecha de la ultima carta enviada, de la última id 
         $idCarta = 0;
         $datosFichero = "";
         $datosFecha = "";
         $alumnosImplicados = 0;
         $alumnosPendientes   = 0;
         $FormatFecha = "SELECT id, fichero, f_ultimoenvio 
                           FROM vtcartascabecera
                          WHERE id = (SELECT max(id) FROM vtcartascabecera T2)";  
          $queFecha = sprintf($FormatFecha);
          $resFecha = mysqli_query($conexion, $queFecha) or die(mysqli_error($conexion)); 
          $totFecha = mysqli_num_rows($resFecha);     
          while ($rowFecha = mysqli_fetch_assoc($resFecha)) {
               $idCarta      =  $rowFecha['id'];
               $datosFichero =  $rowFecha['fichero']; 
               $datosFecha   =  $rowFecha['f_ultimoenvio']; 
          }
          mysqli_free_result($resFecha); 
     //........número de alumnos implicados
         $FormatAnotadas = "SELECT count(id) as CONTADOR FROM vtcartasregistros WHERE id_carta = %d";  
         $queAnotadas = sprintf($FormatAnotadas,$idCarta);
         $resAnotadas = mysqli_query($conexion, $queAnotadas) or die(mysqli_error($conexion)); 
         $totAnotadas = mysqli_num_rows($resAnotadas);     
         while ($rowAnotadas = mysqli_fetch_assoc($resAnotadas)) {
            $alumnosImplicados = $rowAnotadas['CONTADOR'];
         }
         mysqli_free_result($resAnotadas); 
    //.........numero de alumnos enviados
         $FormatPendientes = "SELECT count(id) as CONTADOR FROM vtcartasregistros WHERE id_carta = %d and f_envio is null";  
         $quePendientes = sprintf($FormatPendientes,$idCarta);
         $resPendientes = mysqli_query($conexion, $quePendientes) or die(mysqli_error($conexion)); 
         $totPendientes = mysqli_num_rows($resPendientes);     
         while ($rowPendientes = mysqli_fetch_assoc($resPendientes)) {
            $alumnosPendientes = $rowPendientes['CONTADOR'];
         }
         mysqli_free_result($resPendientes); 
    //.......................................
    $salida = "ÚLTIMA CARTA: ".EnRosa($datosFichero)." &nbsp; &nbsp; ÚLTIMO ENVÍO: ".EnRosa($datosFecha)." &nbsp; &nbsp; NÚMERO CARTAS: ".EnRosa($alumnosImplicados)." &nbsp; &nbsp; PENDIENTES: ".EnRosa($alumnosPendientes);
    return $salida;
}
//...........................................................................
function EnRosa($txt){
    return "<span class='rosa'>".$txt."</span>";
}
//.........................................................
function ProcesoActivo($conexion){
    $estado = 0;
    $formatProceso = "SELECT proceso_activo 
                        FROM vtcartascontrol 
                       WHERE id=1";  //la tabla sólo tendrá un registro
    $queProceso = $formatProceso;  
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion));  
    $totProceso = mysqli_num_rows($resProceso); 
	while ($rowProceso = mysqli_fetch_assoc($resProceso)) {
		  $estado =  $rowProceso['proceso_activo'];  
	}
    mysqli_free_result($resProceso); 
    return $estado;   // 0= inactivo  1=activo
}
//.........................................................
function ActualizaProcesoActivo($estado,$conexion){
    $FormatActualiza = "UPDATE vtcartascontrol
                           SET proceso_activo = %d
                         WHERE id=1";
    $queActualiza = sprintf($FormatActualiza,$estado);
    $resActualiza = mysqli_query($conexion, $queActualiza) or die(mysqli_error($conexion));  
    mysqli_free_result($resActualiza);   
}
?>
