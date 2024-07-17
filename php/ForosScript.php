
<?php

// FUNCIONES .......................................................................
//........................................................................ 
function AveriguaClausula() {
$clausula = ""; 
 if($_SESSION['NumeroUsuario'] != 0) {  
	$longitud = count($_SESSION['permisos']);
	if ($longitud > 0) {
       for($i=0; $i<$longitud; $i++) {
	        if ($i == 0 ) {
		      $clausula .= "(".$_SESSION['permisos'] [$i];
	        }  else {
		      $clausula .= ",".$_SESSION['permisos'] [$i];
	        }
        }
    $clausula .= ")";
    }
 }
 return $clausula;
}
//........................................................................   
function ForosClases($conexion) {
$salida         = "";
$id             = 0;
$clase          = "";
$descri_clase   = "";
$orden          = 0;
$num_temas      = 0;
$fecha_alta     = "";
  $FormatMaestros = "SELECT id, clase,  descri_clase,  orden,  num_temas,  fecha_alta
                       FROM forosclases
                      WHERE (forosclases.fecha_baja IS NULL OR YEAR(forosclases.fecha_baja) = 0  OR forosclases.fecha_baja >= CURDATE())
                   ORDER BY orden";

$queMaestros = $FormatMaestros;  
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));  
$totMaestros = mysqli_num_rows($resMaestros);     
if ($totMaestros > 0){
	while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
		$id             = $rowMaestros['id'];
        $clase          = $rowMaestros['clase'];
        $descri_clase   = $rowMaestros['descri_clase'];
        $orden          = $rowMaestros['orden'];
        $num_temas      = $rowMaestros['num_temas'];
        $fecha_alta     = $rowMaestros['fecha_alta'];
        $salida        .= '<A NAME="K'.$rowMaestros['id'].'"></A>';
        $salida        .='<section class="EnvoltorioForoClase">';
        $salida        .='<div class="foroclase">';
        $salida        .='<p class="foroclasenumtema"> Temas: '.$num_temas.'</p>';
        $salida        .='<p class="foroclasefecha">Alta: '.$fecha_alta.'</p>';
        $salida        .='<h2 class="foroclasetitulo">'.$clase.'</h2>';
        $salida        .='<div class="clear"></div><p class="foroclasedescri">'.$descri_clase.'</p></div>';
        $salida        .= '<article class="forotema">';
        $salida        .= ForosTemas($id,$conexion);
        $salida        .= '</article>';
        $salida        .='</section><div class="clear"></div>';
	}
}
mysqli_free_result($resMaestros);
return $salida;
}
//....................................................................................................................................
function ForosTemas($clase,$conexion) {
$cadena = "";
$id		 	    = 0;
$id_forosclases = 0;	 
$tema		 	= "";
$veces_visitado = 0;	  
$fecha_alta	 	= ""; 
$num_cuestiones = 0;

$FormatTemas = "SELECT id, id_forosclases, tema, veces_visitado, fecha_alta, orden, num_cuestiones
                  FROM forostemas
                 WHERE forostemas.fecha_alta <= CURDATE()
                   and (forostemas.fecha_baja IS NULL OR YEAR(forostemas.fecha_baja) = 0  OR forostemas.fecha_baja >= CURDATE())
                   and forostemas.esta_activo = 1 
                   and id_forosclases = %d
              ORDER BY orden";

$queTemas = sprintf($FormatTemas,$clase);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$id		 	    = $rowTemas['id'];
        $id_forosclases = $rowTemas['id_forosclases'];	 
        $tema		 	= $rowTemas['tema'];
        $veces_visitado = $rowTemas['veces_visitado']; 	  
        $fecha_alta	 	= $rowTemas['fecha_alta']; 
        $num_cuestiones = $rowTemas['num_cuestiones'];
        $cadena   .= '<A NAME="T'.$rowTemas['id'].'"></A>';
        $cadena   .= '<div class="forotemalinea">';
          $cadena .= '<div class="forotemaI"><img src="../imagenes/libro.png" width="50" height="36" alt="Libro Abierto"/></div>'; 
          $cadena .= '<div class="forotemaD">';
          $cadena .= '<h3 class="forotemacontenido">';
          $cadena .= '<a href="TemaForo.php?id='.$id.'" title="Cuestiones planteadas">'.$tema.'</a>';
          $cadena .= '</h3>';
          $TxtVisitas ="";
          if ($_SESSION['es_admin'] > 0) {
          	$TxtVisitas = '&nbsp; &nbsp; &nbsp; Visitas: '.$veces_visitado;
          }
          $cadena .= '<p class="forotemadatos">Cuestiones: '.$num_cuestiones.$TxtVisitas.'</p>';
          $cadena .= '<div class="forotemaultimom">';
          $cadena .= MensajeByID(UltimaIDMensaje($id,$conexion),$conexion);
          $cadena .= '</div>';
          $cadena .= '<div class="clear"></div>';
        $cadena .= '</div></div>';
        
	}
}
mysqli_free_result($resTemas); 
    return $cadena;
}
//...............................................................................................................

