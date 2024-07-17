<?php
//...Si Desglose = 0 sólo calculamos totales 
//...Si TipoQuery = 0 es para probar cartas
//...Si TipoQuery <> 0 y desglose = 1 grabamos el registro de cabecera de la carta en vtcartascabecera y los registros de alumnos en vtcartasregistros
// sólo se pueden enviar de 100 en 100 cada 15 minutos. Cuando el administrador se conecte miraremos si quedan pendientes envíos de cartas, lo notificaremos en el menú gestión
// el fichero vtcartasregistros tendrá un index unique id_alumno+id_carta para intentar no repetir envíos
include_once('../conexion/conn_bbdd.php');
require_once('CartasPromocionalesSeleccionarScript.php');
//....obtenemos el id del alumno de pruebas para añadirlo al final de cada lote y poder comprobar si se envía cada lote
$idAlumnoPruebas = ObtenerIDPruebas($conexion,ObtenerMailPruebas($conexion));
$maxCartasLote = 100;
//...... proceso de la página
switch ($_REQUEST['TipoQuery']) {
    case 0:   //...........................................................select0 = Probar correo (pasamos de la id obtenida anteriormente, sólo en este caso)
        $SELECT_previa = "SELECT id FROM vtalumnos WHERE email = '%s'";
        $SELECT = sprintf($SELECT_previa, ObtenerMailParaProbar($conexion));
        break;
    case 1:   //...........................................................Tienen ALGUNO de los seleccionados y NINGUNO más (A ó B y ninguno más) 
        $SELECT_previa = "SELECT DISTINCT A.id_usuario AS id
                            FROM vtpermisos A, vtcursos B
				           WHERE A.id_curso = B.id_curso
						     and  B.esta_activo > 0 
					         and B.id_curso IN  %s 
					         and NOT EXISTS (SELECT C.id_usuario
                                               FROM vtpermisos C, vtcursos D
				                              WHERE C.id_curso = D.id_curso
				                                and A.id_usuario = C.id_usuario
						                        and D.esta_activo > 0 
					                            and C.id_curso IN  %s ) 
					    ORDER BY A.id_usuario";
        $SELECT = sprintf($SELECT_previa, $_REQUEST['Seleccionados'], $_REQUEST['NoSeleccionados']);
        break;
    case 2:  //..........................................................Tienen TODOS los seleccionados y NINGUNO más (A y B y ninguno más)
        $SELECT_previa = TodosCursosSeleccionados($conexion);
        $SELECT_previa= $SELECT_previa." and NOT EXISTS (SELECT H.id_usuario
                                               FROM vtpermisos H, vtcursos I
				                              WHERE H.id_curso = I.id_curso
				                                and A.id_usuario = H.id_usuario
						                        and I.esta_activo > 0 
					                            and H.id_curso IN  %s ) 
                                                ORDER BY A.id_usuario";
        $SELECT = sprintf($SELECT_previa, $_REQUEST['NoSeleccionados']);
        break;
    case 3:   //..........................................................Tienen ALGUNO los seleccionados y otros MÁS (A ó B y alguno más) 
        $SELECT_previa = "SELECT DISTINCT vtpermisos.id_usuario AS id
                            FROM vtpermisos, vtcursos
				           WHERE vtpermisos.id_curso = vtcursos.id_curso
						     and vtcursos.esta_activo > 0 
					         and vtpermisos.id_curso IN  %s 
					       ORDER BY id_usuario";
        $SELECT = sprintf($SELECT_previa, $_REQUEST['Seleccionados']);
        break;
    case 4:  //..........................................................Tienen TODOS los seleccionados y otros MÁS (A y B y alguno más) 
        $SELECT = TodosCursosSeleccionados($conexion)." ORDER BY A.id_usuario";
        break;    
    case 5:  //..........................................................NO tienen los seleccionados
        $SELECT_previa = "SELECT DISTINCT A.id_usuario AS id
                            FROM vtpermisos A, vtcursos B
				           WHERE A.id_curso = B.id_curso
						     and B.esta_activo > 0
					         and NOT EXISTS (SELECT C.id_usuario
                                               FROM vtpermisos C, vtcursos D
				                              WHERE C.id_curso = D.id_curso
				                                and A.id_usuario = C.id_usuario
						                        and D.esta_activo > 0 
					                            and C.id_curso IN  %s ) 
					    ORDER BY  A.id_usuario";
        $SELECT = sprintf($SELECT_previa, $_REQUEST['Seleccionados']);
        break;
}
$idsEncontradas = array();
$numeroCabecera = 0;
$contador       = 0;   
$formatContar = "SELECT count(id) as contador FROM (".$SELECT.") AS X";  //contar los alumnos. 
$queContar = $formatContar;
/*echo "<br>********************";
		  echo $queContar;	  
echo "<br>********************";*/
$resContar = mysqli_query($conexion, $queContar) or die(mysqli_error($conexion));  
    $totContar = mysqli_num_rows($resContar);
    while ($rowContar = mysqli_fetch_assoc($resContar)) {
		$contador =  $rowContar['contador'];                       
	}
    mysqli_free_result($resContar); 
if ($_REQUEST['DesgloseRegistros'] == 1 && $_REQUEST['TipoQuery'] > 0) {  //....grabar la cabecera de la carta en vtcartascabecera
	
      $numeroCabecera =  GrabaCabeceraCarta($conexion,$contador,$SELECT); 
}
array_push($idsEncontradas, $numeroCabecera);                 //..en el array [0] grabamos el número de cabecera de la carta 
array_push($idsEncontradas, $contador);                       //..en el array [1] grabamos el total alumnos afectados
array_push($idsEncontradas, str_replace(array("\n", "\r", "\t"), "", $SELECT)); //..en el array [2] grabamos la select

