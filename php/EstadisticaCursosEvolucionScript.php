<?php
//////////// Funciones para mantenimiento/EstadisticaCursosEvolucion.php ////////////////////////
/////////// No tendrá en cuenta cursos desactivados, ya que un curso puede haber estado activo antes y ahora no
/////////// Son funciones de php/ValidaLoginScript.php READAPTADAS
//.......................................................

//...........................................................................
function RellenaPuntos($txt,$long) {
	$longTexto = strlen($txt);
	$relleno = "";
	if ($longTexto < $long) {
		$relleno = str_repeat(".",$long-$longTexto);
		return $txt.$relleno;
	}
	return $txt;
}
//...........................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
//...........................................................................




//...............................................................................................
function CalculaVideosCurso($curso,$conexion){
  $Array_Devolver = array();
  $FormatMaestros = "SELECT  vtcurmodbloqvideo.id AS ID_NUM, titulo_video
  FROM  vtcurmodbloqvideo, vtcurmodbloque, vtcursomodulo, vtcursos
 WHERE  vtcurmodbloqvideo.id_vtcurmodbloque = vtcurmodbloque.id_bloque
   and  vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
   and  vtcursomodulo.id_vtcurso = vtcursos.id_curso
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
function ArrayPermisos($usuario,$cusoGratis,$conexion) {
    //descontamos el curso gratis y vemos que haya estado activo el permiso durante 90 días o más
	$array = array();
	$FormatMaestros = "SELECT DISTINCT id_curso
                         FROM vtpermisos
				        WHERE id_curso <> %d 
                          AND id_usuario   = %d  
                          AND (YEAR(fecha_fin) = 0 OR DATEDIFF(fecha_fin,fecha_ini) > 90 )";
    $queMaestros = sprintf($FormatMaestros, $cusoGratis, $usuario);	
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$curso = $rowMaestros['id_curso'];
     	 	array_push($array, $curso);
     	 }   
     } 
     mysqli_free_result($resMaestros);	
	 return $array; 				 
}
//....................................................................
function UltimaConexion($usuario,$altaPermiso,$conexion) {
//si ultima_conexion => ultima_conexion, si no =>Ultimo recurso visto, si no =>fecha de alta del permiso 
    $ultimaConex = "";   
	$FormatMaestros = "SELECT ultima_conexion
                         FROM vtalumnos
				        WHERE id = %d";
    $queMaestros = sprintf($FormatMaestros, $usuario);	
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$ultimaConex = $rowMaestros['ultima_conexion'];
     	 }   
     } 
     mysqli_free_result($resMaestros);	
  	 if (!empty(ultimaConex) && $ultimaConex != "" && $ultimaConex != '0000-00-00') { 
         return $ultimaConex;
     }	    
    //............mirar en sesiones
    	$FormatMaestros = " SELECT  max(DATE(fecha_inicio)) as FECHA
                              FROM  vtsesiones
                             WHERE  id_alumno  = %d ";
    $queMaestros = sprintf($FormatMaestros, $usuario);	
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$ultimaConex = $rowMaestros['FECHA'];
     	 }   
     } 
     mysqli_free_result($resMaestros);	
  	 if (!empty(ultimaConex) && $ultimaConex != "" && $ultimaConex != '0000-00-00') {
         return $ultimaConex;
     }	
    
     //............mirar en vtpermisos, por si tiene un permiso posterior a la fecha del permiso que tratamos
    	$FormatMaestros = " SELECT  max(fecha_ini) as FECHA
                              FROM  vtpermisos
                             WHERE  id_usuario  = %d ";
    $queMaestros = sprintf($FormatMaestros, $usuario);	
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
     	 while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
     	 	$ultimaConex = $rowMaestros['FECHA'];
     	 }   
     } 
     mysqli_free_result($resMaestros);	
  	 if (!empty(ultimaConex) && $ultimaConex != "" && $ultimaConex != '0000-00-00') {
         return $ultimaConex;
     }	
    //asignar inicio del permiso, no podemos grabar una fecha vacía en vtestadiscursos
    $ultimaConex = $altaPermiso;
    return $ultimaConex;
}
//..............................................................................................................
function PintaSeleccionados($anyoIni,$anyoFin,$orden,$cursoGratis,$conexion) {
  ///.......................................................borrar registros anteriores
   	$FormatMaestros = " DELETE FROM vtestadiscursos";
    $queMaestros = sprintf($FormatMaestros);	
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    mysqli_free_result($resMaestros);	
  ///........................................................inicializar autoincremento
    $FormatMaestros = " ALTER TABLE `vtestadiscursos`
                             MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
    $queMaestros = sprintf($FormatMaestros);	
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    mysqli_free_result($resMaestros);	 
  ///......cargar la tabla de nuevo
   	$FormatRegistros = "SELECT DISTINCT id_curso, id_usuario, fecha_ini
                          FROM vtpermisos
				         WHERE YEAR(fecha_ini) >= %d 
                           and YEAR(fecha_ini) <= %d 
                        ";
    $queRegistros = sprintf($FormatRegistros, $anyoIni, $anyoFin);	  
    $resRegistros = mysqli_query($conexion, $queRegistros) or die(mysqli_error($conexion)); 
    $totRegistros = mysqli_num_rows($resRegistros);     
     if ($totRegistros > 0){
     	 while ($rowRegistros = mysqli_fetch_assoc($resRegistros)) {
     	 	$curso     = $rowRegistros['id_curso'];
     	 	$alumno    = $rowRegistros['id_usuario'];
            $fecha_ini = $rowRegistros['fecha_ini'];
            GrabaEnTabla($curso, $alumno, $fecha_ini,$cursoGratis,$conexion);   
     	 }   
     } 
     mysqli_free_result($resRegistros);	
//..........dibujar los nuevos datos cargados   
switch ($orden) {
    case "C-A":
        PintaCursoMasAnyo($conexion);
        break;
    case "A-C":
        PintaAnyoMasCurso($conexion);
        break;
    default:
        echo '<span class="rojo">Error-->No se ha pasado bien el tipo de ordenación</span><br>Debe ser C-A ó A-C<br>';
        break;
}    
     
//.....fin del procedimiento   
        
}
/////////////////////////////////////////////////////////////////////
 function EmailByNum($numAlumno,$conexion) {
	 $mail = "";
   $FormatMaestros = "SELECT email FROM vtalumnos  where  id = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $numAlumno); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   if ($totMaestros == 0) {
	   return "";
   }
    while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
		$mail = $rowRegistros['email'];
	}
	mysqli_free_result($resMaestros);  