//...............................................................................................................
function ForosMensajes($cuestion,$conexion) {
$id		             = 0;	 	         
$id_foroscuestiones	 = 0;	 
$parent	             = 0;
$id_alumno	         = 0; 	 	 
$mensaje		 	 = ""; 
$fecha_alta	         = ""; 	 	 	 
$fecha_baja	 	     = ""; 
$veces_visitado      = 0;	 	 
$num_recursos        = 0;
$aliasAlumno         = "";  
$aliasComment        = ""; 
$num_curso           = 0;
$ClausulaIN          = AveriguaClausula(); //según permisos usuario
$FormatMensajes = "SELECT forosmensajes.id, id_foroscuestiones,	parent, forosmensajes.id_alumno, mensaje, forosmensajes.fecha_alta, 
                          forosmensajes.fecha_baja, veces_visitado, num_recursos, alias_foro, alias_comment, forosclases.num_curso 
                  FROM forosmensajes, vtalumnos, foroscuestiones, forostemas, forosclases
                 WHERE forosmensajes.id_alumno = vtalumnos.id
                   and forosmensajes.id_foroscuestiones = foroscuestiones.id
                   and foroscuestiones.id_forostemas = forostemas.id
                   and forostemas.id_forosclases = forosclases.id
                   and forosmensajes.fecha_alta <= CURDATE()
                   and (forosmensajes.fecha_baja IS NULL OR YEAR(forosmensajes.fecha_baja) = 0  OR forosmensajes.fecha_baja >= CURDATE())
                   and forosclases.num_curso = 0 OR forosclases.num_curso IN '%s'
                   and id_foroscuestiones = %d
              ORDER BY forosmensajes.id, parent";
$queMensajes = sprintf($FormatMensajes,$ClausulaIN,$cuestion);
    
//echo "<br />@@@ ForosMensajes-->".$queMensajes;  
    
$resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
$totMensajes = mysqli_num_rows($resMensajes);     
if ($totMensajes > 0){
	while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
		$id		             = $rowMensajes['id']; 	 	         
        $id_foroscuestiones	 = $rowMensajes['id_foroscuestiones']; 
        $parent	             = $rowMensajes['parent']; 
        $id_alumno	         = $rowMensajes['fecha_alta']; 	 	 
        $mensaje		 	 = $rowMensajes['mensaje'];  
        $fecha_alta	         = $rowMensajes['fecha_alta'];  	 	 	 
        $fecha_baja	 	     = $rowMensajes['fecha_baja'];  
        $veces_visitado      = $rowMensajes['veces_visitado']; 	 	 
        $num_recursos        = $rowMensajes['num_recursos']; 
        $aliasAlumno         = $rowMensajes['alias_foro'];   
        $aliasComment        = $rowMensajes['alias_comment'];  
	}
}
mysqli_free_result($resMensajes);    

}
//.........................................................................
function UltimaIDMensaje($tema,$conexion) {
$id = 0;	 	         
$FormatMensajes = "SELECT max(forosmensajes.id) AS ULTIMAID
                     FROM forosmensajes, foroscuestiones, forostemas
                    WHERE forosmensajes.id_foroscuestiones = foroscuestiones.id
                      and foroscuestiones.id_forostemas = forostemas.id
                      and forostemas.id = %d
                      and (forostemas.fecha_baja IS NULL OR YEAR(forostemas.fecha_baja) = 0  OR forostemas.fecha_baja >= CURDATE())
                      and (foroscuestiones.fecha_baja IS NULL OR YEAR(foroscuestiones.fecha_baja) = 0  OR foroscuestiones.fecha_baja >= CURDATE())
                      and (forosmensajes.fecha_baja IS NULL OR YEAR(forosmensajes.fecha_baja) = 0  OR forosmensajes.fecha_baja >= CURDATE())
                  ";
$queMensajes = sprintf($FormatMensajes,$tema);
   // echo "<br />@@@ .............UltimaIDMensaje-->".$queMensajes;
$resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
$totMensajes = mysqli_num_rows($resMensajes);     
if ($totMensajes > 0){
	while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
		$id = $rowMensajes['ULTIMAID']; 	 	         
	}
}
mysqli_free_result($resMensajes);    
return $id;
}    

//.........................................................................
function MensajeByID($id_mensaje,$conexion) {	 
$adevolver = "";
$FormatMensajes = "SELECT forosmensajes.id, cuestion, mensaje, forosmensajes.fecha_alta, forosmensajes.id_alumno,
                          foroscuestiones.id AS IDCUESTION
                     FROM forosmensajes, foroscuestiones, forostemas
                    WHERE forosmensajes.id_foroscuestiones = foroscuestiones.id
                      and foroscuestiones.id_forostemas = forostemas.id
                      and forosmensajes.id = %d
                  ";
$queMensajes = sprintf($FormatMensajes,$id_mensaje);
    
   // echo "<br />@@@ MensajeByID-->".$queMensajes;
$resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
$totMensajes = mysqli_num_rows($resMensajes);     
if ($totMensajes > 0){
	while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
        $mensaje = $rowMensajes['mensaje'];
        if (strlen($mensaje)> 40) {
            $mensaje = substr($mensaje,0,80)."...";
        }
        $alias = BuscaAlumno($rowMensajes['id_alumno'],$conexion);
        $cadena = 'CuestionForo.php?id='.$rowMensajes['IDCUESTION'].'#M'.$rowMensajes['id'];
        
        $adevolver .='<p class="forotemaulticues">Último mensaje:</p>';
        $adevolver .='<p class="forotemaultimens">'.'<a href="'.$cadena.'" title="Ultimo articulo">'.$mensaje.'</a></p>';
            
        $adevolver .='<p class="forotemaultifech"><span class="forotemaultifechAz">'.$alias.' </span>  &nbsp; &nbsp;'.$rowMensajes['fecha_alta'].'</p>';  
        //$adevolver .='<p class="forotemaultifech">'.$rowMensajes['fecha_alta'].'</p>';
         
        
	}
}
mysqli_free_result($resMensajes);        
return $adevolver;      
}
//...........................................................................
 function IconoFichero($fichero) {
 $inicio = strrpos($fichero, ".");
 $final = strlen($fichero);
 $sufijo = 	substr($fichero,$inicio+1,$final-$inicio-1); 
 $sufijo = strtoupper($sufijo);	 
 $nombreIcono = "Clip.gif";
 $extensiones = array(
      "TXT"    =>   "TXT.gif",
      "PDF"    =>   "PDF.gif",
      "CYP"    =>   "CYPE.gif",  
      "MP4"    =>   "MP4.gif",
      "AVI"    =>   "MP4.gif",
      "MOV"    =>   "MP4.gif",
      "MPEG"   =>   "MP4.gif",  
      "DWG"    =>   "DWG.gif",
      "RAR"    =>   "RAR.gif",
      "ZIP"    =>   "RAR.gif",
      "ARJ"    =>   "RAR.gif",
      "GZ"     =>   "RAR.gif",
      "GZIP"   =>   "RAR.gif",
      "TAR"    =>   "RAR.gif",
      "TAR.GZ" =>   "RAR.gif",
      "TARZ"   =>   "RAR.gif",
      "TGZ"    =>   "RAR.gif",
      "DOC"    =>   "WORD.gif",
      "DOCX"   =>   "WORD.gif",
      "DOT"    =>   "WORD.gif",
      "DOTX"   =>   "WORD.gif",
      "XLS"    =>   "XLS.gif",
      "XLSX"   =>   "XLS.gif",
      "PPT"    =>   "PPT.gif",
      "POTX"   =>   "PPT.gif",
      "PPS"    =>   "PPT.gif",
      "PPSX"   =>   "PPT.gif",
      "PPTX"   =>   "PPT.gif",
      "JPG"    =>   "JPG.gif",
      "BMP"    =>   "JPG.gif",
      "GIF"    =>   "JPG.gif",
      "JPEG"   =>   "JPG.gif",
      "PNG"    =>   "JPG.gif",
      "TIF"    =>   "JPG.gif",
      "TIFF"   =>   "JPG.gif",
  ); 
$nombreIcono =  $extensiones[$sufijo];
return $nombreIcono;
 }
 
