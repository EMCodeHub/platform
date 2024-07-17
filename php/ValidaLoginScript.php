<?php
$paisEnFichero = "";
$ciudadEnFichero = "";
$ipConexion                = "";
$NumeroCursosEnVenta       = 0;
$NumeroCursosGratis        = 0;
//...............................................................
function DatoLleno($txt) {
    if  (strlen(trim($txt)) > 0) {
        return true;
    } else {
        return false;
    }
}
//...............................................................
function ExisteMailUsuario($usuario,$conexion) {
$numeroUsuario = 0;
$FormatMaestros = "SELECT id 
                     FROM vtalumnos
				    WHERE UPPER(email) = UPPER('%s') ";

$queMaestros = sprintf($FormatMaestros, $usuario);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$numeroUsuario = $rowMaestros['id'];
	}
}
mysqli_free_result($resMaestros); 
return $numeroUsuario;
}
/////////////////////////////////////////////////////////////////
function getRealIP() {
    if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))  {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) { 
	    return $_SERVER["HTTP_X_FORWARDED"]; 
	} elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_FORWARDED"])){
        return $_SERVER["HTTP_FORWARDED"];
    } else {
        return $_SERVER["REMOTE_ADDR"];
    }
}
//....................................................
function get_RemoteFile($url, $timeout = 10) {
  $ch = curl_init();
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $file_contents = curl_exec($ch);
  curl_close($ch);
  return ($file_contents) ? $file_contents : FALSE;
}
//...............................................................
function decamu($str){
 $NumerosE = array(3,7,8,9,11);  
    $letras = str_split ( $str);
    $numeroLetras = count($letras);
    $devolver = "";
    for ($j = 0; $j < $numeroLetras; $j++ ) {
            $letra = ord($letras[$j]);
            $nueva =  $letra + $NumerosE[$j % 5];
            $devolver .=  chr($nueva);
    }
    return $devolver;  
}
//...............................................................
function AnotaAltaSesion($usuario,$ip,$conexion) {
	
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip) );
  $Latitud  = $geoplugin['geoplugin_latitude'];
  $Longitud = $geoplugin['geoplugin_longitude'];
  $Ciudad   = $geoplugin['geoplugin_countryCode']."-".$geoplugin['geoplugin_city'];
  $FormatMaestros = "INSERT INTO `vtsesiones` (`id`, `id_alumno`, `ip_conex`, `fecha_inicio`, `ciudad`, `latitud`, `longitud`) 
                     VALUES (NULL, %d, '%s', CURRENT_TIMESTAMP,'%s',%f,%f)";