return $mail;
 }
//......................................................................................................
function CalculaDiferenciaDias($inicial,$final){
  $date1 = new DateTime($inicial);
  $date2 = new DateTime($final);
  $diff = $date1->diff($date2);
  return $diff->days;    
}
//......................................................................................................
function GrabaEnTabla($IdCurso, $IdAlumno,$fecha_inicial,$cursoGratis,$conexion){
$email_alumno		 = EmailByNum($IdAlumno,$conexion);
$f_alta              = $fecha_inicial;
$id_curso            = $IdCurso;
$algun_curso_mas     = count(ArrayPermisos($IdAlumno,$cursoGratis,$conexion)) - 1;
$algun_curso_mas     = ($algun_curso_mas < 0 ? 0 : $algun_curso_mas);
$Pv_0                = 0;
$Pv1_20	             = 0;
$Pv_21_40            = 0;
$Pv_41_60            = 0;
$Pv_61_80            = 0;
$Pv_81_100           = 0;
$Pt_0                = 0;
$Pt1_20              = 0;
$Pt_21_40            = 0;
$Pt_41_60            = 0;
$Pt_61_80            = 0;
$Pt_81_100           = 0;
$Pr_0                = 0;
$Pr1_20              = 0;
$Pr_21_40            = 0;
$Pr_41_60            = 0;
$Pr_61_80            = 0;
$Pr_81_100	         = 0;
$f_ultimaconexion    = UltimaConexion($IdAlumno,$fecha_inicial,$conexion); 

$dias_ultimaconexion = CalculaDiferenciaDias($f_ultimaconexion,date());
//.......................videos.....................    
$NumeroVideos       = count(CalculaVideosCurso($IdCurso,$conexion));
$NumeroVideosVistos = count(CalculaVideosVisitados($IdCurso,$IdAlumno,$conexion));
$porcentajeVideos   = ceil(100 * $NumeroVideosVistos /  $NumeroVideos); 
if ($porcentajeVideos == 0) {
    $Pv_0 = 1;
} elseif ($porcentajeVideos > 0 && $porcentajeVideos <= 20) {
    $Pv1_20	= 1;
} elseif ($porcentajeVideos >= 21 && $porcentajeVideos <= 40) {
    $Pv_21_40 = 1;
} elseif ($porcentajeVideos >= 41 && $porcentajeVideos <= 60) {
    $Pv_41_60 = 1;
} elseif ($porcentajeVideos >= 61 && $porcentajeVideos <=80) {
    $Pv_61_80 = 1;
} else {
    $Pv_81_100 = 1;
}

//.......................Temas.....................    
$NumeroTemas       = count(CalculaTemasCurso($IdCurso,$conexion));
$NumeroTemasVistos = count(CalculaTemasVisitados($IdCurso,$IdAlumno,$conexion));
$porcentajeTemas   = ceil(100 * $NumeroTemasVistos /  $NumeroTemas); 
if ($porcentajeTemas == 0) {
    $Pt_0 = 1;
} elseif ($porcentajeTemas > 0 && $porcentajeTemas <= 20) {
    $Pt1_20	= 1;
} elseif ($porcentajeTemas >= 21 && $porcentajeTemas <= 40) {
    $Pt_21_40 = 1;
} elseif ($porcentajeTemas >= 41 && $porcentajeTemas <= 60) {
    $Pt_41_60 = 1;
} elseif ($porcentajeTemas >= 61 && $porcentajeTemas <=80) {
    $Pt_61_80 = 1;
} else {
    $Pt_81_100 = 1;
}
 //.......................Recursos.....................    
$NumeroRecursos       = count(CalculaRecursosCurso($IdCurso,$conexion));    
$NumeroRecursosVistos = count(CalculaRecursosVisitados($IdCurso,$IdAlumno,$conexion));    
$porcentajeRecursos   = ceil(100 * $NumeroRecursosVistos /  $NumeroRecursos);     
if ($porcentajeRecursos == 0) {
    $Pr_0 = 1;
} elseif ($porcentajeRecursos > 0 && $porcentajeRecursos <= 20) {
    $Pr1_20	= 1;
} elseif ($porcentajeRecursos >= 21 && $porcentajeRecursos <= 40) {
    $Pr_21_40 = 1;
} elseif ($porcentajeRecursos >= 41 && $porcentajeRecursos <= 60) {
    $Pr_41_60 = 1;
} elseif ($porcentajeRecursos >= 61 && $porcentajeRecursos <=80) {
    $Pr_61_80 = 1;
} else {
    $Pr_81_100 = 1;
}
    
//............................grabar en vtestadiscursos   
  $FormatInsert = "INSERT INTO vtestadiscursos ( 
                        email_alumno, 
                        f_alta,      
                        id_curso,      
                        algun_curso_mas,      
                        Pv_0,      
                        Pv1_20,      
                        Pv_21_40,      
                        Pv_41_60,      
                        Pv_61_80,      
                        Pv_81_100,      
                        Pt_0,      
                        Pt1_20,      
                        Pt_21_40,      
                        Pt_41_60,      
                        Pt_61_80,      
                        Pt_81_100,      
                        Pr_0,      
                        Pr1_20,      
                        Pr_21_40,      
                        Pr_41_60,      
                        Pr_61_80,      
                        Pr_81_100,      
                        f_ultimaconexion,      
                        dias_ultimaconexion             
                         )
                VALUES (  '%s',
                          '%s',
                           %d, 
                           %d, 
                           %d,                    
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           %d, 
                           '%s',
                           %d ) ";
    $queInsert = sprintf($FormatInsert,
                         $email_alumno,
                         $f_alta,
                         $id_curso,
                         $algun_curso_mas,
                         $Pv_0,
                         $Pv1_20,
                         $Pv_21_40,
                         $Pv_41_60,
                         $Pv_61_80,
                         $Pv_81_100,
                         $Pt_0,
                         $Pt1_20,
                         $Pt_21_40,
                         $Pt_41_60,
                         $Pt_61_80,
                         $Pt_81_100,
                         $Pr_0,
                         $Pr1_20,
                         $Pr_21_40,
                         $Pr_41_60,
                         $Pr_61_80,
                         $Pr_81_100,
                         $f_ultimaconexion,
                         $dias_ultimaconexion);	 
    $resInsert = mysqli_query($conexion, $queInsert) or die(mysqli_error($conexion)); 
    mysqli_free_result($resInsert);  
}
//...........................................................................
function  PintaAnyoMasCurso($conexion) {
    $FormatPinta = "  SELECT YEAR(f_alta) AS ANYO,
                            id_curso  AS CURSO,
                            count(email_alumno) AS ALUMNOS,
                            CEILING(sum(algun_curso_mas)/count(email_alumno)) AS MAS_CURSOS,
                            CEILING(sum(Pv_0)/count(email_alumno)*100) AS PV0,
                            CEILING(sum(Pv1_20)/count(email_alumno)*100) AS PV1_20,
                            CEILING(sum(Pv_21_40)/count(email_alumno)*100) AS PV21_40,
                            CEILING(sum(Pv_41_60)/count(email_alumno)*100) AS PV41_60,
                            CEILING(sum(Pv_61_80)/count(email_alumno)*100) AS PV61_80,
                            CEILING(sum(Pv_81_100)/count(email_alumno)*100) AS PV81_100,
                            CEILING(sum(Pt_0)/count(email_alumno)*100) AS PT0,
                            CEILING(sum(Pt1_20)/count(email_alumno)*100) AS PT1_20,
                            CEILING(sum(Pt_21_40)/count(email_alumno)*100) AS PT21_40,
                            CEILING(sum(Pt_41_60)/count(email_alumno)*100) AS PT41_60,
                            CEILING(sum(Pt_61_80)/count(email_alumno)*100) AS PT61_80,
                            CEILING(sum(Pt_81_100)/count(email_alumno)*100) AS PT81_100, 
                            CEILING(sum(Pr_0)/count(email_alumno)*100) AS PR0,
                            CEILING(sum(Pr1_20)/count(email_alumno)*100) AS PR1_20,
                            CEILING(sum(Pr_21_40)/count(email_alumno)*100) AS PR21_40,
                            CEILING(sum(Pr_41_60)/count(email_alumno)*100) AS PR41_60,
                            CEILING(sum(Pr_61_80)/count(email_alumno)*100) AS PR61_80,
                            CEILING(sum(Pr_81_100)/count(email_alumno)*100) AS PR81_100,
                            CEILING(sum(dias_ultimaconexion)/count(email_alumno)) AS DIASUCONEX
                      FROM  vtestadiscursos
                  GROUP BY YEAR(f_alta), id_curso  
                  ORDER BY YEAR(f_alta), id_curso";
   $quePinta = $FormatPinta; 
   $resPinta = mysqli_query($conexion, $quePinta) or die(mysqli_error($conexion));
   $totPinta = mysqli_num_rows($resPinta);
   echo PintaCabeceras("ANYO");
   $n = 0;
   $control = "";
   while ($rowPinta = mysqli_fetch_assoc($resPinta)) {
   	$n++;	   
		if ($control != $rowPinta['ANYO'] && $n != 1) {
 		   echo PintaTotalesAnyo($control,$conexion);
		} 
    echo PintaRegistro($rowPinta,"ANYO"); 
   	$control = $rowPinta['ANYO'];	
	}
    echo PintaTotalesAnyo($control,$conexion);
    echo PintaTotales($conexion);
	mysqli_free_result($resPinta);      
}
//...........................................................................
function PintaCabeceras($agrupacion) {
if ($agrupacion == "ANYO") {
    $literal1 = "AÑO";
    $literal2 = "CURSO";
} else {
    $literal1 = "CURSO";
    $literal2 = "AÑO";
}
$devolver  = '<div class="EstEvCabecera">';
$devolver .= '<div class="EstEvNumericC">'.$literal1.'</div> ';
$devolver .= '<div class="EstEvNumericC">'.$literal2.'</div> ';
$devolver .= '<div class="EstEvNumericC">PERMISOS</div> ';
$devolver .= '<div class="EstEvNumericC">+CURSOS</div> ';
$devolver .= '<div class="EstEvNumericVidC">%V 0</div> ';
$devolver .= '<div class="EstEvNumericVidC">%V 1_20</div> ';
$devolver .= '<div class="EstEvNumericVidC">%V 21_40</div> ';
$devolver .= '<div class="EstEvNumericVidC">%V 41_60</div> ';
$devolver .= '<div class="EstEvNumericVidC">%V 61_80</div> ';
$devolver .= '<div class="EstEvNumericVidC">%V 81_100</div> ';
$devolver .= '<div class="EstEvNumericTemC">%T 0</div> ';
$devolver .= '<div class="EstEvNumericTemC">%T 1_20</div> ';
$devolver .= '<div class="EstEvNumericTemC">%T 21_40</div> ';                              
$devolver .= '<div class="EstEvNumericTemC">%T 41_60</div> ';                              
$devolver .= '<div class="EstEvNumericTemC">%T 61_80</div> ';
$devolver .= '<div class="EstEvNumericTemC">%T 81_100</div> ';
$devolver .= '<div class="EstEvNumericRecC">%R 0</div> ';
$devolver .= '<div class="EstEvNumericRecC">%R 1_20</div> ';
$devolver .= '<div class="EstEvNumericRecC">%R 21_40</div> ';
$devolver .= '<div class="EstEvNumericRecC">%R 41_60</div> ';
$devolver .= '<div class="EstEvNumericRecC">%R 61_80</div> ';
$devolver .= '<div class="EstEvNumericRecC">%R 81_100</div> ';
$devolver .= '<div class="EstEvNumericC">DIASUCONEX</div> ';
$devolver .= '</div><div class="clear"></div>';
return $devolver; 
}
//...................................................................
function PintaRegistro($row,$agrupacion) {   
$devolver  = '<div class="EstEvFila">';
if ($agrupacion == "ANYO") {
    $devolver .= '<div class="EstEvNumericD">'.$row['ANYO'].'</div>' ;                                
    $devolver .= '<div class="EstEvNumericD">'.$row['CURSO'].'</div>' ; 
} else {
    $devolver .= '<div class="EstEvNumericD">'.$row['CURSO'].'</div>' ; 
    $devolver .= '<div class="EstEvNumericD">'.$row['ANYO'].'</div>' ;    
}     
        
$devolver .= '<div class="EstEvNumericD">'.NoZero($row['ALUMNOS']).'</div>' ;                       
$devolver .= '<div class="EstEvNumericD">'.NoZero($row['MAS_CURSOS']).'</div>' ;                    
$devolver .= '<div class="EstEvNumericVidD">'.NoZero($row['PV0']).'</div>' ;                           
$devolver .= '<div class="EstEvNumericVidD">'.NoZero($row['PV1_20']).'</div>' ;                        
$devolver .= '<div class="EstEvNumericVidD">'.NoZero($row['PV21_40']).'</div>' ;                       
$devolver .= '<div class="EstEvNumericVidD">'.NoZero($row['PV41_60']).'</div>' ;                       
$devolver .= '<div class="EstEvNumericVidD">'.NoZero($row['PV61_80']).'</div>' ;                       
$devolver .= '<div class="EstEvNumericVidD">'.NoZero($row['PV81_100']).'</div>' ;                      
$devolver .= '<div class="EstEvNumericTemD">'.NoZero($row['PT0']).'</div>' ;                           
$devolver .= '<div class="EstEvNumericTemD">'.NoZero($row['PT1_20']).'</div>' ;                        
$devolver .= '<div class="EstEvNumericTemD">'.NoZero($row['PT21_40']).'</div>';                       
$devolver .= '<div class="EstEvNumericTemD">'.NoZero($row['PT41_60']).'</div>';                       
$devolver .= '<div class="EstEvNumericTemD">'.NoZero($row['PT61_80']).'</div>';                       
$devolver .= '<div class="EstEvNumericTemD">'.NoZero($row['PT81_100']).'</div>';                      
$devolver .= '<div class="EstEvNumericRecD">'.NoZero($row['PR0']).'</div>';                           
$devolver .= '<div class="EstEvNumericRecD">'.NoZero($row['PR1_20']).'</div>';                        
$devolver .= '<div class="EstEvNumericRecD">'.NoZero($row['PR21_40']).'</div>';                       
$devolver .= '<div class="EstEvNumericRecD">'.NoZero($row['PR41_60']).'</div>';                       
$devolver .= '<div class="EstEvNumericRecD">'.NoZero($row['PR61_80']).'</div>';                       
$devolver .= '<div class="EstEvNumericRecD">'.NoZero($row['PR81_100']).'</div>';                      
$devolver .= '<div class="EstEvNumericD">'.NoZero($row['DIASUCONEX']).'</div>';                    
$devolver .= '</div><div class="clear"></div>';

return $devolver;
} 
//.................................................................................
function PintaTotalesAnyo($anyo, $conexion) {
     $FormatTotal = "  SELECT YEAR(f_alta) AS ANYO,
                            count(email_alumno) AS ALUMNOS,
                            CEILING(sum(algun_curso_mas)/count(email_alumno)) AS MAS_CURSOS,
                            CEILING(sum(Pv_0)/count(email_alumno)*100) AS PV0,
                            CEILING(sum(Pv1_20)/count(email_alumno)*100) AS PV1_20,
                            CEILING(sum(Pv_21_40)/count(email_alumno)*100) AS PV21_40,
                            CEILING(sum(Pv_41_60)/count(email_alumno)*100) AS PV41_60,
                            CEILING(sum(Pv_61_80)/count(email_alumno)*100) AS PV61_80,
                            CEILING(sum(Pv_81_100)/count(email_alumno)*100) AS PV81_100,
                            CEILING(sum(Pt_0)/count(email_alumno)*100) AS PT0,
                            CEILING(sum(Pt1_20)/count(email_alumno)*100) AS PT1_20,
                            CEILING(sum(Pt_21_40)/count(email_alumno)*100) AS PT21_40,
                            CEILING(sum(Pt_41_60)/count(email_alumno)*100) AS PT41_60,
                            CEILING(sum(Pt_61_80)/count(email_alumno)*100) AS PT61_80,
                            CEILING(sum(Pt_81_100)/count(email_alumno)*100) AS PT81_100, 
                            CEILING(sum(Pr_0)/count(email_alumno)*100) AS PR0,
                            CEILING(sum(Pr1_20)/count(email_alumno)*100) AS PR1_20,
                            CEILING(sum(Pr_21_40)/count(email_alumno)*100) AS PR21_40,
                            CEILING(sum(Pr_41_60)/count(email_alumno)*100) AS PR41_60,
                            CEILING(sum(Pr_61_80)/count(email_alumno)*100) AS PR61_80,
                            CEILING(sum(Pr_81_100)/count(email_alumno)*100) AS PR81_100,
                            CEILING(sum(dias_ultimaconexion)/count(email_alumno)) AS DIASUCONEX
                      FROM  vtestadiscursos
                      WHERE YEAR(f_alta) = %d
                      GROUP BY YEAR(f_alta)";
   $queTotal = sprintf($FormatTotal, $anyo); 
   $resTotal = mysqli_query($conexion, $queTotal) or die(mysqli_error($conexion));
   $totTotal = mysqli_num_rows($resTotal);
   while ($rowTotal = mysqli_fetch_assoc($resTotal)) {
     $devolver  = '<div class="EstEvFila">';
     $devolver .= '<div class="EstEvNumericS">'.$anyo.'</div>' ;                                
     $devolver .= '<div class="EstEvNumericS">'.NoZero(0).'</div>' ; 
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['ALUMNOS']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['MAS_CURSOS']).'</div>' ;                    
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV0']).'</div>' ;                           
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV1_20']).'</div>' ;                        
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV21_40']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV41_60']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV61_80']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV81_100']).'</div>' ;                      
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT0']).'</div>' ;                           
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT1_20']).'</div>' ;                        
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT21_40']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT41_60']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT61_80']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT81_100']).'</div>';                      
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR0']).'</div>';                           
     $devolver .= '<div class="EstEvNumericRecS"> '.NoZero($rowTotal['PR1_20']).'</div>';                        
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR21_40']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR41_60']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR61_80']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR81_100']).'</div>';                      
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['DIASUCONEX']).'</div>';                    
     $devolver .= '</div><div class="clear"></div>';	
	}
	mysqli_free_result($resTotal);  
  return $devolver;
}
//.................................................................................
function PintaTotales($conexion) {
     $FormatTotal = "  SELECT count(email_alumno) AS ALUMNOS,
                            CEILING(sum(algun_curso_mas)/count(email_alumno)) AS MAS_CURSOS,
                            CEILING(sum(Pv_0)/count(email_alumno)*100) AS PV0,
                            CEILING(sum(Pv1_20)/count(email_alumno)*100) AS PV1_20,
                            CEILING(sum(Pv_21_40)/count(email_alumno)*100) AS PV21_40,
                            CEILING(sum(Pv_41_60)/count(email_alumno)*100) AS PV41_60,
                            CEILING(sum(Pv_61_80)/count(email_alumno)*100) AS PV61_80,
                            CEILING(sum(Pv_81_100)/count(email_alumno)*100) AS PV81_100,
                            CEILING(sum(Pt_0)/count(email_alumno)*100) AS PT0,
                            CEILING(sum(Pt1_20)/count(email_alumno)*100) AS PT1_20,
                            CEILING(sum(Pt_21_40)/count(email_alumno)*100) AS PT21_40,
                            CEILING(sum(Pt_41_60)/count(email_alumno)*100) AS PT41_60,
                            CEILING(sum(Pt_61_80)/count(email_alumno)*100) AS PT61_80,
                            CEILING(sum(Pt_81_100)/count(email_alumno)*100) AS PT81_100, 
                            CEILING(sum(Pr_0)/count(email_alumno)*100) AS PR0,
                            CEILING(sum(Pr1_20)/count(email_alumno)*100) AS PR1_20,
                            CEILING(sum(Pr_21_40)/count(email_alumno)*100) AS PR21_40,
                            CEILING(sum(Pr_41_60)/count(email_alumno)*100) AS PR41_60,
                            CEILING(sum(Pr_61_80)/count(email_alumno)*100) AS PR61_80,
                            CEILING(sum(Pr_81_100)/count(email_alumno)*100) AS PR81_100,
                            CEILING(sum(dias_ultimaconexion)/count(email_alumno)) AS DIASUCONEX
                      FROM  vtestadiscursos";
   $queTotal = $FormatTotal; 
   $resTotal = mysqli_query($conexion, $queTotal) or die(mysqli_error($conexion));
   $totTotal = mysqli_num_rows($resTotal);
   while ($rowTotal = mysqli_fetch_assoc($resTotal)) {
     $devolver  = '<div class="EstEvFila">';
     $devolver .= '<div class="EstEvNumericS">'.'TOTAL'.'</div>' ;                                
     $devolver .= '<div class="EstEvNumericS">'.NoZero(0).'</div>' ; 
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['ALUMNOS']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['MAS_CURSOS']).'</div>' ;                    
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV0']).'</div>' ;                           
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV1_20']).'</div>' ;                        
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV21_40']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV41_60']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV61_80']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV81_100']).'</div>' ;                      
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT0']).'</div>' ;                           
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT1_20']).'</div>' ;                        
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT21_40']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT41_60']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT61_80']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT81_100']).'</div>';                      
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR0']).'</div>';                           
     $devolver .= '<div class="EstEvNumericRecS"> '.NoZero($rowTotal['PR1_20']).'</div>';                        
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR21_40']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR41_60']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR61_80']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR81_100']).'</div>';                      
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['DIASUCONEX']).'</div>';                    
     $devolver .= '</div><div class="clear"></div>';	
	}
	mysqli_free_result($resTotal);  
  return $devolver;
}
//.........................................................................
function  PintaCursoMasAnyo($conexion) {
    $FormatPinta = "  SELECT id_curso  AS CURSO,
                             YEAR(f_alta) AS ANYO,
                            count(email_alumno) AS ALUMNOS,
                            CEILING(sum(algun_curso_mas)/count(email_alumno)) AS MAS_CURSOS,
                            CEILING(sum(Pv_0)/count(email_alumno)*100) AS PV0,
                            CEILING(sum(Pv1_20)/count(email_alumno)*100) AS PV1_20,
                            CEILING(sum(Pv_21_40)/count(email_alumno)*100) AS PV21_40,
                            CEILING(sum(Pv_41_60)/count(email_alumno)*100) AS PV41_60,
                            CEILING(sum(Pv_61_80)/count(email_alumno)*100) AS PV61_80,
                            CEILING(sum(Pv_81_100)/count(email_alumno)*100) AS PV81_100,
                            CEILING(sum(Pt_0)/count(email_alumno)*100) AS PT0,
                            CEILING(sum(Pt1_20)/count(email_alumno)*100) AS PT1_20,
                            CEILING(sum(Pt_21_40)/count(email_alumno)*100) AS PT21_40,
                            CEILING(sum(Pt_41_60)/count(email_alumno)*100) AS PT41_60,
                            CEILING(sum(Pt_61_80)/count(email_alumno)*100) AS PT61_80,
                            CEILING(sum(Pt_81_100)/count(email_alumno)*100) AS PT81_100, 
                            CEILING(sum(Pr_0)/count(email_alumno)*100) AS PR0,
                            CEILING(sum(Pr1_20)/count(email_alumno)*100) AS PR1_20,
                            CEILING(sum(Pr_21_40)/count(email_alumno)*100) AS PR21_40,
                            CEILING(sum(Pr_41_60)/count(email_alumno)*100) AS PR41_60,
                            CEILING(sum(Pr_61_80)/count(email_alumno)*100) AS PR61_80,
                            CEILING(sum(Pr_81_100)/count(email_alumno)*100) AS PR81_100,
                            CEILING(sum(dias_ultimaconexion)/count(email_alumno)) AS DIASUCONEX
                      FROM  vtestadiscursos
                  GROUP BY  id_curso ,YEAR(f_alta)
                  ORDER BY  id_curso ,YEAR(f_alta)";
   $quePinta = $FormatPinta; 
   $resPinta = mysqli_query($conexion, $quePinta) or die(mysqli_error($conexion));
   $totPinta = mysqli_num_rows($resPinta);
   echo PintaCabeceras("CURSO");
   $n = 0;
   $control = "";
   while ($rowPinta = mysqli_fetch_assoc($resPinta)) {
   	$n++;	   
		if ($control != $rowPinta['CURSO'] && $n != 1) {
 		   echo PintaTotalesCurso($control,$conexion);
		} 
    echo PintaRegistro($rowPinta,"CURSO"); 
   	$control = $rowPinta['CURSO'];	
	}
    echo PintaTotalesCurso($control,$conexion);
    echo PintaTotales($conexion);
	mysqli_free_result($resPinta);      
}
//.........................................................................................
function PintaTotalesCurso($numCurso, $conexion) {
     $FormatTotal = "  SELECT id_curso  AS CURSO,
                            count(email_alumno) AS ALUMNOS,
                            CEILING(sum(algun_curso_mas)/count(email_alumno)) AS MAS_CURSOS,
                            CEILING(sum(Pv_0)/count(email_alumno)*100) AS PV0,
                            CEILING(sum(Pv1_20)/count(email_alumno)*100) AS PV1_20,
                            CEILING(sum(Pv_21_40)/count(email_alumno)*100) AS PV21_40,
                            CEILING(sum(Pv_41_60)/count(email_alumno)*100) AS PV41_60,
                            CEILING(sum(Pv_61_80)/count(email_alumno)*100) AS PV61_80,
                            CEILING(sum(Pv_81_100)/count(email_alumno)*100) AS PV81_100,
                            CEILING(sum(Pt_0)/count(email_alumno)*100) AS PT0,
                            CEILING(sum(Pt1_20)/count(email_alumno)*100) AS PT1_20,
                            CEILING(sum(Pt_21_40)/count(email_alumno)*100) AS PT21_40,
                            CEILING(sum(Pt_41_60)/count(email_alumno)*100) AS PT41_60,
                            CEILING(sum(Pt_61_80)/count(email_alumno)*100) AS PT61_80,
                            CEILING(sum(Pt_81_100)/count(email_alumno)*100) AS PT81_100, 
                            CEILING(sum(Pr_0)/count(email_alumno)*100) AS PR0,
                            CEILING(sum(Pr1_20)/count(email_alumno)*100) AS PR1_20,
                            CEILING(sum(Pr_21_40)/count(email_alumno)*100) AS PR21_40,
                            CEILING(sum(Pr_41_60)/count(email_alumno)*100) AS PR41_60,
                            CEILING(sum(Pr_61_80)/count(email_alumno)*100) AS PR61_80,
                            CEILING(sum(Pr_81_100)/count(email_alumno)*100) AS PR81_100,
                            CEILING(sum(dias_ultimaconexion)/count(email_alumno)) AS DIASUCONEX
                      FROM  vtestadiscursos
                      WHERE id_curso = %d
                      GROUP BY id_curso";
   $queTotal = sprintf($FormatTotal, $numCurso); 
   $resTotal = mysqli_query($conexion, $queTotal) or die(mysqli_error($conexion));
   $totTotal = mysqli_num_rows($resTotal);
   while ($rowTotal = mysqli_fetch_assoc($resTotal)) {
     $devolver  = '<div class="EstEvFila">';
     $devolver .= '<div class="EstEvNumericS">'.$numCurso.'</div>' ;                                
     $devolver .= '<div class="EstEvNumericS">'.NoZero(0).'</div>' ; 
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['ALUMNOS']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['MAS_CURSOS']).'</div>' ;                    
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV0']).'</div>' ;                           
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV1_20']).'</div>' ;                        
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV21_40']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV41_60']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV61_80']).'</div>' ;                       
     $devolver .= '<div class="EstEvNumericVidS">'.NoZero($rowTotal['PV81_100']).'</div>' ;                      
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT0']).'</div>' ;                           
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT1_20']).'</div>' ;                        
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT21_40']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT41_60']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT61_80']).'</div>';                       
     $devolver .= '<div class="EstEvNumericTemS">'.NoZero($rowTotal['PT81_100']).'</div>';                      
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR0']).'</div>';                           
     $devolver .= '<div class="EstEvNumericRecS"> '.NoZero($rowTotal['PR1_20']).'</div>';                        
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR21_40']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR41_60']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR61_80']).'</div>';                       
     $devolver .= '<div class="EstEvNumericRecS">'.NoZero($rowTotal['PR81_100']).'</div>';                      
     $devolver .= '<div class="EstEvNumericS">'.NoZero($rowTotal['DIASUCONEX']).'</div>';                    
     $devolver .= '</div><div class="clear"></div>';	
	}
	mysqli_free_result($resTotal);  
  return $devolver;
}

?>