//.........................................................................
function BuscaAlumno($id_alumno,$conexion) {
$alias = "";
$comment = "";  
$nombre  = "";  
$FormatAlumnos = "SELECT alias_foro, alias_comment from vtalumnos where id = %d";
$queAlumnos = sprintf($FormatAlumnos,$id_alumno);
$resAlumnos = mysqli_query($conexion, $queAlumnos) or die(mysqli_error($conexion));  
$totAlumnos = mysqli_num_rows($resAlumnos);     
if ($totAlumnos > 0){
	while ($rowAlumnos = mysqli_fetch_assoc($resAlumnos)) {
		$alias = $rowAlumnos['alias_foro']; 
        $comment = $rowAlumnos['alias_comment']; 
	}
}
mysqli_free_result($resAlumnos);  
 $nombre =  $alias.": ".$comment;
    
if ($nombre == ": ") {
  $alias = "USUARIO".dechex($id_alumno*1033);
}  
return $alias;   
}
//.......................................................................................
function PintaRecursos($id_mensaje,$conexion) {
$atornar = "";
$id = 0;
$id_alumno = 0;
$titulo    = "";
$ficherorecurso = "";
$fecha_alta = "";    
$FormatRecursos = "SELECT id, id_forosmensajes, id_alumno, titulo, ficherorecurso, fecha_alta, esta_activo, fecha_baja, fecha_revision
		             FROM forosrecursos
				    WHERE esta_activo >0 
                      and id_forosmensajes = %d ";
$queRecursos = sprintf($FormatRecursos,$id_mensaje); 
$resRecursos = mysqli_query($conexion, $queRecursos) or die(mysqli_error($conexion));      
$totRecursos = mysqli_num_rows($resRecursos);     
if ($totRecursos > 0){
    
    $n = 0;
	while ($rowRecursos = mysqli_fetch_assoc($resRecursos)) { 
     $id = $rowRecursos['id'];
     $id_alumno = $rowRecursos['id_alumno'];
     $titulo = $rowRecursos['titulo'];
     $ficherorecurso = $rowRecursos['ficherorecurso'];
     $fecha_alta = $rowRecursos['fecha_alta']; 
       $inicio = strrpos($ficherorecurso, ".");
       $final = strlen($ficherorecurso);
       $sufijo = 	substr($ficherorecurso,$inicio+1,$final-$inicio-1); 
       $sufijo = strtoupper($sufijo);	
        $atornar .= '<A NAME="R'.$id.'"></A>';
        
        if (strpos(",JPG,BMP,GIF,TIFF,TIF,JPEG,RAW,PNG",$sufijo) > 0 ) {
            $n = 0;
            $atornar .= '<div class="MensajeRecLinea">';
            $atornar .= '<div class="centro"><b>'.$titulo.'</b></div><br /><br />';
            $atornar .= '</div>';
            $atornar .= '<div class="centro"><img src="Recursos/'.$ficherorecurso.'" alt="'.$titulo.'" ></div>';
        
        } else if (strpos(",MP4,AVI,MOV,MPEG",$sufijo) > 0 ){
            $n = 0;
            $atornar .= '<div class="MensajeRecLinea">';
            $atornar .= '<div class="centro"><b>'.$titulo.'</b></div><br /><br />';
            $atornar .= '</div>';
            $atornar .= '<div class="centro">';
            
            $atornar .= '<video class="VideoRecurso" controls>';
            $atornar .= '<source src="Recursos/'.$ficherorecurso.'" type="video/mp4">';
            $atornar .= 'Your browser does not support the video tag.';
            $atornar .= '</video>';  
            $atornar .= '</div>';  //de centro
        } else {
           $n++;
           if ($n == 1) {
            $atornar .= '<div class="MensajeRecLinea">';
            $atornar .= '<b>Recursos para descargar:</b><br />' ;  
            $atornar .= '</div>';
            
        }   
           $atornar .= '<div class="MensajeRecLinea" onclick="Descarga('.$id.')">';  // onclick
           /*$atornar .= '<div class="MensajeRecLinea01"><img src="../imagenes/Punto.gif" alt="Punto vinyeta" width="25" height="25"></div>';*/
           $atornar .= '<div class="MensajeRecLinea02"><img src="../imagenes/'.IconoFichero($ficherorecurso).'" alt= "Formato fichero" width="25" height="25" /></div>';
           $atornar .= '<div class="MensajeRecLinea03">'.$titulo.'</div>';     
           $atornar .= "</div>"; //...MensajeRecLinea   
    } 
 }  
}    
return $atornar;   
}
//.........................................................................
function PintaMensajeById($id_mensaje,$conexion,$conHijos,$cerrado) {	
$adevolver = "";
$mensaje = "";
$id_alumno = 0;
$fecha_alta ="";
$parent = 0;
$num_recursos = 0;  
$clase = "MensajeHijo";  
$EsEditable = 0;
//$CadenaColores ="";
$FormatMensajes = "SELECT es_editable, forosmensajes.id, id_foroscuestiones, forosmensajes.id_alumno, mensaje, forosmensajes.fecha_alta, forosmensajes.esta_activo, forosmensajes.fecha_baja, forosmensajes.fecha_revision, parent, num_recursos
		               FROM forosmensajes, foroscuestiones, forosclases, forostemas
				           WHERE forosmensajes.id_foroscuestiones = foroscuestiones.id
				             and foroscuestiones.id_forostemas = forostemas.id
				             and forostemas.id_forosclases = forosclases.id
				             and forosmensajes.esta_activo > 0
                     and forosmensajes.id = %d ";
$queMensajes = sprintf($FormatMensajes,$id_mensaje); 
$resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));      
$totMensajes = mysqli_num_rows($resMensajes);  
if ($totMensajes > 0){
	while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {  
		  $EsEditable = $rowMensajes['es_editable'];
      $mensaje = $rowMensajes['mensaje'];
      $id_alumno = $rowMensajes['id_alumno'];
      $fecha_alta = $rowMensajes['fecha_alta'];
      $parent = $rowMensajes['parent'];
      $num_recursos = $rowMensajes['num_recursos']; 
      $colorPadre =  CalculaColor($parent);   
      $colorPropio =  CalculaColor($id_mensaje);     
      if ($parent == 0 || $parent == NULL) {
          $clase = "MensajePadre";
      }    
      $adevolver        .= '<A NAME="M'.$id_mensaje.'"></A>';
     
      $adevolver .= '<article class="'.$clase.'" >'; // onclick
        if ( $parent != NULL && $parent > 0) {
            $adevolver .= '<div class="MensajeLed"><svg width="100%" height="100%" viewBox="0 0 74 74" style="background-color:'.$colorPadre.'"></svg></div>'; 
            $adevolver .= '<div class="MensajeLed"><-</div>'; 
        }
        
            $adevolver .= '<div class="MensajeLed"><svg width="100%" height="100%" viewBox="0 0 74 74" style="background-color:'.$colorPropio.'"></svg></div>';  
	        

      $adevolver .= '<div class="MensajeFecha">'.$fecha_alta.'</div>';    
      $adevolver .= '<div class="MensajeAlias" onclick="VerFichaAlumno('.$id_alumno.')">'.BuscaAlumno($id_alumno,$conexion).'</div>';  
      $adevolver .= '<div class="clear"></div>';  
      $adevolver .= '<div class="MensajeCuerpo" onclick="VerFichaMensaje('.$id_mensaje.')" >'.str_replace("\r\n","<br>",$mensaje).'</div>';       
      $adevolver .= '<div class="clear"></div>';  
      if ($conHijos == 1) { 
         $adevolver .= PintaRecursos($id_mensaje,$conexion);
      }
        
      $adevolver .= '<div class="clear"></div>';
      if ($cerrado == 0 &&  $conHijos == 1 ){
        $adevolver .= '<div class="MensajeResponder">';
        
        if ($EsEditable > 0 || $_SESSION['es_admin'] > 0) { 
           if ($_SESSION['es_admin'] > 0|| $_SESSION['es_colaborador'] > 0 || $_SESSION['NumeroUsuario'] == $id_alumno) {
               $adevolver .= '<div class="MensajeResponder01" onclick="AfegirRecurso('.$id_mensaje.','.$rowMensajes['id_foroscuestiones'].')" ><img src="../imagenes/FlechaSuma.gif" alt="Suma" width="25" height="25"> Imagen, Video, PDF</div>';   
           }
           $adevolver .= '<div class="MensajeResponder01" onclick="ResponderMensaje('.$id_mensaje.','.$rowMensajes['id_foroscuestiones'].')" ><img src="../imagenes/FlechaResponder.gif" alt="Punto vinyeta" width="25" height="25">Responder</div>';      
       
        }
       
        $adevolver .= '</div>'; 
      }
      $adevolver .= '</article>';
        if ($conHijos == 1) {
            $FormatHijos = "SELECT id FROM forosmensajes where parent = %d ";
            $queHijos = sprintf($FormatHijos,$id_mensaje);
            $resHijos = mysqli_query($conexion, $queHijos) or die(mysqli_error($conexion));  
            $totHijos = mysqli_num_rows($resHijos);  
            //echo "<br>@@@-->".$queHijos."<br>";
            if ($totHijos > 0){
               $adevolver .= '<div class="MensajeGrupoHijos">';
	           while ($rowHijos = mysqli_fetch_assoc($resHijos)) {
		          $id = $rowHijos['id']; 
                  //echo "<br>@@@-Procesando->".$id."<br>";
                  $adevolver .= PintaMensajeById($id,$conexion,1,$cerrado);
	           }
                $adevolver .='</div>';
            }
            mysqli_free_result($resHijos);       
        }
    }
}
 mysqli_free_result($resMensajes);
 return $adevolver; 
}
    
 //................................................................