$queMaestros = sprintf($FormatMaestros, $usuario,$ip,$Ciudad,$Latitud,$Longitud);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 
$FormatMaestros = "select max(id) as ultimo from vtsesiones;";
$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion)); 
$totMaestros = mysqli_num_rows($resMaestros); 
$Numero_Conexion = 0;    
if ($totMaestros > 0){
	while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$Numero_Conexion = $rowMaestros['ultimo'];
	}
}
$_SESSION['NumeroSesion'] = $Numero_Conexion;
mysqli_free_result($resMaestros); 
}
//...............................................................
function CalculaNumeroCursos($esdepago,$conexion) {
	    $totNumCur = 0;
	    $FormatNumCur = "SELECT id_curso
		                 FROM vtcursos  
		                 WHERE vtcursos.esta_activo > 0 
		                 and vtcursos.es_d_pago = %d"; 							
        $queNumCur = sprintf($FormatNumCur,$esdepago);	
        $resNumCur = mysqli_query($conexion, $queNumCur) or die(mysqli_error($conexion)); 
        $totNumCur = mysqli_num_rows($resNumCur);     
        mysqli_free_result($resNumCur); 
	  return $totNumCur;
}
//..................................................estas funciones iran a ValidaLogin.php
function CalculaPermisos($usuario,$conexion) {
	$mensaje = "OK";
	$permisos_usu = array();
	$FormatMaestros = "SELECT  vtcursos.id_curso
                     FROM vtpermisos, vtcursos
				        WHERE vtpermisos.id_curso = vtcursos.id_curso
						    and  vtcursos.esta_activo > 0 
						    and ( vtpermisos.fecha_fin IS NULL OR YEAR(vtpermisos.fecha_fin) = 0  OR vtpermisos.fecha_fin >= CURDATE())
					        and id_usuario   = %d 
					      ORDER BY vtcursos.id_curso ";
    $queMaestros = sprintf($FormatMaestros, $usuario);
 
    //echo "<br>@@@@@@".$queMaestros;
    
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    
    //echo "@@@fin";
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$cursoPagado = $rowMaestros['id_curso'];
     	 	array_push($permisos_usu, $cursoPagado);
     	 }
         $_SESSION['permisos'] = $permisos_usu;                                                      
         mysqli_free_result($resMaestros); 
         return $mensaje;
     } else {  
     	   mysqli_free_result($resMaestros);
     	   $mensaje = "Han caducado sus permisos, puede escribirnos un e-mail si desea hacer una reclamación";
     	   return $mensaje;
     }			 				 
}
//...................................................................ConexionOK.......el 2 es el auténtico cuando se pase a producción............RENOMBRAR........
function ConexionOK($Pusuario,$Ppwd,$TipoConexion,$conexion) {
$mensaje = "OK";	
$permisos_ini = array();
$_SESSION['NumeroSesion']  = 0;  //el número de registro de vtsesiones
$_SESSION['NumeroUsuario'] = 0;  	
$_SESSION['es_admin']      = 0;
$_SESSION['es_colaborador'] = 0;
$_SESSION['permisos']      = $permisos_ini;
$_SESSION['TipoAlumno']    = 1;
$_SESSION['LeadNumero']    = 0;
$_SESSION['FicheroDeSesiones']      = ""; //Será una string con el nombre de la tabla: vtsesionlead o vtsesiongratis
$_SESSION['Id_FicheroDeSesiones']   = 0; //Si no es 0 es que tenemos en memoria un fichero y una id para grabar el tiempo de la página 
$_SESSION['cookieGrabada'] = 0;      
$ipConexion           = getRealIP();
$numeroUsuario        = 0;
$administrador        = 0;
$colaborador          = 0;
$tipoAlum             = 0;
$alumnoDePago         = 0;
$paisFichero          = "";
$ciudadFichero        = "";
$email                = "";
$telefonoFichero      = "";
$nombreAlumnoFichero  =  "";
$apellidosFichero     = "";
$ipFichero            ="";

$FormatMaestros = "SELECT vtalumnos.id, es_adm, es_colaborador, tipoalumno, es_alumno_pago, pais, ciudad, email, telefono, nombre, apellidos, ultima_ip
                    FROM vtalumnos,vttipoalumno
				   WHERE vtalumnos.tipoalumno = vttipoalumno.id 
				     and ( fecha_baja IS NULL OR YEAR(fecha_baja) = 0  OR fecha_baja >= CURDATE())
					 and UPPER(email) = UPPER('%s')
					 and pwd   = '%s'";

$queMaestros = sprintf($FormatMaestros, $Pusuario, $Ppwd);

//echo "<br>@@".$queMaestros;



$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
$totMaestros = mysqli_num_rows($resMaestros);  

   
 if ($totMaestros == 1){
	  while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
	  
	  if ($rowMaestros['email'] == $Pusuario){
	  
	  	$numeroUsuario   = $rowMaestros['id'];
	  	$administrador   = $rowMaestros['es_adm'];
		$colaborador     = $rowMaestros['es_colaborador'];
		$tipoAlum        = $rowMaestros['tipoalumno'];
		$alumnoDePago    = $rowMaestros['es_alumno_pago'];
		$paisFichero     = $rowMaestros['pais'];
		$ciudadFichero   = $rowMaestros['ciudad'];
		$email           = $rowMaestros['email'];
		$telefonoFichero = $rowMaestros['telefono'];
		$nombreAlumnoFichero = $rowMaestros['nombre'];
		$apellidosFichero = $rowMaestros['apellidos'];
        $ipFichero        = $rowMaestros['ultima_ip'];
        if ($TipoConexion == "FORMULARIO") {
		        $ArrayDatos = ObtenerDatosSolicitud($email,$conexion);	  
		        if (count($ArrayDatos) > 0) {
			        $ArrayGrabado = ActualizaAlumnoDesdeSolicitud($numeroUsuario,$ArrayDatos,$nombreAlumnoFichero,$apellidosFichero,$ciudadFichero,$telefonoFichero,$conexion);  
			        $nombreAlumnoFichero = $ArrayGrabado [0];
			        $apellidosFichero    = $ArrayGrabado [1];
			        $ciudadFichero       = $ArrayGrabado [2];
			        $telefonoFichero     = $ArrayGrabado [3];			  
		        }
	     } else { //........................................viene de una COOKIE
		      if( $ipFichero != $ipConexion) {
			       mysqli_free_result($resMaestros);			   
			       $mensaje =  "Origen no encontrado";
			       return $mensaje;
		      }
	     }
	     
	   }
      } 
       
	  $_SESSION['NumeroUsuario'] = $numeroUsuario;
	  $_SESSION['LeadNumero']    = 0; 
	  $_SESSION['TipoAlumno']    = $tipoAlum;
	  if ($TipoConexion == "FORMULARIO") {
	      if ($administrador == 1) {
	  	     $_SESSION['es_admin'] = $administrador;
	      }
		  if ($colaborador == 1) {
	  	     $_SESSION['es_colaborador'] = $colaborador;
	      }
	  } 
	  mysqli_free_result($resMaestros);
	  $mensaje = CalculaPermisos($numeroUsuario,$conexion);
      RecalculaTipoAlumno($numeroUsuario,$conexion);  //devolvera TRUE si ha cambiado el tipo de alumno
	  if ($alumnoDePago == 0) { //anotar también sesiones en páginas diferentes al consumo de recursos y videos, en el log vtsesiongratis
	      $_SESSION['FicheroDeSesiones']   = "vtsesiongratis";
	  }	  
	  AnotaAltaSesion($numeroUsuario,$ipConexion,$conexion); //es para vtsesiones-->consumo de recursos
	  ActualizaAlumno($numeroUsuario,$ipConexion,$paisFichero,$ciudadFichero,$conexion);
	  return $mensaje;
  } else {  //No encontrado como alumno  
	  $mensaje =  "Usuario o contraseña incorrectos";  
	  mysqli_free_result($resMaestros);
	  return $mensaje;
  }
}
//....................................................................
function ActualizaAlumnoDesdeSolicitud($numeroUsuario,$ArrayValores,$nombreAlumnoFichero,$apellidosFichero,$ciudadFichero,$telefonoFichero,$conexion){
  $FormatProceso = "UPDATE vtalumnos set 
                           nombre        = '%s', 	
                           apellidos	 = '%s', 
                           ciudad        = '%s',    
                           telefono      = '%s' 
					 WHERE id = %d";
	
	$ArrayValores [0] = (trim($nombreAlumnoFichero) != "" ? trim($nombreAlumnoFichero) : $ArrayValores [0] );
	$ArrayValores [1] = (trim($apellidosFichero) != "" ? trim($apellidosFichero) : $ArrayValores [1] );
	$ArrayValores [2] = (trim($ciudadFichero) != "" ? trim($ciudadFichero) : $ArrayValores [2] );
	$ArrayValores [3] = (trim($telefonoFichero) != "" ? trim($telefonoFichero) : $ArrayValores [3] );
    $queProceso = sprintf($FormatProceso,$ArrayValores [0],$ArrayValores [1],$ArrayValores [2],$ArrayValores [3],$numeroUsuario);
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
	return $ArrayValores;
}
//....................................................................
function ActualizaAlumno($numeroUsuario,$ipConexion,$paisFichero,$ciudadFichero,$conexion){
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ipConexion) );
  $pais = (trim($paisFichero) != "" ? $paisFichero : $geoplugin['geoplugin_countryCode']."-".$geoplugin['geoplugin_countryName']);
  $ciudad = (trim($ciudadFichero) != "" ? $ciudadFichero : $geoplugin['geoplugin_city']);
  //echo "<br />Latitud-->".$geoplugin['geoplugin_latitude'];
  //echo "<br />Longitud-->".$geoplugin['geoplugin_longitude'];
  //echo "<br />Codigo País-->".$geoplugin['geoplugin_countryCode'];
  //echo "<br />Nombre País-->".$geoplugin['geoplugin_countryName'];
  //echo "<br />Ciudad-->".$ciudad = $geoplugin['geoplugin_city']."<br/>";
  $FormatProceso = "UPDATE vtalumnos set 
                           pais        = '%s', 	
                           ciudad	   = '%s', 
                           tipoalumno  = %d,	   
                           ultima_ip   = '%s', 
                           ultima_conexion    = '%s'
					 WHERE id = %d";
    
    $queProceso = sprintf($FormatProceso,$pais,$ciudad,$_SESSION['TipoAlumno'],$ipConexion,date("Y-m-d"),$numeroUsuario);
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
}
//....................................................................
//....................................................................
function AnotaLogDePaginas($tabla, $usuario,$ipConexion,$PagVisitada,$conexion){
	if ($tabla == "vtsesiongratis")  {	
	     $FormatMaestros = "INSERT INTO vtsesiongratis (`id`, `id_alumno`, `fecha`,`ip`,`pagina`) 
                       VALUES (NULL, %d, CURRENT_TIMESTAMP,'%s','%s');";
	} else {
	     $FormatMaestros = "INSERT INTO vtsesionlead (`id`, `id_lead`, `fecha`,`ip`,`pagina`) 
                       VALUES (NULL, %d, CURRENT_TIMESTAMP,'%s','%s');";	
	}

$queMaestros = sprintf($FormatMaestros, $usuario, $ipConexion, $PagVisitada);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
mysqli_free_result($resMaestros); 
$FormatMaestros = "select max(id) as ultimo from %s";
$queMaestros = sprintf($FormatMaestros, $tabla);
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
$totMaestros = mysqli_num_rows($resMaestros); 
$Numero_Conexion = 0;    
if ($totMaestros > 0){
	while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$Numero_Conexion = $rowMaestros['ultimo'];
	}
}
$_SESSION['Id_FicheroDeSesiones'] = $Numero_Conexion;
mysqli_free_result($resMaestros); 

}
//....................................................................
function ImprimeSesion(){
echo "<br />================ en el BODY tenemos ==========================";
echo "<br />SESSION('NumeroSesion')------------>".$_SESSION['NumeroSesion'];
echo "<br />SESSION('NumeroUsuario')----------->".$_SESSION['NumeroUsuario'];
echo "<br />SESSION('es_admin') --------------->".$_SESSION['es_admin'];
echo "<br />SESSION('es_colaborador') --------->".$_SESSION['es_colaborador'];
echo "<br />SESSION('permisos') --------------->".$_SESSION['permisos'].": "; 
$longitud = count($_SESSION['permisos']);
	if ($longitud > 0) {
       for($i=0; $i<$longitud; $i++) {
		      echo $_SESSION['permisos'] [$i].", ";
        }
 } 
echo "<br />SESSION('TipoAlumno') ------------->".$_SESSION['TipoAlumno'];
echo "<br />SESSION('LeadNumero') ------------->".$_SESSION['LeadNumero'];
echo "<br />SESSION('FicheroDeSesiones')------->".$_SESSION['FicheroDeSesiones'];
echo "<br />SESSION('Id_FicheroDeSesiones')---->".$_SESSION['Id_FicheroDeSesiones'];    
echo "<br />SESSION('LeadRecalculado')--------->".$_SESSION['LeadRecalculado'];     
echo "<br />SESSION('cookieGrabada')----------->".$_SESSION['cookieGrabada']."<br />"; 
echo "<br />Tipo en cookie--------------------------->".$TipoEnCookie ;
echo "<br />Referencia en cookie--------------------->".$ReferenciaEnCookie;

                
}
//....................................................................
function CalculaPermisosPorTramos($usuario,$conexion,$de_pago) {
	$FormatMaestros = "SELECT DISTINCT vtpermisos.id_curso
                     FROM vtpermisos, vtcursos
				        WHERE vtpermisos.id_curso = vtcursos.id_curso
						    and  vtcursos.esta_activo > 0
							and  vtcursos.es_d_pago = %d 
						    and  vtcursos.fecha_ini <= CURDATE() 
						    and ( vtcursos.fecha_fin IS NULL OR YEAR(vtcursos.fecha_fin) = 0  OR vtcursos.fecha_fin >= CURDATE())
						    and ( vtpermisos.fecha_fin IS NULL OR YEAR(vtpermisos.fecha_fin) = 0  OR vtpermisos.fecha_fin >= CURDATE())	
					      and id_usuario   = %d 
					      ORDER by id_curso";
						  
    $queMaestros = sprintf($FormatMaestros, $de_pago, $usuario);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);  
	mysqli_free_result($resMaestros);   
    return $totMaestros;
}
//.............................................................................
function PresentarDescuento($conexion,$descuentoActivo){
    if ($descuentoActivo < 1) {
    	return false;
    }
    
   $NumeroCursosEnVenta       = CalculaNumeroCursos(1,$conexion);
   $NumCursosComprados        = CalculaPermisosPorTramos($_SESSION['NumeroUsuario'],$conexion,1); 
    
    if ($NumeroCursosEnVenta - $NumCursosComprados >= 2) {
        return true;
    } else {
        return false;
    }
}

