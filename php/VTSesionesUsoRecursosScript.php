<?php
///////////////////////////////////////////////////////////////
function InsertaUsoRecurso($tipo_recurso,$id_recurso,$conexion) {
if ($_SESSION['es_admin'] == 1) {
 return;	
}
	
$tabla = "";
if ($tipo_recurso == "V") {
	$tabla = "vtusovideo";
}
if ($tipo_recurso == "T") {
	$tabla = "vtusotema";
}	
if ($tipo_recurso == "R") {
	$tabla = "vtusorecurso";
}	
if ($tabla == "") {
    return;	
}
// hay que comprobar si está definida la sesión para anotar el uso del recurso
if (isset($_SESSION['NumeroSesion']) && $_SESSION['NumeroSesion'] !=0  ) {      
    $FormatMaestros = "INSERT INTO %s (`id`, `id_sesion`, `id_curso`, `id_recurso`, `fecha`) 
                       VALUES (NULL, %d, '%d', %d, CURRENT_TIMESTAMP);";
    $queMaestros = sprintf($FormatMaestros, $tabla, $_SESSION['NumeroSesion'],$_SESSION['NumeroCurso'],$id_recurso);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
    mysqli_free_result($resMaestros);
}
    
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function CTRConexiones($conexion) {
	$fecha_ctr = "2010-01-01";	// lo leeremos de la tabla Vtcambiopwd
	$numeroMaximoDeIps =    8;     // que serán 3 en la práctica ya que jugaremos con el mayor que
	$numeroDeVideosMaximo = 15;  // maximo número de vídeos si el usuario no es original
	$aDevolver = 0;             // si se excede la pondremos a 1	
//....................................averiguar fecha control de conexiones
  $FormatVTfechas =    "SELECT max(fecha_pwd) as dia  
                        FROM   vtcambiopwd
					    WHERE  id_alumno = %d";
							 
   $queVTfechas = sprintf($FormatVTfechas, $_SESSION['NumeroUsuario']); 
   $resVTfechas = mysqli_query($conexion, $queVTfechas) or die(mysqli_error($conexion));
    
   $totVTfechas = mysqli_num_rows($resVTfechas);
   if ($totVTfechas > 0) {  
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTfechas)) {
		       if ($rowRegistros['dia'] <> '') {
		          $fecha_ctr =  $rowRegistros['dia'];
			   }
			   
   	 }
    }
  mysqli_free_result($resVTfechas);	
  
//    echo "<br> Número usuario ----->".$_SESSION['NumeroUsuario'];
	
//	echo "<br> la fecha control es ----->".$fecha_ctr;
	
//.................................. si ya ha sido avisado, restringir el número de conexiones	
  $FormatVTavisos =    "SELECT max(fecha_aviso) as dia
                        FROM   vtavisoalumno
					    WHERE  id_alumno = %d";
   $queVTavisos = sprintf($FormatVTavisos, $_SESSION['NumeroUsuario']); 
   $resVTavisos = mysqli_query($conexion, $queVTavisos) or die(mysqli_error($conexion));
   $totVTavisos = mysqli_num_rows($resVTavisos);
   if ($totVTavisos > 0) {  
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTavisos)) {
		 if ($rowRegistros['dia'] <> '') {
			   $numeroMaximoDeIps -- ;     // restringimos más el número de IPs
	           $numeroDeVideosMaximo --;  // restringimos el número de vídeos

			   //echo "<br> hemos rebajado numeroMaximoDeIps y numeroDeVideosMaximo";
		 }
   	 }
    }
  mysqli_free_result($resVTavisos);	
  
//echo "<br> la fecha del último aviso es ----->".$fechaUltimoAviso."<br>Número de Ips--->".$numeroMaximoDeIps;
	
//...................................averiguar si conexiones excedidas	
   $FormatVTip =    "SELECT totals.id_alumno, vtalumnos.email, totals.id_curso, totals.id_recurso, count(totals.id_recurso)
     FROM   vtalumnos,
       (
          select  id_alumno , id_curso, id_recurso
          from vtsesiones , vtusovideo, vtalumnos
          where  vtsesiones.id  = vtusovideo.id_sesion
          and    vtalumnos.id = vtsesiones.id_alumno
          and id_alumno = %d
          and id_curso = %d 
          and fecha >= '%s'  
          group by id_alumno , id_curso, id_recurso, ip_conex
          order by id_alumno, id_curso, id_recurso, ip_conex
       ) AS totals
       
WHERE  totals.id_alumno = vtalumnos.id
GROUP by  totals.id_alumno , totals.id_curso, totals.id_recurso 
HAVING count(totals.id_recurso)  > %d  ";
 
  
   $queVTip = sprintf($FormatVTip, $_SESSION['NumeroUsuario'], $_SESSION['NumeroCurso'], $fecha_ctr, $numeroMaximoDeIps ); 

   //echo "<br>".$queVTip;
   
   
   $resVTip = mysqli_query($conexion, $queVTip) or die(mysqli_error($conexion));
    
   $totVTip = mysqli_num_rows($resVTip);
   if ($totVTip > $numeroDeVideosMaximo) {  
     $aDevolver = 1;
    }
  mysqli_free_result($resVTip);			
		
		
		//echo "<br> numero de videos de la select ----->".$totVTip;	
		//echo "<br> numero de videos máximo ----->".$numeroDeVideosMaximo;

	   return $aDevolver;
	
}

?>