function CalculaColor($id){
   $colorDevolver ="#FF0000";    
   $salida = ($id*$id*$id < 256 ? $id*$id*$id : ($id*$id*$id)%256);
  
      $rojo = dechex($salida);
      $verde = ($salida < 80 ? dechex($salida*2): dechex($salida/2));
      $azul =  ($salida < 80 ? dechex($salida+100): dechex($salida/3));
   
    $colorDevolver = str_pad($rojo,2,"0",STR_PAD_LEFT).str_pad($verde,2,"0",STR_PAD_LEFT).str_pad($azul,2,"0",STR_PAD_LEFT);
    
    //echo "<br> @@@ Color: ".$colorDevolver." Registro: ".$id." Numero: ".$numero."<br>";
    
    return $colorDevolver;
}
//................................................................
function PintaCuestionById($id,$conexion){
$adevolver     = "";
$esta_cerrada  = 1; 
$EsEditable = 0; 

$FormatCuestiones = "SELECT foroscuestiones.id, id_forostemas, foroscuestiones.id_alumno, cuestion, es_editable,  
                        foroscuestiones.fecha_alta, foroscuestiones.esta_cerrada, 
                        veces_visitada, num_mensajes, paginaweb,
                        forostemas.id AS NTEMA, tema, num_cuestiones, 
                        forostemas.veces_visitado AS NVISITADO,
                        forostemas.fecha_alta AS TALTA,
                        forostemas.num_cuestiones ,
                        forosclases.id AS NCLASE,
                        forosclases.num_temas, 
                        forosclases.fecha_alta as KALTA,
                        clase, num_curso
                  FROM foroscuestiones, forostemas, forosclases
                 WHERE foroscuestiones.id_forostemas = forostemas.id
                   and forostemas.id_forosclases = forosclases.id
                   and foroscuestiones.esta_activo > 0 
                   and forostemas.esta_Activo > 0
                   and (forosclases.fecha_baja IS NULL OR YEAR(forosclases.fecha_baja) = 0  OR forosclases.fecha_baja >= CURDATE())
                   and foroscuestiones.id = %d";
$queCuestiones = sprintf($FormatCuestiones,$id);
$resCuestiones = mysqli_query($conexion, $queCuestiones) or die(mysqli_error($conexion));  
$totCuestiones = mysqli_num_rows($resCuestiones);     
if ($totCuestiones > 0){
	while ($rowCuestiones = mysqli_fetch_assoc($resCuestiones)) {
         $esta_cerrada	  =	$rowCuestiones['esta_cerrada']; 	 	 
         $EsEditable	  =	$rowCuestiones['es_editable'];         
         $adevolver .= '<div class="nav_cuestion">';
         $adevolver .=  '<a href="Foro.php" title="Foro">Foros</a> > ';
         $adevolver .=  '<a href="Foro.php#T'.$rowCuestiones['NTEMA'].'" title="Clase">'.$rowCuestiones['clase'].'</a> > ';
         $adevolver .=  '<a href="TemaForo.php?id='.$rowCuestiones['NTEMA'].'#C'.$rowCuestiones['id'].'" title="Tema">'.$rowCuestiones['tema'].'</a>';    
         $adevolver .=  '</div>';
            

        
        $adevolver .= '<div class="foroclase">';
        $adevolver .= '<A NAME="C'.$rowCuestiones['id'].'"></A>';
        $adevolver .= '<p class="foroclasenumtema"> Temas: '.$rowCuestiones['num_temas'].'</p>';
        $adevolver .= '<p class="foroclasefecha">' .$rowCuestiones['KALTA'].'</p>';
        $adevolver .= '<p class="foroclasetitulo">'.$rowCuestiones['clase'].'</p>';
        $adevolver .= '<div class="clear"></div>';
        $adevolver .= '<p class="foroclasenumtema"> Cuestiones: '.$rowCuestiones['num_cuestiones'].'</p>';
        $adevolver .= '<p class="foroclasefecha">' .$rowCuestiones['TALTA'].'</p>';
        $adevolver .= '<h2 class="foroclasedescri" onclick="VerFichaTema('.$rowCuestiones['NTEMA'].')">'.$rowCuestiones['tema'].'</h2>';
        $adevolver .= '</div>';
        $adevolver .= '<div class="forotema">';
        
        $adevolver .= '<div class="forotemalinea">';
        $adevolver .= '<p class="foroclasenumtema2" onclick="VerFichaAlumno('.$rowCuestiones['id_alumno'].')">' .BuscaAlumno($rowCuestiones['id_alumno'],$conexion).' -> '.$rowCuestiones['fecha_alta'].'</p>'; 
         
        if ($_SESSION['es_admin'] > 0) {         
           $adevolver .= '<p class="foroclasenumtema"> Visitas: '.$rowCuestiones['veces_visitada'].'</p>';
        }

        //$adevolver .= '<p class="foroclasenumtema">'.BuscaAlumno($rowCuestiones['id_alumno'],$conexion).'</p>';
       
        $adevolver .= '<div class="clear"></div>';
        $adevolver .= '<h3 class="forocuestion" onclick="VerFichaCuestion('.$rowCuestiones['id'].')">'.$rowCuestiones['cuestion'].'</h3>';
        $adevolver .= '</div>'; //forotemalinea
        
        $adevolver .= '<div class="MensajeResponder">';
         if ($esta_cerrada > 0) {
             $adevolver .= '<div class="MensajeResponder01"><img src="../imagenes/CandadoCerrado.gif" alt="Candado cerrado" width="30" height="30"> Cuestión Cerrada</div>';
         } else {
         	  if ($EsEditable > 0 || $_SESSION['es_admin'] > 0) { 
             $adevolver .= '<div class="MensajeResponder01" onclick="ResponderMensaje(0,'.$rowCuestiones['id'].')" ><img src="../imagenes/FlechaResponder.gif" alt="Punto vinyeta" width="25" height="25">Nuevo Mensaje</div>';  
            }
         }
        $adevolver .= '</div>'; //MensajeResponder
        $adevolver .= '</div>'; //forotema     
	} //while rowCuestiones
}
mysqli_free_result($resCuestiones); 
 //vemos los mensajes de esta cuestión con parent =0
 $FormatMensajes = "SELECT id
                      FROM forosmensajes
                     WHERE esta_activo >0
                       and (parent is NULL OR parent = 0)
                       and id_foroscuestiones = %d";
$queMensajes = sprintf($FormatMensajes,$id);
    
    
    
    
$resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
$totMensajes = mysqli_num_rows($resMensajes);     
if ($totMensajes > 0){
	while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
        $adevolver .= PintaMensajeById($rowMensajes['id'],$conexion,1,$esta_cerrada);	          
	}
}
mysqli_free_result($resMensajes);         
return $adevolver;   
}   
//................................................pinta tema, nos pasan id_tema y respondemos con cabecera de tema + cuestiones que le cuelgan
function PintaTemaById($id,$conexion){
$adevolver     = "";
$esta_cerrada  = 1; 
$TienePermiso = 0;
$Candado = "";
$EsEditable = 0;
$FormatCuestiones = "SELECT forostemas.id, tema, num_cuestiones, forostemas.veces_visitado, forostemas.fecha_alta, es_editable, 
                            forosclases.id AS NCLASE, clase, num_temas, forosclases.fecha_alta AS KALTA, num_curso
                  FROM forostemas, forosclases
                 WHERE forostemas.id_forosclases = forosclases.id
                   and forostemas.esta_Activo > 0
                   and (forosclases.fecha_baja IS NULL OR YEAR(forosclases.fecha_baja) = 0  OR forosclases.fecha_baja >= CURDATE())
                   and forostemas.id = %d";
$queCuestiones = sprintf($FormatCuestiones,$id);
$resCuestiones = mysqli_query($conexion, $queCuestiones) or die(mysqli_error($conexion));  
$totCuestiones = mysqli_num_rows($resCuestiones);     
if ($totCuestiones > 0){
	while ($rowCuestiones = mysqli_fetch_assoc($resCuestiones)) { 
		  $EsEditable = $rowCuestiones['es_editable'];	 
      if ($_SESSION['es_admin'] > 0 || $_SESSION['es_colaborador'] > 0) {    
        $TienePermiso = 1;
      } else if ($rowCuestiones['num_curso'] == 0) {
        $TienePermiso = 1;
      } else {
         $longitud = count($_SESSION['permisos']);
	     if ($longitud > 0) {
             for($i=0; $i<$longitud; $i++) {
		        if ($_SESSION['permisos'] [$i] == $rowCuestiones['num_curso']) {
                   $TienePermiso = 1;
                    break; 
                }
             }
         } 
      }

         $adevolver .= '<div class="nav_cuestion">';
         $adevolver .=  '<a href="Foro.php" title="Foro">Foros</a> > ';
         $adevolver .=  '<a href="Foro.php#K'.$rowCuestiones['NCLASE'].'" title="Clase">'.$rowCuestiones['clase'].'</a>';   
         $adevolver .=  '</div>';
            

        
        $adevolver .= '<div class="foroclase">';
        $adevolver .= '<A NAME="T'.$rowCuestiones['id'].'"></A>';
        $adevolver .= '<p class="foroclasenumtema"> Temas: '.$rowCuestiones['num_temas'].'</p>';
        $adevolver .= '<p class="foroclasefecha">' .$rowCuestiones['KALTA'].'</p>';
        $adevolver .= '<h2 class="foroclasetitulo">'.$rowCuestiones['clase'].'</h2>';
        $adevolver .= '<div class="clear"></div>';
        $adevolver .= '<p class="foroclasenumtema"> Cuestiones: '.$rowCuestiones['num_cuestiones'].'</p>';
        $adevolver .= '<p class="foroclasefecha">' .$rowCuestiones['fecha_alta'].'</p>';
        $adevolver .= '<h3 class="foroclasedescri" onclick="VerFichaTema('.$rowCuestiones['id'].')">'.$rowCuestiones['tema'].'</h3>';
        $adevolver .= '<div class="clear"></div>';
        
        
        if ($EsEditable > 0 || $_SESSION['es_admin'] > 0) { 
        
          $adevolver .= '<div class="derechaCursor" onclick="AfegirCuestion('.$rowCuestiones['id'].', '.$TienePermiso.')" >';
          $adevolver .= '<img src="../imagenes/FlechaSumaRoja.gif" alt="Punto vinyeta" width="20" height="20">';
          $adevolver .= '  Nueva Cuestión';
          $adevolver .= '</div>'; //..derecha
        
        }
        
        
        $adevolver .= '</div>';
   
	} //while rowCuestiones
}
mysqli_free_result($resCuestiones); 
 //vemos los mensajes de esta cuestión con parent =0
 $FormatMensajes = "SELECT id, id_alumno, cuestion, fecha_alta, esta_cerrada, veces_visitada, num_mensajes
                      FROM foroscuestiones
                     WHERE esta_activo >0
                       and id_forostemas = %d
                     ORDER BY fecha_alta";
$queMensajes = sprintf($FormatMensajes,$id);
$resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
$totMensajes = mysqli_num_rows($resMensajes);     
if ($totMensajes > 0){
    $adevolver .= '<div class="forotema">';
    $adevolver .= '<div class="forotemalinea"><p><b>CUESTIONES:</b></p></div>';
	while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
        if ($rowMensajes['esta_cerrada'] == 0) {
            $Candado = "CandadoAbierto.gif";
        } else {
            $Candado = "CandadoCerrado.gif";
        }
        $adevolver .= '<A NAME="C'.$rowMensajes['id'].'"></A>';
        $adevolver .= '<div class="forotemalinea" onclick="VerCuestion('.$rowMensajes['id'].','.$TienePermiso.')">';
        if ($_SESSION['es_admin'] > 0) {
          $adevolver .= '<p class="foroclasenumtema"> Visitas: '.$rowMensajes['veces_visitada'].'</p>';   
        }
        $adevolver .= '<p class="foroclasefecha">' .$rowMensajes['fecha_alta'].'</p>';
        $adevolver .= '<p class="foroclasenumAlumno">'.BuscaAlumno($rowMensajes['id_alumno'],$conexion).'</p>';
        $adevolver .= '<div class="clear"></div>';
        
        $adevolver .= '<div class="forotemalinea" >'; 
        $adevolver .= '<div class="MensajeRecLinea02"><img src="../imagenes/'.$Candado.'" alt= "Candado" width="35" height="35" /></div>';
        $adevolver .= '<div class="MensajeRecLinea0390"><h2 class="forocuestionLista">'.$rowMensajes['cuestion'].'</h2></div>';     
        $adevolver .= "</div>"; //...forotemalinea   
        $adevolver .= '</div>'; //forotemalinea
	}
   
    $adevolver .= '</div>'; //forotema  
}
mysqli_free_result($resMensajes);  
    
