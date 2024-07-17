<?php
//...........................................................................................
function DestacaTexto($Texto,$palabras) {
   $PalabrasUnitarias=explode(" ",strtolower($palabras)); 
   $NumeroPalabras = count($PalabrasUnitarias); 
   $TXT =  strtolower($Texto);
   for ($x=0; $x < $NumeroPalabras; $x++) {  
      $Origen  =  $PalabrasUnitarias [$x];
      $Destino =  '<span class="rojoGenerico">'.$PalabrasUnitarias [$x].'</span>';  
       //echo "<br />@@@ Origen: ".$Origen."    Destino: ".$Destino."<br/>";
      $TXT = str_replace($Origen,$Destino,$TXT);
   }
   return str_replace("\r\n","<br>",$TXT);
   
}

///////////////////////////////////////////////////////////////////////////////////////////////
function dibujaBusqueda($PALABRAS,$conexion) {
   $PALA_BRAS = strtolower($PALABRAS);
   $trozos=explode(" ",$PALABRAS); 
   $numero=count($trozos); 
  if ($numero==1) { //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE   
   
      $FormatBusqueda = "SELECT DISTINCT FICHERO, CLAU FROM (
       SELECT 'T' AS FICHERO,id AS CLAU
         FROM forostemas
        WHERE LOWER(tema) like '%$PALA_BRAS%'
              and esta_activo > 0 
       
       UNION
       SELECT 'C' AS FICHERO,id  AS CLAU
         FROM foroscuestiones
        WHERE LOWER(cuestion) like '%$PALA_BRAS%'
              and esta_activo > 0     
      
       UNION
       SELECT 'M' AS FICHERO,id  AS CLAU
         FROM forosmensajes
        WHERE LOWER(mensaje) like '%$PALA_BRAS%'
              and esta_activo > 0 
       
       UNION
       SELECT 'R' AS FICHERO,id  AS CLAU
         FROM forosrecursos
        WHERE (LOWER(titulo) like '%$PALA_BRAS%'
              or LOWER(ficherorecurso) like '%$PALA_BRAS%')
              and esta_activo > 0    
       
       ) AS BUSQUEDA";
       
} elseif ($numero>1) { //busqueda de frases con mas de una palabra y un algoritmo especializado 

    $FormatBusqueda = "SELECT DISTINCT FICHERO, CLAU , Score FROM (
       SELECT 'T' AS FICHERO,id AS CLAU, 
              MATCH ( tema ) AGAINST ( '$PALA_BRAS' ) AS Score 
         FROM forostemas
        WHERE MATCH ( tema ) AGAINST ( '$PALA_BRAS' ) 
              and esta_activo > 0  
      
       UNION
       SELECT 'C' AS FICHERO,id  AS CLAU, MATCH ( cuestion ) AGAINST ( '$PALA_BRAS' ) AS Score 
         FROM foroscuestiones
        WHERE MATCH ( cuestion ) AGAINST ( '$PALA_BRAS' )
              and esta_activo > 0 
    
       UNION
       SELECT 'M' AS FICHERO,id  AS CLAU, MATCH ( mensaje ) AGAINST ( '$PALA_BRAS' ) AS Score 
         FROM forosmensajes
        WHERE MATCH ( mensaje ) AGAINST ( '$PALA_BRAS' )
              and esta_activo > 0 
      
      UNION
       SELECT 'R' AS FICHERO,id  AS CLAU, MATCH ( titulo ) AGAINST ( '$PALA_BRA' ) AS Score 
         FROM forosrecursos
        WHERE (MATCH ( titulo ) AGAINST ( '$PALA_BRAS' )
              or MATCH ( ficherorecurso ) AGAINST ( '$PALA_BRAS' ))
              and esta_activo > 0 
      
       ) AS BUSQUEDA ORDER BY Score DESC ";
} 
   
   //echo "<br />@@@@-->".$FormatBusqueda;
  //..........ejecutar query 
   $resGrupoSelect = mysqli_query($conexion, $FormatBusqueda) or die(mysqli_error($conexion));

   $totGrupoSelect = mysqli_num_rows($resGrupoSelect);
   $txtGrupo = 'No Encontrado';

   if ($totGrupoSelect < 1) { mysqli_free_result($resGrupoSelect); 
    echo '<div class="foroBusqueda">';
    echo  "No encontrado";                      
    echo '</div>'; 
   
   }
    while ($rowPalabra = mysqli_fetch_assoc($resGrupoSelect)) {	
       $nombreFichero = $rowPalabra['FICHERO'];
	   $clave = $rowPalabra['CLAU'];
       switch ($nombreFichero) {
         case "T":
	      dibujaTema($clave,$PALABRAS,$conexion);
	      break;
         case "C":
	      dibujaCuestion($clave,$PALABRAS,$conexion);
	      break;
         case "M":
	      dibujaMensaje($clave,$PALABRAS,$conexion);
	      break;
         case "R":
	      dibujaRecurso($clave,$PALABRAS,$conexion);
	      break;
	   }
        
	}
   mysqli_free_result($resGrupoSelect);
} // function dibujaBusqueda
//...................................................................................................
function TienePermisos($NCurso){
    if ($NCurso == 0) {
        return true;
    }
    if ($_SESSION['es_admin'] > 0 || $_SESSION['es_colaborador'] > 0) {    
        return true;
    }
    $longitud = count($_SESSION['permisos']);
	     if ($longitud > 0) {
             for($i=0; $i<$longitud; $i++) {
		        if ($_SESSION['permisos'] [$i] == $NCurso) {
                   return true; 
                }
             }
         } 
return false;
}
//...................................................................................................
function dibujaTema($clave,$PALABRAS,$conexion) {
$FormatDibujo = "SELECT forostemas.id, tema, forostemas.fecha_alta,
                        forosclases.id AS NCLASE, 
                        clase, num_curso
                   FROM forostemas, forosclases
                  WHERE forostemas.id_forosclases = forosclases.id
                    and forostemas.id = %d";
$queDibujo = sprintf($FormatDibujo,$clave);
    //echo "<br />@@@@--->".$queDibujo;  
$resDibujo = mysqli_query($conexion, $queDibujo) or die(mysqli_error($conexion));  
$totDibujo = mysqli_num_rows($resDibujo);     
if ($totDibujo > 0){
	while ($rowDibujo = mysqli_fetch_assoc($resDibujo)) { 
         $enlace = "'TemaForo.php?id=".$rowDibujo['id']."'";
         $onclick = 'window.location.href='.$enlace;
         echo '<div class="foroBusqueda">';
         echo '<div class="nav_cuestion">';
         echo  '<a href="Foro.php" title="Foro">Foros</a> > ';
         echo  '<a href="Foro.php#K'.$rowDibujo['NCLASE'].'" title="Clase">'.$rowDibujo['clase'].'</a>';   
         echo  '</div>';
         echo '<div class="pointer" onclick="'.$onclick.'">'.DestacaTexto($rowDibujo['tema'],$PALABRAS).'</div>';
         echo '<div class="foroBusPie">'.$rowDibujo['fecha_alta'].'</div>';
         echo '</div>';  //....foroBusqueda
	} //while rowDibujo
}
mysqli_free_result($resDibujo);  
}
//.......................................................................................
function dibujaCuestion($clave,$PALABRAS,$conexion) {
$FormatDibujo = "SELECT foroscuestiones.id, cuestion, foroscuestiones.fecha_alta, foroscuestiones.id_alumno, 
                        forostemas.id AS IDTEMA,
                        forostemas.tema,
                        forosclases.id AS IDCLASE,
                        clase,
                        num_curso
                   FROM foroscuestiones, forostemas, forosclases
                  WHERE foroscuestiones.id_forostemas = forostemas.id
                    and forostemas.id_forosclases = forosclases.id
                    and foroscuestiones.id = %d";
$queDibujo = sprintf($FormatDibujo,$clave);
    //echo "<br />@@@@--->".$queDibujo;  
$resDibujo = mysqli_query($conexion, $queDibujo) or die(mysqli_error($conexion));  
$totDibujo = mysqli_num_rows($resDibujo);     
if ($totDibujo > 0){
	while ($rowDibujo = mysqli_fetch_assoc($resDibujo)) { 
		if (TienePermisos($rowDibujo['num_curso']) ) {
            $enlace = "'CuestionForo.php?id=".$rowDibujo['id']."'";
            $onclick = 'window.location.href='.$enlace;
        } else {
           $enlace = "";
           $onclick = "alert('Foro Privado: Necesita permisos de acceso al curso')"; 
        }
         echo '<div class="foroBusqueda">';
         echo '<div class="nav_cuestion">';
         echo  '<a href="Foro.php" title="Foro">Foros</a> > ';
         echo  '<a href="Foro.php#K'.$rowDibujo['IDCLASE'].'" title="Clase">'.$rowDibujo['clase'].'</a> > '; 
         echo '<a href="TemaForo.php?id='.$rowDibujo['IDTEMA'].'#C'.$rowDibujo['id'].'" title="Tema">'.$rowDibujo['tema'].'</a>';
         echo  '</div>';
            
        
         echo '<div class="pointer" onclick="'.$onclick.'">'.DestacaTexto($rowDibujo['cuestion'],$PALABRAS).'</div>';
         $pie = '<span class="forotemaultifechAz">'.BuscaAlumno($rowDibujo['id_alumno'],$conexion).': </span>'.$rowDibujo['fecha_alta'];
         echo '<div class="foroBusPie">'.$pie.'</div>';
         echo '</div>';  //....foroBusqueda
	} //while rowDibujo
}
mysqli_free_result($resDibujo);  
}
//.........................................................................................
function dibujaMensaje($clave,$PALABRAS,$conexion) {
$FormatDibujo = "SELECT forosmensajes.id, mensaje, forosmensajes.fecha_alta, forosmensajes.id_alumno, 
                        foroscuestiones.id AS IDCUESTION, 
                        cuestion, 
                        forostemas.id AS IDTEMA,
                        forostemas.tema,
                        forosclases.id AS IDCLASE,
                        clase,
                        num_curso
                   FROM forosmensajes, foroscuestiones, forostemas, forosclases
                  WHERE forosmensajes.id_foroscuestiones = foroscuestiones.id 
                    and foroscuestiones.id_forostemas = forostemas.id
                    and forostemas.id_forosclases = forosclases.id
                    and forosmensajes.id = %d";
$queDibujo = sprintf($FormatDibujo,$clave);
    //echo "<br />@@@@--->".$queDibujo;  
$resDibujo = mysqli_query($conexion, $queDibujo) or die(mysqli_error($conexion));  
$totDibujo = mysqli_num_rows($resDibujo);     
if ($totDibujo > 0){
	while ($rowDibujo = mysqli_fetch_assoc($resDibujo)) { 
		if (TienePermisos($rowDibujo['num_curso']) ) {
            $enlace = "'CuestionForo.php?id=".$rowDibujo['IDCUESTION'].'#M'.$rowDibujo['id']."'";
            $onclick = 'window.location.href='.$enlace;
        } else {
           $enlace = "";
           $onclick = "alert('Foro Privado: Necesita permisos de acceso al curso')"; 
        }
         echo '<div class="foroBusqueda">';
         echo '<div class="nav_cuestion">';
         echo  '<a href="Foro.php" title="Foro">Foros</a> > ';
         echo  '<a href="Foro.php#K'.$rowDibujo['IDCLASE'].'" title="Clase">'.$rowDibujo['clase'].'</a> > '; 
         echo '<a href="TemaForo.php?id='.$rowDibujo['IDTEMA'].'#C'.$rowDibujo['IDCUESTION'].'" title="Tema">'.$rowDibujo['tema'].'</a> > ';
        echo '<a href="CuestionForo.php?id='.$rowDibujo['IDCUESTION'].'" title="Tema">'.substr($rowDibujo['cuestion'],0,40).'</a>';
        
         echo  '</div>';
            
        
         echo '<div class="pointer" onclick="'.$onclick.'">'.DestacaTexto($rowDibujo['mensaje'],$PALABRAS).'</div>';
         $pie = '<span class="forotemaultifechAz">'.BuscaAlumno($rowDibujo['id_alumno'],$conexion).': </span>'.$rowDibujo['fecha_alta'];
         echo '<div class="foroBusPie">'.$pie.'</div>';
         echo '</div>';  //....foroBusqueda
	} //while rowDibujo
}
mysqli_free_result($resDibujo);  
}
//.........................................................................................
function dibujaRecurso($clave,$PALABRAS,$conexion) {
$FormatDibujo = "SELECT forosrecursos.id, titulo, forosrecursos.fecha_alta, forosrecursos.id_alumno, ficherorecurso, 
                        forosmensajes.id AS IDMENSAJE, mensaje, 
                        foroscuestiones.id AS IDCUESTION, cuestion, 
                        forostemas.id AS IDTEMA, tema,
                        forosclases.id AS IDCLASE, clase, num_curso
                   FROM forosrecursos, forosmensajes, foroscuestiones, forostemas, forosclases
                  WHERE forosrecursos.id_forosmensajes = forosmensajes.id 
                    and forosmensajes.id_foroscuestiones = foroscuestiones.id 
                    and foroscuestiones.id_forostemas = forostemas.id
                    and forostemas.id_forosclases = forosclases.id
                    and forosrecursos.id = %d";
$queDibujo = sprintf($FormatDibujo,$clave);
    //echo "<br />@@@@--->".$queDibujo;  
$resDibujo = mysqli_query($conexion, $queDibujo) or die(mysqli_error($conexion));  
$totDibujo = mysqli_num_rows($resDibujo);     
if ($totDibujo > 0){
	while ($rowDibujo = mysqli_fetch_assoc($resDibujo)) { 
		if (TienePermisos($rowDibujo['num_curso']) ) {
            $enlace = "'CuestionForo.php?id=".$rowDibujo['IDCUESTION'].'#R'.$rowDibujo['id']."'";
            $onclick = 'window.location.href='.$enlace;
        } else {
           $enlace = "";
           $onclick = "alert('Foro Privado: Necesita permisos de acceso al curso')"; 
        }
         echo '<div class="foroBusqueda">';
         echo '<div class="nav_cuestion">';
         echo  '<a href="Foro.php" title="Foro">Foros</a> > ';
         echo  '<a href="Foro.php#K'.$rowDibujo['IDCLASE'].'" title="Clase">'.$rowDibujo['clase'].'</a> > '; 
         echo '<a href="TemaForo.php?id='.$rowDibujo['IDTEMA'].'#C'.$rowDibujo['IDCUESTION'].'" title="Tema">'.substr($rowDibujo['tema'],0,40).'</a> > ';
        echo '<a href="CuestionForo.php?id='.$rowDibujo['IDCUESTION'].'#M'.$rowDibujo['IDMENSAJE'].'" title="Cuestión">'.substr($rowDibujo['cuestion'],0,40).'</a> > ';
        echo '<a href="CuestionForo.php?id='.$rowDibujo['IDCUESTION'].'#R'.$rowDibujo['id'].'" title="Mensaje">'.substr($rowDibujo['mensaje'],0,40).'</a>';
         echo  '</div>';    
         $nombreFichero = '<img src="../imagenes/'.IconoFichero($rowDibujo['ficherorecurso']).'" width="25" height="25" />';
         $texto = $rowDibujo['titulo']." => (".$rowDibujo['ficherorecurso'].")";
        echo '<div class="pointer" onclick="'.$onclick.'">'.$nombreFichero.' '.DestacaTexto($texto,$PALABRAS).'</div>';
         $pie = '<span class="forotemaultifechAz">'.BuscaAlumno($rowDibujo['id_alumno'],$conexion).': </span>'.$rowDibujo['fecha_alta'];
         echo '<div class="foroBusPie">'.$pie.'</div>';
         echo '</div>';  //....foroBusqueda
	} //while rowDibujo
}
mysqli_free_result($resDibujo);  
}
?>