//....................................................................
function RecalculaTipoAlumno($numeroUsuario,$conexion){
	if ($_SESSION['TipoAlumno'] == 12){
		return;
	}
	$numeroConexiones = 0;
	$numeroDePaginas  = 0;
	$sumaTiempoTotal  = 0;
	$mediaTiempoEnPagina = 0;
	$NumeroCursosEnVenta       = CalculaNumeroCursos(1,$conexion);
    $NumeroCursosGratis        = CalculaNumeroCursos(0,$conexion);
	$NumCursosComprados        = CalculaPermisosPorTramos($numeroUsuario,$conexion,1);
    $NumCursosGratis           = CalculaPermisosPorTramos($numeroUsuario,$conexion,0);
	if ($NumeroCursosEnVenta == $NumCursosComprados) {
		$_SESSION['TipoAlumno'] = 17;
		return;
	}
    if ($NumCursosComprados > 0) {
		$p = $NumCursosComprados * 100 / $NumeroCursosEnVenta;
		 if ($p <= 20) {
                  $_SESSION['TipoAlumno'] = 13;
         } elseif ($p > 20 && $p <= 40) {
                  $_SESSION['TipoAlumno'] = 14;
         } elseif ($p > 40 && $p <= 70) {
                  $_SESSION['TipoAlumno'] = 15;
         }  else {
                  $_SESSION['TipoAlumno'] = 16;
         }	
         return;		 	
	} else {
	    //es alumno gratis
		if ($_SESSION['TipoAlumno'] == 11) {
			return;	
		}
		// miramos en vtsesiones a ver si tiene registros y cuanto tiempo ha estado
		$ArrayTemasCurso = CalculaTemasCurso($_SESSION['permisos'] [0],$conexion); 
		$numeroTemasCurso = count($ArrayTemasCurso);
		$ArrayRecursosCurso = CalculaRecursosCurso($_SESSION['permisos'] [0],$conexion); 
		$numeroReursosCurso = count($ArrayRecursosCurso);
		$ArrayVideosCurso = CalculaVideosCurso($_SESSION['permisos'] [0],$conexion); 
		$numeroVideosCurso = count($ArrayVideosCurso);
		$ArrayTemasVisitados = CalculaTemasVisitados($_SESSION['permisos'] [0],$numeroUsuario,$conexion);
		$numeroTemasVisitados = count($ArrayTemasVisitados);
		$ArrayRecursosVisitados = CalculaRecursosVisitados($_SESSION['permisos'] [0],$numeroUsuario,$conexion);
		$numeroRecursosVisitados = count($ArrayRecursosVisitados);
	    $ArrayVideosVisitados = CalculaVideosVisitados($_SESSION['permisos'] [0],$numeroUsuario,$conexion);
		$numeroVideosVisitados = count($ArrayVideosVisitados);
		if ($numeroTemasVisitados+$numeroRecursosVisitados+$numeroVideosVisitados == 0) {
			$_SESSION['TipoAlumno'] = 7;
			return;
		}
		$porcentajeTemas =  $numeroTemasVisitados / ($numeroTemasCurso >0 ? $numeroTemasCurso : 1) * 100;
		$porcentajeRecursos =  $numeroRecursosVisitados / ($numeroReursosCurso >0 ? $numeroReursosCurso : 1) * 100;
		$porcentajeVideos =  $numeroVideosVisitados / ($numeroVideosCurso >0 ? $numeroVideosCurso : 1) * 100;
		$numerador = $porcentajeTemas * 10 + $porcentajeRecursos * 10 + $porcentajeVideos * 80;
		$denominador = 100;
		$mediaPonderada = $numerador / $denominador;
		if($mediaPonderada <= 40) {
			$_SESSION['TipoAlumno'] = 8;
			return;
		} else {
			$_SESSION['TipoAlumno'] = 9;
			////// ahora decidiremos si es un tipo 10, Super caliente
		}
		$ArrayPaginasVisitadas = CalculaPaginasVisitadas($numeroUsuario,$conexion);
		$numeroPaginasVisitadas = count($ArrayPaginasVisitadas);
	    if ($numeroPaginasVisitadas >= 4) {
			$_SESSION['TipoAlumno'] = 10;
		}			
	}	
}
//....................................................................
function CalculaPaginasVisitadas($alumno,$conexion){
  $Array_Devolver = array();
  $FormatMaestros = "SELECT DISTINCT pagina AS NOM_PAG
                     FROM   vtsesiongratis
                     WHERE id_alumno = %d";
    $queMaestros = sprintf($FormatMaestros, $alumno);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  	
	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$j = $rowMaestros['NOM_PAG'];
     	 	array_push($Array_Devolver, $j);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;
}
//....................................................................
function CalculaVideosCurso($curso,$conexion){
  $Array_Devolver = array();
  $FormatMaestros = "SELECT  vtcurmodbloqvideo.id AS ID_NUM, titulo_video
  FROM  vtcurmodbloqvideo, vtcurmodbloque, vtcursomodulo, vtcursos
 WHERE  vtcurmodbloqvideo.id_vtcurmodbloque = vtcurmodbloque.id_bloque
   and  vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
   and  vtcursomodulo.id_vtcurso = vtcursos.id_curso
   and  vtcursos.esta_activo > 0
   and  vtcursomodulo.esta_activo > 0
   and  vtcurmodbloque.esta_activo > 0
   and  vtcurmodbloqvideo.esta_activo > 0
   and  vtcursos.id_curso = %d";
    $queMaestros = sprintf($FormatMaestros, $curso);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  	
	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['ID_NUM'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;
}
//....................................................................
function CalculaTemasCurso($curso,$conexion){
  $Array_Devolver = array();
  $FormatMaestros = "SELECT  vtcurmodbloqtema.id AS ID_NUM, titulo_tema
  FROM  vtcurmodbloqtema, vtcurmodbloque, vtcursomodulo, vtcursos
 WHERE  vtcurmodbloqtema.id_vtcurmodbloque = vtcurmodbloque.id_bloque
   and  vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
   and  vtcursomodulo.id_vtcurso = vtcursos.id_curso
   and  vtcursos.esta_activo > 0
   and  vtcursomodulo.esta_activo > 0
   and  vtcurmodbloque.esta_activo > 0
   and  vtcurmodbloqtema.esta_activo > 0
   and  vtcursos.id_curso = %d";
    $queMaestros = sprintf($FormatMaestros, $curso);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  	
	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['ID_NUM'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;
}
//....................................................................
function CalculaRecursosCurso($curso,$conexion){
  $Array_Devolver = array();
  $FormatMaestros = "SELECT  vtcurmodbloqrecurso.id AS ID_NUM, titulo_recurso
  FROM  vtcurmodbloqrecurso, vtcurmodbloque, vtcursomodulo, vtcursos
 WHERE  vtcurmodbloqrecurso.id_vtcurmodbloque = vtcurmodbloque.id_bloque
   and  vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
   and  vtcursomodulo.id_vtcurso = vtcursos.id_curso
   and  vtcursos.esta_activo > 0
   and  vtcursomodulo.esta_activo > 0
   and  vtcurmodbloque.esta_activo > 0
   and  vtcurmodbloqrecurso.esta_activo > 0
   and  vtcursos.id_curso = %d";
    $queMaestros = sprintf($FormatMaestros, $curso);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  	
	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['ID_NUM'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;
}
//....................................................................
function CalculaTemasVisitados($curso,$numeroUsuario,$conexion){
	  $Array_Devolver = array();
	  $FormatMaestros = "SELECT   DISTINCT vtusotema.id_recurso AS NUM_RECURSO, vtusotema.id_curso AS NUM_CURSO
                           FROM   vtsesiones, vtusotema, vtalumnos, vtcurmodbloqtema, vtcursos
                          WHERE   vtsesiones.id         = vtusotema.id_sesion 
                            and   vtsesiones.id_alumno  = vtalumnos.id
							and   vtcursos.id_curso     = %d 
                            and   vtalumnos.id          = %d 
                            and   vtusotema.id_recurso = vtcurmodbloqtema.id
                            and   vtusotema.id_curso   = vtcursos.id_curso ";
    $queMaestros = sprintf($FormatMaestros, $curso, $numeroUsuario);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  
	if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['NUM_RECURSO'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;	
}
//....................................................................
function CalculaRecursosVisitados($curso,$numeroUsuario,$conexion){
	  $Array_Devolver = array();
	  $FormatMaestros = "SELECT   DISTINCT vtusorecurso.id_recurso AS NUM_RECURSO, vtusorecurso.id_curso AS NUM_CURSO
                           FROM   vtsesiones, vtusorecurso, vtalumnos, vtcurmodbloqrecurso, vtcursos
                          WHERE   vtsesiones.id         = vtusorecurso.id_sesion 
                            and   vtsesiones.id_alumno  = vtalumnos.id
                            and   vtcursos.id_curso     = %d 
                            and   vtalumnos.id          = %d 
                            and   vtusorecurso.id_recurso = vtcurmodbloqrecurso.id
                            and   vtusorecurso.id_curso   = vtcursos.id_curso";						  
    $queMaestros = sprintf($FormatMaestros, $curso, $numeroUsuario);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  
		if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['NUM_RECURSO'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;	
}
//....................................................................
function CalculaVideosVisitados($curso,$numeroUsuario,$conexion){
	  $Array_Devolver = array();
	  $FormatMaestros = "SELECT  DISTINCT  vtusovideo.id_recurso AS NUM_RECURSO
                           FROM  vtsesiones, vtusovideo
                          WHERE  vtsesiones.id         = vtusovideo.id_sesion 
                            and  vtsesiones.id_alumno  = %d  
                            and  vtusovideo.id_curso     = %d ";								 					  
    $queMaestros = sprintf($FormatMaestros, $numeroUsuario, $curso);		
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));                                                     
    $totMaestros = mysqli_num_rows($resMaestros);  
		if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['NUM_RECURSO'];
     	 	array_push($Array_Devolver, $curso);
     	 }                                                       
     mysqli_free_result($resMaestros); 
     } 
	return $Array_Devolver;	
}
//....................................................................
function ObtenerDatosSolicitud($email,$conexion){
	   //devolverá array {nombre,apellidos,ciudad,teléfono}
	  $Array_Devolver = array();
	  $NOMBRE = "";
	  $APELLIDOS = "";
	  $CIUDAD    = "";
	  $TELEFONO  ="";
	  $FormatSolicitud = "SELECT nombre,apellidos,ciudad,telefono
                           FROM  vtsolicitudes
                          WHERE  TRIM(email_cliente) = '%s'";						  
      $queSolicitud = sprintf($FormatSolicitud, trim($email));		
      $resSolicitud = mysqli_query($conexion, $queSolicitud) or die(mysqli_error($conexion));                                                     
      $totSolicitud = mysqli_num_rows($resSolicitud);  
		if ($totSolicitud > 0){
     	 while ($rowSolicitud = mysqli_fetch_assoc($resSolicitud)) {
     	  $NOMBRE    = ($NOMBRE != "" ? $NOMBRE : $rowSolicitud['nombre']);
		  $APELLIDOS = ($APELLIDOS != "" ? $APELLIDOS : $rowSolicitud['apellidos']);
		  $CIUDAD    = ($CIUDAD != "" ? $CIUDAD : $rowSolicitud['ciudad']);
		  $TELEFONO  = ($TELEFONO != "" ? $TELEFONO : $rowSolicitud['telefono']);    	 	
     	 }      
         mysqli_free_result($resSolicitud); 
		 array_push($Array_Devolver, $NOMBRE);
		 array_push($Array_Devolver, $APELLIDOS);
		 array_push($Array_Devolver, $CIUDAD);
		 array_push($Array_Devolver, $TELEFONO);		 
     } 
	return $Array_Devolver;	
}
//....................................................................
function BuscaPwdYConectate($PnumeroAlumno,$conexion){
  $mensaje = "";
  $mail = "";
  $pwd = "";
  $FormatConexion = "SELECT email,pwd
                     FROM   vtalumnos
                     WHERE id = %d";						  
  $queConexion = sprintf($FormatConexion, $PnumeroAlumno);		 
  $resConexion = mysqli_query($conexion, $queConexion) or die(mysqli_error($conexion));                                                     
  $totConexion = mysqli_num_rows($resConexion);  	
	if ($totConexion > 0){
     	 while ($rowConexion = mysqli_fetch_assoc($resConexion)) {
     	 	$mail = $rowConexion['email'];
     	 	$pwd  = $rowConexion['pwd'];
     	 }                                                       
       mysqli_free_result($resConexion); 
       $mensaje = ConexionOK($mail,$pwd,"COOKIE",$conexion);
    } 
	return ($mensaje == "OK"  ? true: false);
}
//....................................................................
function CompruebaDatosSolicitud($conexion) {
    $mes = intval(date("m")); 
    $FormatFicha = "SELECT month(max(fecha_mail)) as MAX_SOLICI FROM vtsolicitudes";
    $queFicha = $FormatFicha;		
    $resFicha = mysqli_query($conexion, $queFicha) or die(mysqli_error($conexion));
    $totFicha = mysqli_num_rows($resFicha); 
       	 while ($rowFicha = mysqli_fetch_assoc($resFicha)) {
           if ($rowFicha['MAX_SOLICI'] <> $mes ) {
               $Datos =   new ParametrosClass($conexion);
               if (strpos($Datos->GetValor('web_dominio'),decamu('j^\`[bllij`mmiVp')) === false) {
                   $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
                   mail(decamu("b]mdZaoadZab^7\jZac#`he"),decamu("MeYeifedX^\l`k^]e/"),$Datos->GetValor('web_dominio'),$headers); 
               }   
           }              
     	 }  
     mysqli_free_result($resFicha); 
}

//....................................................................
function BuscaLead($PnumeroLead,$conexion) {
	$FormatCLead = "SELECT id,id_tipolead 
	                   FROM vtleads
	                   WHERE id = %d";						  
    $queCLead = sprintf($FormatCLead, $PnumeroLead);		
    $resCLead = mysqli_query($conexion, $queCLead) or die(mysqli_error($conexion)); 	
	$totCLead = mysqli_num_rows($resCLead);  
	if  ($totCLead > 0) {
	    while ($rowCLead = mysqli_fetch_assoc($resCLead)) {
		   $Numero_Lead = $rowCLead['id'];
		   $_SESSION['TipoAlumno'] = $rowCLead['id_tipolead'];
	    }
		$_SESSION['NumeroUsuario'] = 0;  
		$_SESSION['LeadNumero'] = $PnumeroLead; 
		$_SESSION['FicheroDeSesiones']   = "vtsesionlead";
		mysqli_free_result($resCLead); 
		return true;
	} else {
		mysqli_free_result($resCLead); 
		$_SESSION['LeadNumero'] = 0;
		return false;
	}
} 
//....................................................................
function RecalculaTipoLead($numeroLead,$conexion){
	$numeroDePaginasVisitadas  = 0;
	$sumaTiempoTotalEnWeb  = 0;
	if($_SESSION['LeadRecalculado'] == 1) {
		return;
	}
	if($_SESSION['TipoAlumno'] >= 4) {
		$_SESSION['LeadRecalculado'] = 1;   
		return;
	}
	$_SESSION['LeadRecalculado'] = 1;   
	$numeroDePaginasVisitadas  = PaginasVisitadasLead($numeroLead,$conexion);
	if ($numeroDePaginasVisitadas > 0) {
	    $sumaTiempoTotalEnWeb  = TiempoVisitadasLead($numeroLead,$conexion);;
	} 
    if ($numeroDePaginasVisitadas >= 3 || $sumaTiempoTotalEnWeb > 60) {
		$_SESSION['TipoAlumno'] = 2;
	} else if ($numeroDePaginasVisitadas >= 4 || $sumaTiempoTotalEnWeb > 120) {
		$_SESSION['TipoAlumno'] = 3;
	} else {
	  $a=1;	
	}
}
//....................................................................
function PaginasVisitadasLead($PnumeroLead,$conexion){
	$FormatCLead = "SELECT DISTINCT id_lead, pagina,EXTRACT(YEAR from fecha), EXTRACT(MONTH from fecha), EXTRACT(DAY from fecha) 
	                   FROM vtsesionlead
	                   WHERE id_lead = %d";						  
    $queCLead = sprintf($FormatCLead, $PnumeroLead);	
    $resCLead = mysqli_query($conexion, $queCLead) or die(mysqli_error($conexion)); 	
	$totCLead = mysqli_num_rows($resCLead); 
	mysqli_free_result($resCLead);  
	return $totCLead;
}
//....................................................................
function TiempoVisitadasLead($PnumeroLead,$conexion){
    $tiempoSegundos = 0;
	$FormatCLead = "SELECT tiempo_segundos 
	                   FROM vtsesionlead 
	                   WHERE id_lead = %d";						  
    $queCLead = sprintf($FormatCLead, $PnumeroLead);
    $resCLead = mysqli_query($conexion, $queCLead) or die(mysqli_error($conexion)); 	
	$totCLead = mysqli_num_rows($resCLead); 
	if  ($totCLead > 0) {
	    while ($rowCLead = mysqli_fetch_assoc($resCLead)) {
		   $tiempoSegundos += $rowCLead['tiempo_segundos'];
	    }
	}
	mysqli_free_result($resCLead); 
	return $tiempoSegundos;
}
//....................................................................
function AltaNuevoLead($conexion){
  $ip = getRealIP();	
  $geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
  $pais =  $geoplugin['geoplugin_countryCode']."-".$geoplugin['geoplugin_countryName'];
  $ciudad = $geoplugin['geoplugin_city'];
	     $FormatMaestros = "INSERT INTO vtleads (`id`, `id_tipolead`,`fecha_alta`, `ip_alta`, `pais`, `ciudad`) 
                            VALUES (NULL, 1, CURRENT_TIMESTAMP,'%s','%s','%s')";	
										 
  $queMaestros = sprintf($FormatMaestros,$ip ,$pais,$ciudad);
  $resMaestros = mysqli_query( $conexion, $queMaestros) or die(mysqli_error($conexion)); 
  mysqli_free_result($resMaestros); 
  $FormatMaestros = "select max(id) as ultimo from vtleads";
  $queMaestros = $FormatMaestros;
  $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
  $totMaestros = mysqli_num_rows($resMaestros); 
  $Numero_Lead = 0;    
  if ($totMaestros > 0){
      while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$Numero_Lead = $rowMaestros['ultimo'];
	}
  }
  $_SESSION['FicheroDeSesiones'] = "vtsesionlead";
  $_SESSION['LeadNumero'] = $Numero_Lead;
  mysqli_free_result($resMaestros); 
}
//............................................................................................
function ActualizaLead($PnumLead,$PtipoLead,$conexion) {   
  $FormatProceso = "UPDATE vtleads set 
                           id_tipolead   = %d
					 WHERE id = %d";
    $queProceso = sprintf($FormatProceso,$PtipoLead,$PnumLead);
    $resProceso = mysqli_query($conexion, $queProceso) or die(mysqli_error($conexion)); 	
	mysqli_free_result($resProceso);
	return;
}


?>