return $adevolver;   
}   
//....................................................................
function BloqueadoAContestar($id_alumno,$conexion) {
$bloquear = 0;
$FormatAlumnos = "SELECT bloquear_foro FROM vtalumnos where id = %d";
$queAlumnos = sprintf($FormatAlumnos,$id_alumno);
$resAlumnos = mysqli_query($conexion, $queAlumnos) or die(mysqli_error($conexion));  
$totAlumnos = mysqli_num_rows($resAlumnos);     
if ($totAlumnos > 0){
	while ($rowAlumnos = mysqli_fetch_assoc($resAlumnos)) {
		$bloquear = $rowAlumnos['bloquear_foro']; 
	}
}
mysqli_free_result($resAlumnos);  
return $bloquear;        
}
//.............................................
function AltaMensaje($mensajeParent,$numCuestion,$conexion){
    $NumeroMensaje = 0;
    $FormatAlta = "INSERT INTO forosmensajes (id_foroscuestiones, id_alumno, mensaje, fecha_alta, esta_activo, parent,fecha_baja)
                         VALUES (%d,%d,'%s','%s',1,%d,NULL);";
    
    $queAlta = sprintf($FormatAlta,$numCuestion,$_SESSION['NumeroUsuario'],LimpiaNoise_P($_REQUEST['noise']),date("Y-m-d"),$mensajeParent);
    
    //echo "<BR />@@@queTemas AltaMensaje 1-1>".$queAlta;
    
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    
    mysqli_free_result($resAlta); 
    
    //.................................................averiguar ID asignada
    $FormatMensajes = "SELECT max(id) AS ULTIMAID
                       FROM forosmensajes";
    $queMensajes = $FormatMensajes;
    $resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
    $totMensajes = mysqli_num_rows($resMensajes);     
    if ($totMensajes > 0){
	   while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
		  $NumeroMensaje = $rowMensajes['ULTIMAID']; 	 	         
	   }
    }
    mysqli_free_result($resMensajes); 
    
    //.......................................actualizar numero de mensajes
    ActualizaNumMensajes($numCuestion,$conexion);
    return $NumeroMensaje;
}