if ($_REQUEST['DesgloseRegistros'] == 1) {
     
    //.......añadir la ID de los alumnos 
    $formatSeleccion = $SELECT;
    $queSeleccion = $formatSeleccion;
		  //echo $queSeleccion;	  
    $resSeleccion = mysqli_query($conexion, $queSeleccion) or die(mysqli_error($conexion));  
    $totSeleccion = mysqli_num_rows($resSeleccion); 
    $nn = 0;
	while ($rowSeleccion = mysqli_fetch_assoc($resSeleccion)) {
        $nn++;
        if ($nn <= $maxCartasLote) {
		 //array_push($idsEncontradas, $rowSeleccion['id']);   //..en el array [2+n] grabamos los 15 primeros alumnos y les enviamos la carta .... ya no lo hacemos, todo lo gestionará el reenvío de cartas
        }
        if ($_REQUEST['TipoQuery'] != 0) {  //.....todos los afectados los grabamos en la tabla vtcartasregistros y ya enviaremos las cartas 
           InsertaCartaAlumno($numeroCabecera, $rowSeleccion['id'],$conexion) ;
        }
	}
    mysqli_free_result($resSeleccion); 
    //....añadimos el id de pruebas al final de cada lote para comprobar si se envía, al menos, el último e-mail
    
}


//..... volcamos el array en la página
echo $idsEncontradas[0];
for ($i=1; $i < count($idsEncontradas); $i++) {
   echo "#".$idsEncontradas[$i]; 
}   
//echo json_encode($idsEncontradas);
//sleep(12);  //  esperamos para reenganchar con función reenvío y no nos de bloqueo
exit;
//..........................................................................................
function comas($cadena) {
  return '"'.$cadena.'"';
}
//..........................................................................................

function ObtenerMailParaProbar($conexion){
//.....obtener el correo secundario para no inundar de emails el correo principal
      $MailSecundario = "";
			$FormatCorreo2 = "SELECT correoelectronico 
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
//..........................................................................................
function TodosCursosSeleccionados($conexion){
    $Cadena = $_REQUEST['Seleccionados'];
    $Cadena = str_replace("(","",$Cadena);
    $Cadena = str_replace(")","",$Cadena);
    $ArrayCursos = explode(",",$Cadena);
    $selectParcial = " and   EXISTS (SELECT C4.id_usuario
                                      FROM vtpermisos C4, vtcursos D4
				                     WHERE C4.id_curso = D4.id_curso
				                       and A.id_usuario = C4.id_usuario
						               and D4.esta_activo > 0 
					                   and C4.id_curso = %d ) ";
    
    $selectInicial ="SELECT DISTINCT A.id_usuario AS id
                        FROM vtpermisos A
				       WHERE EXISTS (SELECT C.id_usuario
                                        FROM vtpermisos C, vtcursos D
				                       WHERE C.id_curso = D.id_curso
				                         and A.id_usuario = C.id_usuario
						                 and D.esta_activo > 0 
					                     and C.id_curso = %d ) ";
    $selectInicial = sprintf($selectInicial,$ArrayCursos[0]);
    for($i=1; $i<count($ArrayCursos); $i++) {
        $selectTmp = str_replace("4",trim($ArrayCursos[$i]),$selectParcial);
        $selectTmp = sprintf($selectTmp,$ArrayCursos[$i]);
        $selectInicial = $selectInicial.$selectTmp;     
    }
    return $selectInicial;    
}

/////////////////////////////////////////////////////////////////////////////////////////
function GrabaCabeceraCarta($conexion,$contador,$query) {
    $NumeroAlta = 0;
    $FormatAlta = "INSERT INTO  vtcartascabecera (fichero, f_creacion, asunto, afegirnombre, seleccion, tienen,  notienen ,numalumnos,query)
                        VALUES ('%s','%s','%s','%s','%s','%s','%s',%d,'%s');";
    $queAlta = sprintf($FormatAlta, $_REQUEST['Carta'], date("Y-m-d"), $_REQUEST['Asunto'], $_REQUEST['AfegirNom'], $_REQUEST['TipoSelect'], $_REQUEST['Seleccionados'], $_REQUEST['NoSeleccionados'], $contador,$query);
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    mysqli_free_result($resAlta); 
    
    //.....................................ultima ID
    $FormatUltimaId = "SELECT max(id) AS ULTIMAID FROM vtcartascabecera";
    $queUltimaId = $FormatUltimaId;
    $resUltimaId = mysqli_query($conexion, $queUltimaId) or die(mysqli_error($conexion));  
    $totUltimaId = mysqli_num_rows($resUltimaId);     
	   while ($rowUltimaId = mysqli_fetch_assoc($resUltimaId)) {
		  $NumeroAlta = $rowUltimaId['ULTIMAID']; 	 	         
	   }
    mysqli_free_result($resUltimaId);
    return $NumeroAlta;  
}
/////////////////////////////////////////////////////////////////////////////////////////
function InsertaCartaAlumno($carta, $alumno,$conexion) {
    $FormatAlta = "INSERT INTO  vtcartasregistros (id_carta, id_alumno)
                        VALUES (%d, %d);";
    $queAlta = sprintf($FormatAlta, $carta, $alumno);
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    mysqli_free_result($resAlta); 
}
?>