//...............................................
function LimpiaNoise_P($noise){
$cadena =   str_replace("<p>","",$noise);
$cadenaf =   str_replace("</p>","\r\n",$cadena); 
$cadenaf = trim($cadenaf);
$cadenaf = str_replace("\t","",$cadenaf); 
$cadenaf = str_replace("<div>","",$cadenaf); 
$cadenaf =   str_replace("</div>","\r\n",$cadenaf); 
return $cadenaf;    
    
}
//...............................................
function ActualizaNumMensajes($cuestion,$conexion) {
$numero= 0;
$FormatTemas = "SELECT count(id) AS CONTADOR
                  FROM forosmensajes
                 WHERE (forosmensajes.fecha_baja IS NULL OR YEAR(forosmensajes.fecha_baja) = 0  OR forosmensajes.fecha_baja >= CURDATE())
                   and forosmensajes.esta_activo = 1 
                   and id_foroscuestiones = %d ";
$queTemas = sprintf($FormatTemas,$cuestion);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$numero = $rowTemas['CONTADOR'];
	}
}
mysqli_free_result($resTemas); 

$FormatTemas = "UPDATE foroscuestiones set num_mensajes = %d WHERE id= %d";
$queTemas = sprintf($FormatTemas,$numero,$cuestion);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas); 
    
$FormatTemas = "UPDATE vtalumnos set mensajes_foro = mensajes_foro +1  WHERE id= %d";
$queTemas = sprintf($FormatTemas,$_SESSION['NumeroUsuario']);   
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas);   
}
//..............................................
function MensajeCorto($texto,$long){
    $largo = strlen($texto);
    return ($largo < $long ? true : false);
}

//.............................................
function MensajeCensurado($texto,$conexion){
    //...contiene palabras inadecuadas
    //...contiene password
    //...contiene correo electrónico
    //...es corto y no lo ha cambiado
    $palabrasInadecuadas = array();
    array_push($palabrasInadecuadas, "cabron");
    array_push($palabrasInadecuadas, "cabrón");
    array_push($palabrasInadecuadas, "maricón");
    array_push($palabrasInadecuadas, "maricon");
    array_push($palabrasInadecuadas, "terrorismo");
    array_push($palabrasInadecuadas, "islam");
    array_push($palabrasInadecuadas, "isis");
    array_push($palabrasInadecuadas, "puta");
    array_push($palabrasInadecuadas, "hijoputa");
    array_push($palabrasInadecuadas, "cojones");
    array_push($palabrasInadecuadas, "follar");
    $FormatAlumnos = "SELECT email, telefono, pwd FROM  vtalumnos where id = %d";
    $queAlumnos = sprintf($FormatAlumnos,$_SESSION['NumeroUsuario']);
    $resAlumnos = mysqli_query($conexion, $queAlumnos) or die(mysqli_error($conexion));  
    $totAlumnos = mysqli_num_rows($resAlumnos);     
      if ($totAlumnos > 0){
	   while ($rowAlumnos = mysqli_fetch_assoc($resAlumnos)) {
           array_push($palabrasInadecuadas, $rowAlumnos['telefono']);
           array_push($palabrasInadecuadas, $rowAlumnos['pwd']);
           $palabrasEmail = explode ( "@" , $rowAlumnos['email'] );
           array_push($palabrasInadecuadas, $palabrasEmail [0]);
        
	   }
      }
    mysqli_free_result($resAlumnos); 
    $texto = str_replace("<"," <",$texto);
    $texto = str_replace(">","> ",$texto);
    $palabras = explode ( " " , $texto );
    for ($i=0;$i<count($palabras);$i++) {
        
        if( trim($palabras [$i]) == "" ) {
            continue;
        }
        
        if (TieneFormatoEmail($palabras [$i])){
            return true;
        }
        if (TieneArroba($palabras [$i])){
            return true; 
        }
        for ($x=0;$x<count($palabrasInadecuadas);$x++){
           if (strpos(strtolower("..".$palabras [$i]),strtolower($palabrasInadecuadas[$x]) ) > 0) {
            return true;  
           } 
        }
        
    }
    return false; 
}
function TieneFormatoEmail($texto){
    $regex = "/[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/";
    return (preg_match($regex, $texto) == 0 ? false : true);
}
function TieneArroba($texto){
    $regex = "@";
    return (strpos('algunacosa'.$texto,$regex) < 1  ? false : true);
}
//.............................................
function AltaCuestion($numTema,$conexion){
    $NumeroCuestion = 0;
    
    //echo "<BR />@@@queTemas Entro en AltaCuestion 1->";
    $FormatAlta = "INSERT INTO foroscuestiones (id_forostemas, id_alumno, cuestion, fecha_alta, esta_activo, num_mensajes,fecha_baja)
                         VALUES (%d,%d,'%s','%s',1,1,NULL);";
    
    $queAlta = sprintf($FormatAlta,$numTema,$_SESSION['NumeroUsuario'],LimpiaNoise_P($_REQUEST['descri_cuestion']),date("Y-m-d"));
    
    //echo "<BR />@@@queTemas AltaCuestion 1-1>".$queAlta;
    
    $resAlta = mysqli_query($conexion, $queAlta) or die(mysqli_error($conexion));
    
    mysqli_free_result($resAlta); 
    
    //.................................................averiguar ID asignada
    $FormatMensajes = "SELECT max(id) AS ULTIMAID
                       FROM foroscuestiones";
    $queMensajes = $FormatMensajes;
    $resMensajes = mysqli_query($conexion, $queMensajes) or die(mysqli_error($conexion));  
    $totMensajes = mysqli_num_rows($resMensajes);     
    if ($totMensajes > 0){
	   while ($rowMensajes = mysqli_fetch_assoc($resMensajes)) {
		  $NumeroCuestion = $rowMensajes['ULTIMAID']; 	 	         
	   }
    }
    mysqli_free_result($resMensajes); 
    //.......................................alta del mensaje
    AltaMensaje(0,$NumeroCuestion,$conexion);
    //.......................................actualizar numero de cuestiones
    ActualizaNumCuestiones($numTema,$conexion);
    //Borrame_Actualiza2NumCuestiones($numTema,$conexion);
    return $NumeroCuestion;    
}


//...............................................
function ActualizaNumCuestiones($tema,$conexion) {
$numero= 0;
$FormatTemas = "SELECT count(id) AS CONTADOR
                  FROM foroscuestiones
                 WHERE (foroscuestiones.fecha_baja IS NULL OR YEAR(foroscuestiones.fecha_baja) = 0  OR foroscuestiones.fecha_baja >= CURDATE())
                   and foroscuestiones.esta_activo = 1 
                   and id_forostemas = %d ";
$queTemas = sprintf($FormatTemas,$tema);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$numero = $rowTemas['CONTADOR'];
	}
}
mysqli_free_result($resTemas); 

$FormatTemas = "UPDATE forostemas set num_cuestiones = %d WHERE id= %d";
$queTemas = sprintf($FormatTemas,$numero,$tema);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas); 
    
$FormatTemas = "UPDATE vtalumnos set mensajes_foro = mensajes_foro +1  WHERE id= %d";
$queTemas = sprintf($FormatTemas,$_SESSION['NumeroUsuario']);   
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas); 
}

?>

